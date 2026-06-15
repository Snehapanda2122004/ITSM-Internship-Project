
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITSM Portal - Admin Dashboard</title>
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

        .back-btn:hover { background: rgba(255, 255, 255, 0.3); }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .admin-card {
            background: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }

        .dashboard-header h1 {
            font-size: 24px;
            color: #222;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dashboard-header h1 i { color: #0c369a; }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }

        @media (max-width: 900px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }

        .stat-box {
            padding: 20px;
            border-radius: 10px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-box.total { background: #475569; }
        .stat-box.open { background: #28a745; }
        .stat-box.pending { background: #ff9f43; }
        .stat-box.closed { background: #0c369a; }

        .stat-info h3 { font-size: 12px; text-transform: uppercase; opacity: 0.9; font-weight: 500; }
        .stat-info p { font-size: 26px; font-weight: 700; margin-top: 5px; }
        .stat-box i { font-size: 32px; opacity: 0.3; }

        .data-split-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
        }

        @media (max-width: 900px) {
            .data-split-layout { grid-template-columns: 1fr; }
        }

        .table-container h2, .user-count-container h2 {
            font-size: 18px;
            color: #1e293b;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background: #f8fafc;
            color: #475569;
            padding: 14px 16px;
            font-size: 13px;
            font-weight: 600;
            border-bottom: 2px solid #e2e8f0;
        }

        td {
            padding: 14px 16px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13.5px;
        }

        tr:hover { background-color: #f8fafc; }

        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .badge.priority-high { background: #fef2f2; color: #991b1b; }
        .badge.status-open { background: #eafaf1; color: #2da44e; }
        .badge.status-assigned { background: #eff6ff; color: #1e40af; }
        .badge.status-pending { background: #fff7ed; color: #ea580c; }

        .assign-btn {
            background: #1e56ce;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: background 0.2s;
        }

        .assign-btn:hover { background: #0c369a; }

        .user-count-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
        }

        .user-list-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .user-list-item:last-child { border-bottom: none; }
        
        .user-meta { display: flex; align-items: center; gap: 10px; }
        .user-meta i { color: #64748b; font-size: 16px; }
        .user-meta span { font-size: 14px; font-weight: 500; }

        .count-pill {
            background: #f1f5f9;
            color: #334155;
            font-size: 12px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 12px;
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 12px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 10px;
        }

        .modal-header h3 { font-size: 17px; color: #1e293b; }
        .close-modal { font-size: 22px; color: #94a3b8; cursor: pointer; border: none; background: none; }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 20px;
        }

        .form-group label { font-size: 13.5px; font-weight: 500; color: #475569; }
        .form-group select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background: #f8fafc;
            font-size: 14px;
            outline: none;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .cancel-btn {
            background: #f1f5f9;
            color: #475569;
            border: none;
            padding: 9px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13.5px;
        }

        .confirm-btn {
            background: #28a745;
            color: white;
            border: none;
            padding: 9px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13.5px;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo-area">
            <h2>ITSM Support Portal</h2>
        </div>
        <a href="<?php echo e(url('/login')); ?>" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i> Logout
        </a>
    </header>

    <div class="container">
        <div class="admin-card">
            
            <div class="dashboard-header" style="display: flex; align-items: center; width: 100%;">
                <h1><i class="fa-solid fa-user-gear"></i> Admin Dashboard</h1>
                
              

    <span style="font-size: 14px; color: #64748b; white-space: nowrap; margin-left: 10px;">Role: <strong>System Administrator</strong></span>
</div>
            </div>

            <div class="stats-grid">
                <div class="stat-box total">
                    <div class="stat-info">
                        <h3>Total Tickets</h3>
                        <p id="total-count"><?php echo e($totalCount); ?></p>
                    </div>
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <div class="stat-box open">
                    <div class="stat-info">
                        <h3>Open Tickets</h3>
                        <p id="open-count"><?php echo e($openCount); ?></p>
                    </div>
                    <i class="fa-solid fa-folder-open"></i>
                </div>
                <div class="stat-box pending">
                    <div class="stat-info">
                        <h3>Pending Tickets</h3>
                        <p id="pending-count"><?php echo e($pendingCount); ?></p>
                    </div>
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div class="stat-box closed">
                    <div class="stat-info">
                        <h3>Closed/Resolved Tickets</h3>
                        <p id="closed-count"><?php echo e($closedCount); ?></p>
                    </div>
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>

            <div class="data-split-layout">
                
                <div class="table-container">
                    <h2><i class="fa-solid fa-list-check"></i> Active Incident Queue</h2>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Ticket ID</th>
                                    <th>Subject</th>
                                    <th>Created At</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Assigned To</th>
                                    <th>View Details</th>
                                    <th>Action</th>
                                     <th>Close</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr id="ticket-row-<?php echo e($ticket->Id); ?>">
                                    <td style="font-weight: 600; color: #0c369a;">#INC-<?php echo e(sprintf('%03d', $ticket->Id)); ?></td>
                                    <td>
                                        <strong><?php echo e($ticket->Subject); ?></strong>
                                        <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                                            <?php echo e($ticket->category_name); ?> &bull; <?php echo e($ticket->subcategory ?? 'General'); ?> &bull; <span style="color:#0c369a;">By: <?php echo e($ticket->raised_by); ?></span>
                                        </div>
                                    </td>

                                      <td style="color:#666; font-size:12px;">
                        <?php echo e(date('d M Y, h:i A', strtotime($ticket->created_at))); ?>

                    </td>

                                    <td>
                                        <?php if(strtolower($ticket->priority_name) == 'high'): ?>
                                            <span class="badge priority-high"><i class="fa-solid fa-circle-exclamation"></i> High</span>
                                        <?php elseif(strtolower($ticket->priority_name) == 'medium'): ?>
                                            <span class="badge" style="background:#fef3c7; color:#d97706;"><i class="fa-solid fa-triangle-exclamation"></i> Medium</span>
                                        <?php else: ?>
                                            <span class="badge" style="background:#f1f5f9; color:#475569;"><i class="fa-solid fa-arrow-down"></i> Low</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if(strtolower($ticket->Status_name) == 'open'): ?>
                                            <span class="badge status-open" id="status-<?php echo e($ticket->Id); ?>"><i class="fa-solid fa-circle-dot"></i> Open</span>
                                        <?php elseif(strtolower($ticket->Status_name) == 'assigned'): ?>
                                            <span class="badge status-assigned" id="status-<?php echo e($ticket->Id); ?>"><i class="fa-solid fa-user-gear"></i> Assigned</span>
                                        <?php elseif(strtolower($ticket->Status_name) == 'pending' || strtolower($ticket->Status_name) == 'in progress'): ?>
                                            <span class="badge status-pending" id="status-<?php echo e($ticket->Id); ?>"><i class="fa-solid fa-clock"></i> Pending</span>
                                        <?php else: ?>
                                            <span class="badge" id="status-<?php echo e($ticket->Id); ?>)" style="background:#f1f5f9; color:#475569;"><i class="fa-solid fa-circle-check"></i> <?php echo e($ticket->Status_name); ?></span>
                                        <?php endif; ?>
                                    </td>
                                <td id="assignee-<?php echo e($ticket->Id); ?>">
    <?php if($ticket->assigned_to == 24): ?>
        <span class="badge" style="background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
            <i class="fa-solid fa-laptop-code"></i> Application Team
        </span>
    <?php elseif($ticket->assigned_to == 25): ?>
        <span class="badge" style="background: #fff7ed; color: #ea580c; border: 1px solid #ffedd5;">
            <i class="fa-solid fa-server"></i> Network Team
        </span>
    <?php elseif(!empty($ticket->assigned_to)): ?>
        <span class="badge bg-secondary text-white">
            <i class="fa-solid fa-user-shield"></i> Engineer (ID: <?php echo e($ticket->assigned_to); ?>)
        </span>
    <?php else: ?>
        <span style="color: #64748b; font-style: italic;">Unassigned</span>
    <?php endif; ?>
</td>

    <td>
    <a href="<?php echo e(url('admin/tickets/show/' . urlencode(Crypt::encryptString($ticket->Id ?? $ticket->Id)))); ?>" class="btn-show-details" style="display: inline-flex; align-items: center; gap: 6px; background-color: #0c369a; color: white; padding: 6px 12px; border-radius: 4px; font-size: 12px; text-decoration: none; font-weight: 500;">
        <i class="fa-solid fa-eye"></i> View
    </a>
</td>


       <td>
    <?php if(
        str_contains(strtolower($ticket->Status_name), 'clos') || 
        str_contains(strtolower($ticket->Status_name), 'resolv') || 
        str_contains(strtolower($ticket->Status_name), 'pend') ||
        str_contains(strtolower($ticket->Status_name), 'progress')
    ): ?>
        <button class="assign-btn" style="background: #cbd5e1; color: #64748b; border: 1px solid #cbd5e1; cursor: not-allowed;" disabled>
            <i class="fa-solid fa-lock"></i> Locked
        </button>
    <?php else: ?>
        <button class="assign-btn" onclick="openAssignmentModal('<?php echo e($ticket->Id); ?>')">
            <i class="fa-solid fa-user-plus"></i> Assign
        </button>
    <?php endif; ?>
</td>


<td style="text-align: center; vertical-align: middle;">
                                    <form action="<?php echo e(route('tickets.close', $ticket->Id)); ?>" 
                                          method="POST" 
                                          onsubmit="return confirm('Are you sure you want to permanently close Ticket #INC-<?php echo e(sprintf('%03d', $ticket->Id)); ?>? This action cannot be undone.');" 
                                          style="display: inline-block; margin: 0;">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger" 
                                                style="background-color: #dc2626; color: #ffffff; border: none; padding: 6px 12px; border-radius: 4px; font-weight: 600; font-size: 12px; display: inline-flex; align-items: center; gap: 4px; cursor: pointer; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: background 0.2s;"
                                                onmouseover="this.style.backgroundColor='#b91c1c'" 
                                                onmouseout="this.style.backgroundColor='#dc2626'">
                                            <i class="fa-solid fa-circle-xmark"></i> Close
                                        </button>
                                    </form>
                                </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" style="text-align: center; color: #a0aec0; padding: 30px;"> No support desk tickets found in system logs.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

      <div class="user-count-container">
    <h2><i class="fa-solid fa-users-gear"></i> Support Engineer Rosters</h2>
    <div class="user-count-card" style="padding: 15px; background: #fff; border: 1px solid #e2e8f0; border-radius: 8px;">
        
        <?php $__currentLoopData = $engineers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $engineer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="user-list-item" style="display: flex; flex-direction: column; align-items: flex-start; gap: 10px; padding: 15px 0; border-bottom: 1px solid #f1f5f9;">
            
            <div style="display: flex; justify-content: space-between; width: 100%; align-items: center;">
                <div class="user-meta" style="display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-user-shield" style="color: #0c369a; font-size: 16px;"></i>
                    <span style="font-weight: 600; font-size: 14px;"><?php echo e($engineer->name); ?></span>
                </div>
                <span class="count-pill" style="background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; font-size: 12px; font-weight: 600; padding: 3px 10px; border-radius: 12px;">
                    <?php echo e($engineer->ticket_count); ?> Active
                </span>
            </div>

          <div style="width: 100%; display: flex; align-items: center; gap: 8px; margin: 0;">
    <span style="font-size: 11px; color: #64748b; font-weight: 500; white-space: nowrap;">Assigned Team:</span>
    <div style="flex-grow: 1; padding: 5px 8px; font-size: 12px; border-radius: 4px; border: 1px solid #cbd5e1; background: #f8fafc; font-weight: 500; color: #334155;">
        <?php if($engineer->user_id == 24): ?>
            Application Team (Riya)
        <?php elseif($engineer->user_id == 25): ?>
            Network Team (Amit)
        <?php else: ?>
            Unassigned / Pool
        <?php endif; ?>
    </div>
</div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <div class="user-list-item" style="background:#f8fafc; padding: 10px; margin-top: 15px; border-radius: 6px; border: 1px dashed #cbd5e1; text-align: center;">
            <span style="font-size: 11px; color:#64748b; font-weight: 600; display: block; width: 100%;">
                Total Dynamic Engineers: <?php echo e($engineers->count()); ?>

            </span>
        </div>

    </div>
</div>

</div>

        </div>
    </div>


    
    <div class="modal-overlay" id="assignModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modal-title-text">Assign Ticket</h3>
                <button class="close-modal" onclick="closeAssignmentModal()">&times;</button>
            </div>
            
<div class="form-group mt-3">
    <label for="engineer-select" class="font-weight-bold">Select Support Team:</label>
    <select id="engineer-select" name="engineer" class="form-control">
        <option value="2">Support Engineer (Application Team)</option>
        <option value="4">Support Engineer (Network Team)</option>
    </select>
</div>

            <div class="modal-actions">
                <button class="cancel-btn" onclick="closeAssignmentModal()">Cancel</button>
                <button class="confirm-btn" onclick="submitAssignment()">Confirm Assignment</button>
            </div>


          
 </div>
 </div>

          
       
   

    <script>
        const modal = document.getElementById('assignModal');
        let currentTicketId = null;

        function openAssignmentModal(ticketId) {
            currentTicketId = ticketId;
            document.getElementById('modal-title-text').innerText = `Assign Ticket #INC-${String(ticketId).padStart(3, '0')}`;
            modal.style.display = 'flex';
        }

        function closeAssignmentModal() {
            modal.style.display = 'none';
        }

       function submitAssignment() {
    const chosenTarget = document.getElementById('engineer-select').value;
    
    // Safety check to ensure a valid engineer option was selected
    if (!chosenTarget) {
        alert("Please select a support engineer first.");
        return;
    }

    fetch(`/tickets/${currentTicketId}/assign`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            // Pulls the native Laravel application security token explicitly from your layouts header meta tags
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '<?php echo e(csrf_token()); ?>'
        },
        body: JSON.stringify({
            engineer: chosenTarget
        })
    })
    .then(async response => {
        const data = await response.json();
        if (response.ok && data.success) {
            closeAssignmentModal();
            window.location.reload(); // Instantly refreshes counters and status tables seamlessly
        } else {
            // Displays the actual database or routing exception directly to you
            alert("Error from server: " + (data.message || "Unknown error"));
        }
    })
    .catch(error => {
        console.error("Network Error:", error);
        alert("Network communication failed. Check your console log.");
      });
        }
    </script>
</body>
</html><?php /**PATH C:\internship\project1\resources\views/admin_dash.blade.php ENDPATH**/ ?>