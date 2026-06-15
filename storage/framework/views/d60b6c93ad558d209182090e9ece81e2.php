
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITSM Portal - User Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f4f6f9;
            color: #333;
            min-height: 100vh;
        }

        /* Top Navigation Header */
        header {
            background: #0c369a;
            color: white;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .logo-area h2 {
            font-size: 22px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .back-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            text-decoration: none;
            padding: 8px 18px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            transition: background 0.3s;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Main Portal Layout Container */
        .container {
            max-width: 1000px; /* Increased to fit dashboard metrics tables beautifully */
            margin: 40px auto;
            padding: 0 20px;
        }

        .ticket-card {
            background: #ffffff;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            text-align: center;
            display: flex;
            flex-direction: column; 
            align-items: center;    
            gap: 15px;              
            margin: 20px 0;
        }

        .ticket-card h1 {
            font-size: 24px;
            color: #222;
            margin-bottom: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .ticket-card p.subtitle {
            color: #777;
            font-size: 14px;
            margin-bottom: 25px;
        }

        /* Workspace Buttons Menu Layout Stack */
        .workspace-options {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            width: 100%;
            max-width: 320px;
        }

        /* Action Buttons Styling */
        .create-trigger-btn, .create-raised-btn, .create-status-btn {
            width: 100%;
            color: white;
            border: none;
            padding: 15px 35px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 30px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .create-trigger-btn {
            background: #59c20e;
            box-shadow: 0 5px 15px rgba(89, 194, 14, 0.3);
        }
        .create-trigger-btn:hover {
            background: #0eb72a;
            transform: translateY(-2px);
        }

        .create-raised-btn {
            background: #ce731e;
            box-shadow: 0 5px 15px rgba(206, 115, 30, 0.3);
        }
        .create-raised-btn:hover {
            background: #9a240c;
            transform: translateY(-2px);
        }

        .create-status-btn {
            background: #3ac9c9;
            box-shadow: 0 5px 15px rgba(58, 201, 201, 0.3);
        }
        .create-status-btn:hover {
            background: #1da3a3;
            transform: translateY(-2px);
        }

        /* Custom Back Button Styling inside Subsections */
        .panel-back-btn {
            background: #6c757d;
            color: white;
            border: none;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 500;
            border-radius: 6px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 20px;
            transition: background 0.2s;
        }
        .panel-back-btn:hover {
            background: #5a6268;
        }

        /* Hide the container elements by default */
        #ticketFormContainer, #raisedTicketsSection {
            display: none;
            width: 100%;
            text-align: left; 
            margin-top: 20px;
            border-top: 1px solid #e2e8f0;
            padding-top: 30px;
        }

        /* Form Controls Styling */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        @media (max-width: 600px) {
            .form-row { grid-template-columns: 1fr; }
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 500;
            color: #555;
        }

        .form-group input[type="text"],
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 15px;
            color: #333;
            outline: none;
            transition: all 0.3s;
        }

        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            border-color: #1e56ce;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(30, 86, 206, 0.15);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .file-upload-box {
            border: 2px dashed #cbd5e1;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            background: #f8fafc;
            cursor: pointer;
        }

        .submit-btn {
            background: #28a745;
            color: white;
            border: none;
            padding: 14px 30px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2);
        }

        .submit-btn:hover { background: #218838; }

        /* KPI Counter Boxes */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .stat-box {
            padding: 15px 20px;
            border-radius: 10px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .stat-box.total { background: #475569; }
        .stat-box.open { background: #28a745; }
        .stat-box.resolved { background: #0c369a; }

        .stat-info h3 { font-size: 11px; text-transform: uppercase; font-weight: 500; opacity: 0.9; }
        .stat-info p { font-size: 24px; font-weight: 700; }
        .stat-box i { font-size: 28px; opacity: 0.3; }

        /* Issues Tracking Grid Data Table */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #ffffff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f8fafc;
            color: #475569;
            padding: 12px 16px;
            font-size: 13px;
            font-weight: 600;
            border-bottom: 2px solid #e2e8f0;
            text-align: left;
        }

        td {
            padding: 14px 16px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13.5px;
            text-align: left;
        }

        /* Badges */
        .badge {
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .badge.open { background: #eafaf1; color: #2da44e; }
        .badge.assigned { background: #eff6ff; color: #2563eb; }
        .badge.progress { background: #fff7ed; color: #c2410c; }
        .badge.resolved { background: #f0fdf4; color: #16a34a; }
        .badge.closed { background: #f3f4f6; color: #4b5563; }
        .badge.high { background: #fef2f2; color: #991b1b; }
        .badge.medium { background: #feebd7; color: #dd6b20; }
        .badge.low { background: #edf2f7; color: #4a5568; }

        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
            width: 100%;
            text-align: left;
        }


       
    .reopen-modal {
    display: none; 
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    align-items: center;
    justify-content: center;
}
.modal-content {
    background-color: #ffffff;
    padding: 25px;
    border-radius: 12px;
    width: 100%;
    max-width: 500px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    text-align: left;
}
.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    border-bottom: 1px solid #e2e8f0;
    padding-bottom: 10px;
}
.modal-header h3 {
    font-size: 18px;
    color: #ce731e;
}
.close-modal-btn {
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    color: #aaa;
}
.close-modal-btn:hover { color: #333; }

    </style>
</head>
<body>

    <header>
        <div class="logo-area">
            <h2>ITSM User Portal</h2>
        </div>
        <a href="<?php echo e(url('/login')); ?>" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i> Logout
        </a>
    </header>

    <div class="container">

        <?php if(session('success')): ?>
            <div class="alert-success">
                <i class="fa-solid fa-circle-check"></i> <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <div class="ticket-card">
            
            <div id="welcomeHeader">
                <h1>End User Services</h1>
                <p class="subtitle">Welcome to your user portal. Click below any of the options according to your requirement.</p>
            </div>

            <div class="workspace-options" id="menuButtonsGroup">
                <button class="create-trigger-btn" id="showFormBtn">
                    <i class="fa-solid fa-plus"></i> Create Ticket
                </button>

                <button class="create-raised-btn" id="showRaisedTickets">
                    <i class="fa-solid fa-ticket"></i> MyRaisedTickets
                </button>
                
                
            </div>

            <div id="ticketFormContainer">
                <button class="panel-back-btn btn-back-menu"><i class="fa-solid fa-arrow-left"></i> Back to Menu</button>
                
                <h2 style="font-size: 20px; margin-bottom: 20px; color:#333;"><i class="fa-solid fa-ticket" style="color:#28a745;"></i> New Ticket Details</h2>
               <form action="/tickets/store" method="POST" enctype="multipart/form-data">
                  <?php echo csrf_field(); ?>
   
                    <div class="form-row">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select id="category" name="category" required>
                                <option value="Application Issue" selected>Application Issue</option>
                                <option value="Hardware Failure">Hardware Failure</option>
                                <option value="Network/Wifi Connection">Network/Wifi Connection</option>
                                <option value="Account Access">Account Access</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="subcategory">Subcategory</label>
                            <select id="subcategory" name="subcategory" required>
                                <option value="Login Problem" selected>Login Problem</option>
                                <option value="Bug/Error Popup">Bug / Error Popup</option>
                                <option value="Slow Performance">Slow Performance</option>
                                <option value="Data Missing">Data Missing</option>
                                 <option value="Others">Others</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="priority">Priority Level</label>
                        <select id="priority" name="priority" required style="max-width: 50%;">
                            <option value="Low">Low - General Question</option>
                            <option value="Medium">Medium - Normal Incident</option>
                            <option value="High" selected>High - Critical Work Blocker</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="subject">Ticket Subject</label>
                        <input type="text" id="subject" name="subject" placeholder="Example: Unable to login to DVC Guesthouse Booking Portal" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Detailed Description of Issue</label>
                        <textarea id="description" name="description" placeholder="Example: Every time I enter my credentials into the portal login interface, it returns an error page..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Upload Screenshot (Optional)</label>
                        <div class="file-upload-box" onclick="document.getElementById('file-input').click();">
                            <i class="fa-solid fa-cloud-arrow-up" style="font-size:24px; color:#aaa; margin-bottom:5px;"></i>
                            <p style="font-size:13px; color:#666;">Click to upload files</p>
                            <input type="file" id="file-input" name="screenshot" accept="image/*" style="display: none;">
                        </div>
                    </div>

                    <div style="display: flex; justify-content: flex-end; margin-top: 20px;">
                        <button type="submit" class="submit-btn">
                            <i class="fa-solid fa-paper-plane"></i> Submit Ticket
                        </button>
                    </div>
                </form>
            </div>

            <div id="raisedTicketsSection">
                <button class="panel-back-btn btn-back-menu"><i class="fa-solid fa-arrow-left"></i> Back to Menu</button>
                
                <h2 style="font-size: 20px; margin-bottom: 20px; color:#333; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-list-check" style="color:#ce731e;"></i> My Raised Incident Log Overview
                </h2>

                <div class="stats-grid">
                    <div class="stat-box total">
                        <div class="stat-info">
                            <h3>Total Tickets</h3>
                            <p><?php echo e($totalCount); ?></p>
                        </div>
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <div class="stat-box open">
                        <div class="stat-info">
                            <h3>Open / Active</h3>
                            <p><?php echo e($openCount); ?></p>
                        </div>
                        <i class="fa-solid fa-folder-open"></i>
                    </div>
                    <div class="stat-box resolved">
                        <div class="stat-info">
                            <h3>Resolved</h3>
                            <p><?php echo e($resolvedCount); ?></p>
                        </div>
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>

                <div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th>Ticket ID</th>
                <th>Subject</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Created Date</th>
                <th>Action</th> 
                <th>Show Details</th>

            </tr>
            
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td style="font-weight: 600; color: #0c369a;">#INC-<?php echo e(sprintf('%03d', $ticket->Id)); ?></td>
                    <td>
                        <strong><?php echo e($ticket->Subject ?? $ticket->subject); ?></strong>
                        <div style="font-size: 11px; color:#777; margin-top:2px;">
                            <?php echo e($ticket->category_name); ?> &bull; <?php echo e($ticket->subcategory ?? 'General'); ?>

                        </div>
                    </td>
                    <td>
                        <span class="badge <?php echo e(strtolower($ticket->priority_name)); ?>">
                            <?php if(strtolower($ticket->priority_name) == 'high'): ?>
                                <i class="fa-solid fa-circle-exclamation"></i>
                            <?php endif; ?>
                            <?php echo e($ticket->priority_name); ?>

                        </span>
                    </td>
                    <td>
                        <span class="badge <?php echo e(strtolower(str_replace(' ', '-', $ticket->Status_name))); ?>">
                            <i class="fa-solid fa-circle-dot"></i> <?php echo e($ticket->Status_name); ?>

                        </span>
                    </td>
                    <td style="color:#666; font-size:12px;">
                        <?php echo e(date('d M Y, h:i A', strtotime($ticket->created_at))); ?>

                    </td>
                    <td>
    <?php if(str_contains(strtolower($ticket->Status_name), 'resolv')): ?>
        <div style="display: flex; gap: 8px; align-items: center;">
            
          <form action="<?php echo e(url('/user/tickets/close/'.$ticket->Id)); ?>" method="POST" style="margin: 0;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="badge resolved" style="background: #72ed8f; border: 1px solid #0f81290c; cursor: pointer; padding: 5px 10px;" onclick="return confirm('Are you sure the issue is completely fixed? This will permanently close the ticket.');">
                <i class="fa-solid fa-check"></i> Close Ticket
            </button>
        </form>

          <button type="button" class="badge open open-reopen-modal-btn" data-id="<?php echo e(Crypt::encryptString($ticket->Id)); ?>" style="background: #ce731e; border: 1px solid #9a240c; color: white; cursor: pointer; padding: 5px 10px;">
    <i class="fa-solid fa-arrow-rotate-left"></i> Reopen Ticket
</button>
        </div>
    <?php else: ?>
        <span style="color: #aaa; font-size: 12px; font-style: italic;">No Action</span>
    <?php endif; ?>
</td>
       <td>
    <a href="<?php echo e(url('user/tickets/show/' . urlencode(Crypt::encryptString($ticket->Id ?? $ticket->Id)))); ?>" class="btn-show-details" style="display: inline-flex; align-items: center; gap: 6px; background-color: #0c369a; color: white; padding: 6px 12px; border-radius: 4px; font-size: 12px; text-decoration: none; font-weight: 500;">
        <i class="fa-solid fa-eye"></i> View
    </a>
</td>


</tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" style="text-align: center; color: #a0aec0; padding: 40px;">
                        You have not submitted any service desk incident tracking rows yet.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
            </div>

        </div>

        <div id="reopenModal" class="reopen-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fa-solid fa-arrow-rotate-left"></i> Reopen Ticket Requirements</h3>
            <button type="button" class="close-modal-btn" id="closeModal">&times;</button>
        </div>
        <form id="reopenForm" action="" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label for="reopen_comments" style="font-weight: 600;">Why are you reopening this ticket? (Comment required)</label>
                <textarea id="reopen_comments" name="reopen_comments" placeholder="Please describe what parts of the solution didn't work..." required></textarea>
            </div>

            <div class="form-group">
                <label style="font-weight: 600;">Attach Error Screenshot (Optional)</label>
                <div class="file-upload-box" onclick="document.getElementById('reopen-file-input').click();">
                    <i class="fa-solid fa-cloud-arrow-up" style="font-size:24px; color:#aaa; margin-bottom:5px;"></i>
                    <p id="reopen-file-text" style="font-size:13px; color:#666;">Click to upload files</p>
                    <input type="file" id="reopen-file-input" name="reopen_screenshot" accept="image/*" style="display: none;">
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button type="button" class="panel-back-btn" id="cancelModal" style="margin-bottom:0;">Cancel</button>
                <button type="submit" class="submit-btn" style="background:#ce731e; box-shadow:none;">
                    <i class="fa-solid fa-paper-plane"></i> Submit Reopen
                </button>
            </div>
        </form>
    </div>
</div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Grab navigation controls
    const createTicketBtn = document.getElementById('showFormBtn');
    const raisedTicketsBtn = document.getElementById('showRaisedTickets');
    const ticketStatusBtn = document.getElementById('showTicketStatus');
    const backMenuBtns = document.querySelectorAll('.btn-back-menu');
    
    // 2. Grab container wrappers
    const menuButtonsGroup = document.getElementById('menuButtonsGroup');
    const welcomeHeader = document.getElementById('welcomeHeader');
    const ticketFormContainer = document.getElementById('ticketFormContainer');
    const raisedTicketsSection = document.getElementById('raisedTicketsSection');

    // Action A: Create Ticket Button Click Event
    if (createTicketBtn) {
        createTicketBtn.addEventListener('click', function() {
            ticketFormContainer.style.display = 'block';
            raisedTicketsSection.style.display = 'none';
            menuButtonsGroup.style.display = 'none';
            welcomeHeader.style.display = 'none';
        });
    }

    // Action B: MyRaisedTickets Button Click Event
    if (raisedTicketsBtn) {
        raisedTicketsBtn.addEventListener('click', function() {
            raisedTicketsSection.style.display = 'block';
            ticketFormContainer.style.display = 'none';
            menuButtonsGroup.style.display = 'none';
            welcomeHeader.style.display = 'none';
        });
    }

    // Action C: Ticket Status Route Redirect Match Handler
    if (ticketStatusBtn) {
        ticketStatusBtn.addEventListener('click', function() {
            window.location.href = "<?php echo e(url('/ticket-status')); ?>";
        });
    }

    // Action D: Return to Panel Selection Main View Grid
    backMenuBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            ticketFormContainer.style.display = 'none';
            raisedTicketsSection.style.display = 'none';
            menuButtonsGroup.style.display = 'flex';
            welcomeHeader.style.display = 'block';
            
            // Clean URL query parameter strings cleanly when returning manually back to menu selection grid
            const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
            window.history.pushState({ path: newUrl }, '', newUrl);
        });
    });

    // Automatically update name of uploaded screenshot inside custom dashboard layout box
    const fileInput = document.getElementById('file-input');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const boxText = this.closest('.file-upload-box').querySelector('p');
                boxText.textContent = "Selected: " + this.files[0].name;
                boxText.style.color = "#28a745";
                boxText.style.fontWeight = "500";
            }
        });
    }
     

    // =======================================================
    // Reopen Window Functions
    // =======================================================
    const reopenModal = document.getElementById('reopenModal');
    const reopenForm = document.getElementById('reopenForm');
    const closeModalBtn = document.getElementById('closeModal');
    const cancelModalBtn = document.getElementById('cancelModal');
    const reopenFileInput = document.getElementById('reopen-file-input');
    const reopenFileText = document.getElementById('reopen-file-text');

    // Watch for row button clicks to assign correct IDs and trigger modal visibility
    document.querySelectorAll('.open-reopen-modal-btn').forEach(button => {
        button.addEventListener('click', function() {
            const ticketId = this.getAttribute('data-id');
            reopenForm.action = "/tickets/reopen/" + ticketId; // Directs to your controller route path
            reopenModal.style.display = 'flex';
        });
    });

    // Close window event links
    if(closeModalBtn) closeModalBtn.addEventListener('click', () => reopenModal.style.display = 'none');
    if(cancelModalBtn) cancelModalBtn.addEventListener('click', () => reopenModal.style.display = 'none');
    window.addEventListener('click', (e) => { if (e.target === reopenModal) reopenModal.style.display = 'none'; });

    // Handle file input text updates inside custom box element UI
    if (reopenFileInput) {
        reopenFileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                reopenFileText.textContent = "Selected: " + this.files[0].name;
                reopenFileText.style.color = "#28a745";
                reopenFileText.style.fontWeight = "500";
            }
        });
    }

    // =======================================================
    // FIX: AUTO-DETECT URL INBOUND STATE OVERRIDE FLAG
    // =======================================================
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('section') === 'raised') {
        if (raisedTicketsBtn) {
            // Programmatically trigger a click to force-open your raised tickets view component layout element state
            raisedTicketsBtn.click();
        }
    }
});
</script>
</body>
</html><?php /**PATH C:\internship\project1\resources\views/user_dash.blade.php ENDPATH**/ ?>