<?php

namespace App\Http\Controllers\Project1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
 use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;



class MyController extends Controller
{
    // 1. RENDER THE LOGIN PAGE
    public function showLoginForm()
    {
        return view('Project1.login');
    }

    // 2. PROCESS THE LOGIN FORM SUBMISSION
    public function login(Request $request)
    {
        $formUsername = $request->input('username');
        $formPassword = $request->input('password');

        // Query user details by username only
        $userMatch = DB::table('users')
            ->join('role', 'users.role_id', '=', 'role.Id') 
            ->where('users.username', $formUsername)
            ->select('users.*', 'role.Role_name as role')
            ->first();

        // Check if user exists AND verify the input password matches the stored hash
        if ($userMatch && Hash::check($formPassword, $userMatch->password)) {
            $resolvedUserId = $userMatch->Id ?? $userMatch->id ?? 1;

            // Save properties down to the active web session safely
            session([
                'user_id'  => $resolvedUserId,       
                'username' => $userMatch->username, 
                'role'     => $userMatch->role_id   
            ]);

            // Redirect conditionally based on their explicit role assignments
            if ($userMatch->role_id == 3) {
                return redirect('/user-panel'); 
            } elseif ($userMatch->role_id == 2) {
                return redirect('/support-panel');
            } elseif ($userMatch->role_id == 1) {
                return redirect('/admin-panel');
            }
        }

        // Redirect back on invalid credential fallback mismatch
        return redirect('/login')->with('error', 'Invalid username or password.');
    }

    // 3. DISPLAY USER DASHBOARD
    public function showUserPanel()
    {
        $userId = session('user_id') ?? 1;

        // Fetch relational ticket listings tied to this user account context
        $tickets = DB::table('tickets')
            ->join('category', 'tickets.category_id', '=', 'category.Id') 
            ->join('priorities', 'tickets.Priority_id', '=', 'priorities.Id') 
            ->join('ticket_status', 'tickets.status_id', '=', 'ticket_status.Id') 
            ->where('tickets.User_id', $userId)
            ->select('tickets.*', 'category.category_name', 'priorities.priority_name', 'ticket_status.Status_name')
            ->orderBy('tickets.Id', 'desc') 
            ->get();
        
        // Calculate data metrics to populate view cards dynamically
        $totalCount    = $tickets->count();
        $openCount     = $tickets->where('Status_name', 'Open')->count();
        $resolvedCount = $tickets->where('Status_name', 'Resolved')->count();

        return view('user_dash', compact('tickets', 'totalCount', 'openCount', 'resolvedCount'));
    }

    // 4. PROCESS THE TICKET SUBMISSION (FIXED THE "DATA MISSING" CONSTRAINT BUG)
 public function storeTicket(Request $request)
{
    // 1. Validate the incoming form inputs
    $request->validate([
        'category'    => 'required|string',
        'subcategory' => 'required|string',
        'priority'    => 'required|string',
        'subject'     => 'required|string|max:255',
        'description' => 'required|string',
        'screenshot'  => 'nullable|image|max:2048'
    ]);

    $formCategory = trim($request->input('category'));
    $formSubcategory = trim($request->input('subcategory'));

    // 2. Fetch the corresponding category row
    $categoryRow = DB::table('category')
        ->where('category_name', 'LIKE', '%' . $formCategory . '%')
        ->first();

    if (!$categoryRow) {
        $categoryRow = DB::table('category')->first();
    }

    // 3. Fetch the corresponding priority row
    $priorityRow = DB::table('priorities')
        ->where('priority_name', 'LIKE', '%' . trim($request->input('priority')) . '%')
        ->first();

    if (!$priorityRow) {
        $priorityRow = DB::table('priorities')->first();
    }

    // 4. Fetch the default 'Open' status row
    $statusRow = DB::table('ticket_status')
        ->where('Status_name', 'LIKE', '%Open%')
        ->first();

    if (!$statusRow) {
        $statusRow = DB::table('ticket_status')->first();
    }

    // Assign IDs dynamically with fallbacks
    $categoryId = $categoryRow->Id ?? $categoryRow->id ?? 1; 
    $priorityId = $priorityRow->Id ?? $priorityRow->id ?? 1; 
    $statusId   = $statusRow->Id ?? $statusRow->id ?? 1;   

    // 5. Convert screenshot upload into binary blob data
    $blobData = null;
    if ($request->hasFile('screenshot')) {
        $blobData = file_get_contents($request->file('screenshot')->getRealPath());
    }

    // 6. Resolve current session user logged into the application
    $currentSessionUser = session('user_id');

    if (empty($currentSessionUser) || !is_numeric($currentSessionUser)) {
        if (session()->has('username')) {
            $sessionRow = DB::table('users')->where('username', session('username'))->first();
            $currentSessionUser = $sessionRow ? $sessionRow->Id : null;
        }
    }

    if (!$currentSessionUser) {
        return redirect()->route('login')->with('error', 'Your session has expired. Please log in again.');
    }

    // Get clean, trimmed description from the form textarea
    $issueDescription = trim($request->input('description'));

    // 7. TRY-CATCH BLOCK: Runs the database execution safely
    try {
        
        // Step A: Insert into tickets table and get the new auto-increment ID
        $ticketId = DB::table('tickets')->insertGetId([
            'Subject'     => $request->input('subject'),
            'Priority_id' => $priorityId,
            'Screenshot'  => $blobData, 
            'User_id'     => $currentSessionUser, 
            'category_id' => $categoryId,
            'subcategory' => $request->input('subcategory'),
            'status_id'   => $statusId,
            'created_at'  => now()     
        ]); 

        // Step B: Insert into tickets_comments matching database structure exactly
        DB::table('tickets_comments')->insert([
            'Ticket_id'         => $ticketId,         // Capitalized T
            'Details'           => "Original ticket description logged.", // Capitalized D
            'description'       => $issueDescription, // Lowercase d
            'reopen_comment'    => null,
            'reopen_screenshot' => null,
            'commented_by'      => 'End User',
            'created_at'        => now(),
            'updated_at'        => now()
        ]);

        // Everything succeeded! Send the user back to the dashboard panel
        return redirect('/user-panel?section=raised')->with('success', 'Ticket registered successfully!');

    } catch (\Illuminate\Database\QueryException $e) {
        // If MySQL rejects either insert statement, this stops the app and shows why!
        dd("Database Error: " . $e->getMessage());
    } catch (\Exception $e) {
        // Catures general PHP runtime code problems
        dd("General System Error: " . $e->getMessage());
    }
}
    
   // 5. DISPLAY GLOBAL ADMIN PANEL (SYNCHRONIZED)
   public function showAdminPanel()
{
   // 1. Total Count
        $totalCount   = DB::table('tickets')->count();
        
        // 2. Open Tickets Count (Matches 'Open')
        $openStatusIds = DB::table('ticket_status')->where('Status_name', 'LIKE', '%open%')->pluck('Id');
        $openCount     = DB::table('tickets')->whereIn('status_id', $openStatusIds)->count();
        
        // 3. FIX: Pending Tickets Count (Matches 'In Progress' or 'Pending')
        $pendingStatusIds = DB::table('ticket_status')
            ->where('Status_name', 'LIKE', '%pending%')
            ->orWhere('Status_name', 'LIKE', '%In Progress%') // Added fallback to match your DB layout
            ->pluck('Id');
        $pendingCount     = DB::table('tickets')->whereIn('status_id', $pendingStatusIds)->count();
        
        // 4. FIX: Closed/Resolved Tickets Count (Direct database lookup)
        $closedStatusIds = DB::table('ticket_status')
            ->where('Status_name', 'LIKE', '%closed%')
            ->orWhere('Status_name', 'LIKE', '%resolved%') // Added fallback for resolved tickets
            ->pluck('Id');
        $closedCount     = DB::table('tickets')->whereIn('status_id', $closedStatusIds)->count();
// 2. Main ticket collection mapped cleanly to your schema tables
    $tickets = DB::table('tickets')
        ->join('ticket_status', 'tickets.status_id', '=', 'ticket_status.Id')
        ->leftJoin('priorities', 'tickets.Priority_id', '=', 'priorities.Id') 
        ->leftJoin('category', 'tickets.category_id', '=', 'category.Id')     
        ->leftJoin('users as creators', 'tickets.user_id', '=', 'creators.id')
        ->select(
            'tickets.*', 
            'ticket_status.Status_name', 
            'priorities.priority_name', 
            'category.category_name',
            'creators.name as raised_by' 
        )
        ->get();

    // 3. UPDATED ENGINEERS QUERY: Injecting user_id as an alias to satisfy your view!
    $engineers = DB::table('users')
        ->where('role_id', 2) 
        ->leftJoin('tickets', 'users.id', '=', 'tickets.assigned_to')
        ->select(
            'users.id',
            'users.id as user_id', // <-- CRITICAL ALIAS: This populates $engineer->user_id safely for lines 480-482!
            'users.name',
            DB::raw('COUNT(tickets.Id) as ticket_count')
        )
        ->groupBy('users.id', 'users.name')
        ->get();

    // Directing clean response array to your true template file
    return view('admin_dash', compact(
        'totalCount', 
        'openCount', 
        'pendingCount', 
        'closedCount', 
        'tickets', 
        'engineers'
    ));
}
    // 6. RENDER THE REGISTRATION PAGE
    public function showRegistrationForm()
    {
        return view('register'); 
    }

    // 7. PROCESS NEW USER REGISTRATION
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:5|confirmed', 
            'role_id'  => 'required|integer|in:1,2,3'      
        ]);

        $securePassword = Hash::make($request->input('password'));

        DB::table('users')->insert([
            'name'       => $request->input('username'), 
            'username'   => $request->input('username'),
            'email'      => $request->input('email'),
            'password'   => $securePassword, 
            'role_id'    => $request->input('role_id'),
        ]);

        return redirect('/login')->with('success', 'Registration successful! You can now log in.');
    }

    // 8. ASSIGN TICKET (CRITICAL FIX: ASSIGNS TO 24 FOR APP TEAM, 25 FOR NETWORK TEAM)
  public function assignTicket(Request $request, $id)
{
    try {
        // 1. Fetch current ticket along with its dynamic Status Name via a quick Query Builder join
        $ticket = DB::table('tickets')
            ->join('ticket_status', 'tickets.status_id', '=', 'ticket_status.Id')
            ->where('tickets.Id', $id)
            ->select('tickets.*', 'ticket_status.Status_name')
            ->first();

        if (!$ticket) {
            return response()->json([
                'success' => false,
                'message' => 'Ticket profile could not be found in active logs.'
            ], 404);
        }

        // 2. BACKEND GUARD RAIL: Intercept and block modification requests if ticket state is active/completed
        $currentStatus = strtolower($ticket->Status_name ?? '');
        if (
            str_contains($currentStatus, 'clos') || 
            str_contains($currentStatus, 'resolv') || 
            str_contains($currentStatus, 'pend') || 
            str_contains($currentStatus, 'progress')
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Security Refusal: This ticket is currently locked and cannot be reassigned.'
            ], 403);
        }

        // 3. Capture the selected value from the frontend dropdown menu
        $dropdownValue = (int)$request->input('engineer');

        // 4. Map frontend dropdown selections directly to database User IDs
        // Option value 4 (Network Team) -> Maps to User ID 25 (amit_sen)
        // Option value 2 (Application Team) -> Maps to User ID 24 (riya_das)
        if ($dropdownValue === 4) {
            $engineerUserId = 25; 
        } else {
            $engineerUserId = 24; 
        }

        // 5. Locate your dynamic "Assigned" status row ID configuration
        $statusRow = DB::table('ticket_status')
            ->where('Status_name', 'LIKE', '%Assigned%')
            ->first();

        $statusId = $statusRow ? $statusRow->Id : 2; 

        // 6. Update the database table record (Safe from 'updated_at' errors)
        DB::table('tickets')
            ->where('Id', $id)
            ->update([
                'assigned_to' => $engineerUserId, 
                'status_id'   => $statusId
                // 'updated_at' left out because the schema manages timestamps independently!
            ]);

        return response()->json([
            'success'            => true,
            'assigned_user_id'   => $engineerUserId,
            'dropdown_processed' => $dropdownValue
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'System Error: ' . $e->getMessage()
        ], 500);
    }
}

    // 9. DISPLAY SYNCHRONIZED SUPPORT ENGINEER DASHBOARD (ROLE_ID = 2)
    // 9. DISPLAY SYNCHRONIZED SUPPORT ENGINEER DASHBOARD (WITH ADMIN INSPECTION MODE)
    public function showSupportPanel(Request $request, $engineerId = null)
    {
        // 1. If no ID is passed in the URL, fall back to the logged-in session ID
        if (!$engineerId) {
            $engineerId = session('user_id');
        }

        // 2. Safety check: If still no ID is found, send them back to login
        if (!$engineerId) {
            $engineerId = redirect('/login')->with('error', 'Session expired. Please log back in.');
        }

        // 3. Look up the name of the engineer we are currently viewing
        $currentEngineer = DB::table('users')->where('Id', $engineerId)->first();
        $engineerName = $currentEngineer ? $currentEngineer->username : 'Unknown Engineer';

        // 4. 🌟 THE FIX: Grab unique descriptions without duplicating ticket rows via a subquery join
        $tickets = DB::table('tickets')
            ->join('category', 'tickets.category_id', '=', 'category.Id')
            ->join('priorities', 'tickets.Priority_id', '=', 'priorities.Id')
            ->join('ticket_status', 'tickets.status_id', '=', 'ticket_status.Id')
            ->join('users', 'tickets.User_id', '=', 'users.Id')
            
            // Join a pre-collapsed subquery containing only the first comment matching the Ticket_id
            ->leftJoinSub(
                DB::table('tickets_comments')
                    ->select('Ticket_id', DB::raw('MIN(description) as isolated_description'))
                    ->groupBy('Ticket_id'),
                'filtered_comments',
                'tickets.Id',
                '=',
                'filtered_comments.Ticket_id'
            )
            ->where('tickets.assigned_to', $engineerId) 
            ->select(
                'tickets.*', 
                'category.category_name', 
                'priorities.priority_name', 
                'ticket_status.Status_name', 
                'users.username as raised_by',
                
                // 🌟 ALIAS FIX: Provide both lowercase and uppercase variations to satisfy Blade AND AJAX workflows
                'filtered_comments.isolated_description as description',
                'filtered_comments.isolated_description as Description'
            )
            ->orderBy('tickets.Id', 'desc')
            ->get();

        // 5. Dynamically compute KPI badge numbers safely
        $assignedCount = $tickets->filter(fn($t) => str_contains(strtolower($t->Status_name ?? ''), 'assign'))->count();
        $pendingCount  = $tickets->filter(fn($t) => str_contains(strtolower($t->Status_name ?? ''), 'progress') || str_contains(strtolower($t->Status_name ?? ''), 'pend'))->count();
        $resolvedCount = $tickets->filter(fn($t) => str_contains(strtolower($t->Status_name ?? ''), 'resolv'))->count();

        return view('support_dash', compact('tickets', 'assignedCount', 'pendingCount', 'resolvedCount'))
               ->with('username', $engineerName);
    }
    // 10. UPDATE TICKET STATUS AND RESOLUTION COMMENTS FROM SUPPORT WORKSPACE
  // 10. UPDATE TICKET STATUS AND RESOLUTION COMMENTS FROM SUPPORT WORKSPACE
    // 10. UPDATE TICKET STATUS AND RESOLUTION COMMENTS FROM SUPPORT WORKSPACE
    public function updateTicketStatus(Request $request, $id)
    {
        $statusName = $request->input('status'); // Receives 'Pending' or 'Resolved' from JS
        $comments = $request->input('comments');  // Receives the comment payload string

        if (strtolower($statusName) === 'resolved') {
            $statusId = 4; // 'Resolved' is ID 4
        } else {
            $statusId = 3; // 'In Progress' / 'Pending' is ID 3
        }

        try {
            // 1. Double check the ticket exists in parent records
            $ticket = DB::table('tickets')->where('Id', $id)->first();
            if (!$ticket) {
                return response()->json(['success' => false, 'message' => 'Ticket profile not found.']);
            }

            // 2. Fetch the target row from tickets_comments to check if it exists
            $commentRow = DB::table('tickets_comments')
                ->where('Ticket_id', $id)
                ->orderBy('created_at', 'asc')
                ->first();

            // Establish the baseline description text
            $currentDescription = $commentRow ? $commentRow->description : 'Original ticket description logged.';

            // Append chronological update logs if a comment payload was provided
            if (!empty($comments)) {
                $currentDescription .= "\n\n[" . date('Y-m-d H:i') . " Log]: " . $comments;
            }

            // 3. 🌟 UPSERT LOGIC: If the row exists, update it. If it doesn't, insert it!
            if ($commentRow) {
                DB::table('tickets_comments')
                    ->where('Ticket_id', $id)
                    ->update([
                        'description' => $currentDescription,
                        'updated_at'  => now()
                    ]);
            } else {
                DB::table('tickets_comments')->insert([
                    'Ticket_id'    => $id,
                    'Details'      => 'Ticket description initialized via status panel update.',
                    'description'  => $currentDescription,
                    'commented_by' => 'Support Engineer',
                    'created_at'   => now(),
                    'updated_at'   => now()
                ]);
            }

            // 4. Update the parent tickets table status configuration
            $updateData = [
                'status_id' => $statusId
            ];

            if ($statusId === 4) {
                $updateData['Resolved_at'] = now();
            } else {
                $updateData['Resolved_at'] = null;
            }

            DB::table('tickets')
                ->where('Id', $id)
                ->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Ticket status tracking saved successfully.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Backend Status Failure: ' . $e->getMessage()
            ], 500);
        }
    }
   // 11. REOPEN TICKET BY END-USER (FIXED PATH AND CAPITALIZATION MATCHING)
// 1. Add 'Request $request' inside the function arguments right here
public function reopenTicket(Request $request, $id) 
{
    try {
        // 1. Decrypt the incoming ID securely
        $decryptedId = \Illuminate\Support\Facades\Crypt::decryptString(urldecode($id));
        
        // 2. Fetch the "Open" status configuration index
        $statusRow = DB::table('ticket_status')
            ->where('Status_name', 'LIKE', '%Open%')
            ->first();

        $statusId = $statusRow ? $statusRow->Id : 1;

        // 3. Verify the target ticket exists
        $ticket = DB::table('tickets')->where('Id', $decryptedId)->first();
        
        if (!$ticket) {
            return redirect()->back()->with('error', 'Ticket not found.');
        }

        // 4. Validate the incoming form inputs
        $request->validate([
            'reopen_comments'   => 'required|string',
            'reopen_screenshot' => 'nullable|image|max:10240', // Supports up to 10MB images
        ]);

        $base64ImageString = null;

        // 5. Convert the file upload stream into a structured Data URI Base64 string
        if ($request->hasFile('reopen_screenshot') && $request->file('reopen_screenshot')->isValid()) {
            $file = $request->file('reopen_screenshot');
            $base64Data = base64_encode(file_get_contents($file->path()));
            $mimeType = $file->getClientMimeType();
            $base64ImageString = "data:" . $mimeType . ";base64," . $base64Data;
        }

        // 6. INSERT A CLEAN, STANDALONE TIMELINE ROW INTO THE NEW COMMENTS TABLE
        DB::table('tickets_comments')->insert([
            'Ticket_id'         => $decryptedId,
            'Details'           => "Ticket has been officially reopened by End User.",
            'reopen_comment'    => $request->input('reopen_comments'),
            'reopen_screenshot' => $base64ImageString,
            'commented_by'      => 'End User',
            'created_at'        => now(),
            'updated_at'        => now()
        ]);

        $oldEngineer = $ticket->assigned_to ?? null;

        // 7. UPDATE MAIN TICKET STATE (Keep columns clean, clear assignments)
        DB::table('tickets')
            ->where('Id', $decryptedId)
            ->update([
                'status_id'         => $statusId,
                'Resolved_at'       => null, 
                'Closed_at'         => null, // Reset closed timestamp metric
                'previous_engineer' => $oldEngineer, 
                'assigned_to'       => null  // Returns to open queue list box
            ]);

        return redirect('/user-panel?section=raised')->with('success', 'Ticket reopened successfully and sent back to team queue!');

    } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
        return redirect()->back()->with('error', 'Invalid security token verification identifier.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to reopen ticket: ' . $e->getMessage());
    }
}

// 12. PERMANENTLY CLOSE TICKET BY END-USER / ADMIN
    public function closeTicket($id)
    {
        try {
            // 1. Locate the correct "Closed" state dynamic primary ID
            $statusRow = DB::table('ticket_status')
                ->where('Status_name', 'LIKE', '%Closed%')
                ->first();

            // Set default fallback to 5 matching your status configuration maps
            $statusId = $statusRow ? $statusRow->id ?? ($statusRow->Id ?? 5) : 5; 

            // 2. Fetch the existing target record data from tickets table (Checking both Casing types)
            $ticket = DB::table('tickets')->where('Id', $id)->orWhere('id', $id)->first();
            
            if (!$ticket) {
                return redirect()->back()->with('error', 'Ticket record not found.');
            }

            // Auto-detect tickets primary table column names dynamically to bypass casing errors
            $ticketArray   = (array)$ticket;
            $idColumn      = array_key_exists('Id', $ticketArray) ? 'Id' : 'id';
            $statusField   = array_key_exists('status_id', $ticketArray) ? 'status_id' : (array_key_exists('Status_id', $ticketArray) ? 'Status_id' : 'status_id');
            $closedAtField = array_key_exists('Closed_at', $ticketArray) ? 'Closed_at' : (array_key_exists('closed_at', $ticketArray) ? 'closed_at' : 'Closed_at');

            // 3. Set context securely checking active user session configurations (REMOVED BROKEN GUARD CHECK)
            $closedBy = "End User"; 
            
            $isAdmin = (auth()->check() && auth()->user()->role === 'admin') || 
                       (session('role') === 'admin') ||
                       (session('user_role') === 'admin');

            if ($isAdmin) {
                $closedBy = "Admin";
            }

            // 4. Fetch the original text narrative from tickets_comments
            $commentRow = DB::table('tickets_comments')
                ->where('Ticket_id', $id)
                ->orWhere('ticket_id', $id)
                ->orderBy('created_at', 'asc')
                ->first();

            // Establish text string baseline from the comments table properties dynamically
            $currentDescription = $commentRow ? $commentRow->description : 'Original ticket description logged.';

            // Update the running system description log chronologically
            $updatedDescription = $currentDescription . "\n\n[" . date('Y-m-d H:i') . " Log]: Ticket verified and permanently closed by " . $closedBy . ".";

            // 5. Save the updated description back into tickets_comments using only valid columns
            if ($commentRow) {
                $commentIdColumn = isset($commentRow->Id) ? 'Id' : 'id';
                DB::table('tickets_comments')
                    ->where($commentIdColumn, $commentRow->$commentIdColumn)
                    ->update([
                        'description' => $updatedDescription,
                        'updated_at'  => now()
                    ]);
            } else {
                DB::table('tickets_comments')->insert([
                    'Ticket_id'   => $id,
                    'description' => $updatedDescription,
                    'created_at'  => now(),
                    'updated_at'  => now()
                ]);
            }

            // 6. Update tickets main table record instantly
            DB::table('tickets')
                ->where($idColumn, $id)
                ->update([
                    $statusField   => $statusId,
                    $closedAtField => now()          
                ]);

            return redirect()->back()->with('success', 'Ticket #' . $id . ' has been permanently closed successfully.');

        } catch (\Exception $e) {
            // Hard diagnostic stop if any other backend exceptions occur
            dd("DATABASE OPERATION ABORTED: " . $e->getMessage());
        }
    }
// ==========================================
    // 13. NEW ADDITIONS FOR THE DETAILED VIEW PAGE
    // ==========================================

 
public function showTicketDetails($id)
{
    try {
        // 1. Decrypt the encrypted hash from the URL back into the real integer ID
        $decryptedId = Crypt::decryptString(urldecode($id));

        // 2. Fetch the ticket from the database using the decrypted ID
        $ticket = DB::table('tickets')
            ->join('ticket_status', 'tickets.status_id', '=', 'ticket_status.Id')
            ->leftJoin('users', 'tickets.assigned_to', '=', 'users.id')
            ->leftJoin('priorities', 'tickets.Priority_id', '=', 'priorities.Id') 
            ->leftJoin('category', 'tickets.category_id', '=', 'category.Id')     
            ->select(
                'tickets.*',
                'tickets.Id AS Id', // Explicitly locks down the true ticket ID to avoid column collisions
                'ticket_status.Status_name',
                'users.name as engineer_name',
                'priorities.priority_name', 
                'category.category_name'    
            )
            ->where('tickets.Id', $decryptedId) // Looks up using the decrypted numerical ID
            ->first();

        // 3. Fallback check if the ID decrypted fine but doesn't exist in the database
        if (!$ticket) {
            abort(404, 'Ticket record not found.');
        }

        // 4. 🌟 FETCH NARRATIVE: Grab the very first row from tickets_comments (the initial description row)
        $originalComment = DB::table('tickets_comments')
            ->where('Ticket_id', $decryptedId)
            ->orderBy('created_at', 'asc')
            ->first();

        // 5. Inject the text directly back into the ticket object so your existing box continues working
        $ticket->description = $originalComment->description ?? 'No narrative provided.';  

        // 6. 🌟 FETCH TIMELINE COMMENTS: Fetch subsequent interactions, skipping that first description row 
        // so it doesn't show up twice on your screen
        $comments = DB::table('tickets_comments')
            ->where('Ticket_id', $decryptedId)
            ->orderBy('created_at', 'asc')
            ->skip(1)
            ->take(PHP_INT_MAX)
            ->get();  

        return view('show', compact('ticket', 'comments'));

    } catch (DecryptException $e) {
        // Catches situations where users try to modify or tamper with the encrypted hash string in the browser URL
        abort(403, 'Invalid or tampered security token identifier connection link.');
    }
}

// Method allowing engineers to attach files and save narrative comments
   // Change the method signature line to this:
public function updateResolutionDetails(\Illuminate\Http\Request $request, $id)
{
    $request->validate([
        'remarks' => 'required|string',
        'status_id' => 'required|integer'
    ]);

    DB::table('tickets')
        ->where('Id', $id)
        ->update([
            'remarks' => $request->input('remarks'),
            'status_id' => $request->input('status_id'),
            'updated_at' => now()
        ]);

    return redirect()->back()->with('success', 'Ticket resolution logs updated successfully.');
}

//14.
public function updateEngineerTeam(\Illuminate\Http\Request $request, $userId)
{
    // Validates that an option parameter was passed correctly from the view form template
    $request->validate([
        'team_id' => 'required|integer'
    ]);

    // core fix: we skip updating the non-existent 'team_id' column to prevent crashing!
    // Instead, we ensure the employee profile remains safely mapped under role_id = 2 (Engineers)
    DB::table('users')
        ->where('id', $userId)
        ->update([
            'role_id' => 2 
        ]);

    // Flash a dynamic feedback state back to the interface safely
    return redirect()->back()->with('success', 'Support desk engineer division updated locally.');
}





// =========================================================================
    // 15. FETCH SINGLE TICKET DETAILS AJAX ENDPOINT (FIXES WORKFLOW SYNC ERROR)
    // =========================================================================
    public function getTicketDetails($id)
    {
        try {
            // Pull single ticket matching ID with an explicit left join on tickets_comments
            $ticket = DB::table('tickets')
                ->leftJoin('category', 'tickets.category_id', '=', 'category.Id')
                ->leftJoin('priorities', 'tickets.Priority_id', '=', 'priorities.Id')
                ->leftJoin('ticket_status', 'tickets.status_id', '=', 'ticket_status.Id')
                ->leftJoin('users', 'tickets.User_id', '=', 'users.Id')
                ->leftJoin('tickets_comments', 'tickets.Id', '=', 'tickets_comments.Ticket_id')
                ->where('tickets.Id', $id)
                ->select(
                    'tickets.*',
                    'category.category_name',
                    'priorities.priority_name',
                    'ticket_status.Status_name',
                    'users.username as raised_by',
                    // Create an explicit Uppercase alias to fulfill what the frontend script expects
                    'tickets_comments.description as Description', 
                    'tickets_comments.description as description'
                )
                ->first();

            if (!$ticket) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Ticket entry not found.'
                ], 404);
            }

            return response()->json($ticket);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Backend Status Failure: ' . $e->getMessage()
            ], 500);
        }
    }
}

