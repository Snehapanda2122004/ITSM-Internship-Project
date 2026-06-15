<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITSM Portal - Support Engineer Dashboard</title>
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

        .dashboard-card {
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

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-box {
            padding: 20px;
            border-radius: 10px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-box.assigned { background: #1e56ce; }
        .stat-box.pending { background: #ff9f43; }
        .stat-box.resolved { background: #28a745; }

        .stat-info h3 { font-size: 13px; text-transform: uppercase; opacity: 0.9; font-weight: 500; }
        .stat-info p { font-size: 28px; font-weight: 700; margin-top: 5px; }
        .stat-box i { font-size: 36px; opacity: 0.3; }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
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
            font-size: 14px;
            font-weight: 600;
            border-bottom: 2px solid #e2e8f0;
        }

        td {
            padding: 16px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 14px;
            vertical-align: middle;
        }

        tr:hover { background-color: #f8fafc; }

        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .badge.status-assigned { background: #eff6ff; color: #1e40af; }
        .badge.status-progress { background: #fff7ed; color: #c2410c; }
        .badge.status-resolved { background: #eafaf1; color: #2da44e; }
        .badge.priority-high { background: #fef2f2; color: #991b1b; }
        .badge.priority-medium { background: #fef3c7; color: #b45309; }
        .badge.priority-low { background: #f1f5f9; color: #475569; }

        .action-btn {
            background: #0c369a;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: background 0.2s;
        }

        .action-btn:hover { background: #1e56ce; }

        .detail-panel {
            position: fixed;
            top: 0;
            right: -450px;
            width: 450px;
            height: 100%;
            background: white;
            box-shadow: -5px 0 25px rgba(0,0,0,0.15);
            transition: right 0.3s ease;
            z-index: 1000;
            padding: 30px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .detail-panel.open { right: 0; }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .close-panel-btn {
            background: none;
            border: none;
            font-size: 22px;
            color: #94a3b8;
            cursor: pointer;
        }

        .info-group { margin-bottom: 18px; }
        .info-group label { font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase; }
        .info-group p { font-size: 14.5px; color: #1e293b; margin-top: 4px; line-height: 1.5; }

        .comment-box {
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 10px;
            width: 100%;
            font-size: 13.5px;
            resize: none;
            margin-top: 5px;
        }

        .panel-footer-actions {
            margin-top: auto;
            padding-top: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .workflow-btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-progress { background: #ff9f43; color: white; }
        .btn-resolve { background: #28a745; color: white; }
    </style>
</head>
<body>

    <header>
        <div class="logo-area">
            <h2>ITSM Support Portal</h2>
        </div>
        <a href="{{ url('/login') }}" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i> Logout
        </a>
    </header>

    <div class="container">
        <div class="dashboard-card">
            
            <div class="dashboard-header">
                <h1><i class="fa-solid fa-screwdriver-wrench" style="color: #0c369a;"></i> Support Workspace</h1>
                <h3>Viewing Panel: <span style="color: #1e56ce; font-weight: 700;">{{ $username }}</span></h3>
            </div>

            <div class="stats-grid">
                <div class="stat-box assigned">
                    <div class="stat-info">
                        <h3>Assigned Tickets</h3>
                        <p id="stat-assigned">{{ $assignedCount }}</p>
                    </div>
                    <i class="fa-solid fa-clipboard-list"></i>
                </div>
                <div class="stat-box pending">
                    <div class="stat-info">
                        <h3>Pending Issues</h3>
                        <p id="stat-pending">{{ $pendingCount }}</p>
                    </div>
                    <i class="fa-solid fa-spinner"></i>
                </div>
                <div class="stat-box resolved">
                    <div class="stat-info">
                        <h3>Resolved Tickets</h3>
                        <p id="stat-resolved">{{ $resolvedCount }}</p>
                    </div>
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>

            <h2 style="font-size: 18px; color: #1e293b; margin-bottom: 15px;">Assigned Incident Backlog</h2>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Ticket ID</th>
                            <th>Subject</th>
                            <th>Category</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Action</th>
                            <th>Show Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                        <tr id="ticket-row-{{ $ticket->Id }}">
                            <td style="font-weight: 600; color: #0c369a;">#INC-{{ sprintf('%03d', $ticket->Id) }}</td>
                            <td>
                                <strong>{{ $ticket->Subject }}</strong>
                                <div style="font-size: 12px; color: #64748b; margin-top: 2px;">Assigned To: {{ $ticket->assigned_to }}</div>
                            </td>
                            <td>{{ $ticket->category_name }}</td>
                            <td>
                                @if(strtolower($ticket->priority_name) == 'high')
                                    <span class="badge priority-high"><i class="fa-solid fa-circle-exclamation"></i> High</span>
                                @elseif(strtolower($ticket->priority_name) == 'medium')
                                    <span class="badge priority-medium"><i class="fa-solid fa-triangle-exclamation"></i> Medium</span>
                                @else
                                    <span class="badge priority-low"><i class="fa-solid fa-arrow-down"></i> Low</span>
                                @endif
                            </td>
                            <td>
    @if(strtolower($ticket->Status_name) == 'assigned')
        <span class="badge status-assigned" id="table-status-badge-{{ $ticket->Id }}"><i class="fa-solid fa-user-check"></i> Assigned</span>
    @elseif(strtolower($ticket->Status_name) == 'pending' || strtolower($ticket->Status_name) == 'in progress')
        <span class="badge status-progress" id="table-status-badge-{{ $ticket->Id }}"><i class="fa-solid fa-spinner fa-spin"></i> Pending</span>
    @elseif(strtolower($ticket->Status_name) == 'resolved')
        <span class="badge status-resolved" id="table-status-badge-{{ $ticket->Id }}"><i class="fa-solid fa-circle-check"></i> Resolved</span>
    @else
        <span class="badge status-assigned" id="table-status-badge-{{ $ticket->Id }}">{{ $ticket->Status_name }}</span>
    @endif
</td>
    <td>

    @if(strtolower($ticket->Status_name) !== 'resolved' && strtolower($ticket->Status_name) !== 'closed')
    <button class="action-btn" 
            onclick="openDetailPanel(
                '{{ $ticket->Id }}', 
                '{{ addslashes($ticket->Subject) }}', 
                '{{ json_encode($ticket->description) }}', 
                '{{ addslashes($ticket->Status_name) }}'
            )">
        <i class="fa-solid fa-folder-open"></i> Open Ticket
    </button>
@else
        <span style="color: #94a3b8; font-size: 13px;">
            <i class="fa-solid"></i> Issue Resolved
        </span>
    @endif


</td>


                    <td>
    <a href="{{ url('support/tickets/show/' . urlencode(Crypt::encryptString($ticket->Id ?? $ticket->id))) }}" class="btn-show-details" style="display: inline-flex; align-items: center; gap: 6px; background-color: #0c369a; color: white; padding: 6px 12px; border-radius: 4px; font-size: 12px; text-decoration: none; font-weight: 500;">
        <i class="fa-solid fa-eye"></i> View
    </a>
</td>

                      
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: #64748b; padding: 30px;">No incident tracker rows are mapped to this account workspace.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <div class="detail-panel" id="ticketPanel">
        <div class="panel-header">
            <h3 style="color: #1e293b;" id="panel-ticket-title">Incident Details</h3>
            <button class="close-panel-btn" onclick="toggleDetailPanel(false)">&times;</button>
        </div>

        <div class="info-group">
            <label>Subject Text</label>
            <p id="panel-subject">Loading...</p>
        </div>

        <div class="info-group">
            <label>Detailed Description</label>
            <p id="panel-description">Loading...</p>
        </div>

        <div class="info-group">
            <label>Current Live Status</label>
            <div style="margin-top: 5px;">
                <span class="badge status-assigned" id="panel-status-badge"><i class="fa-solid fa-user-check"></i> Assigned</span>
            </div>
        </div>

        <div class="info-group" style="margin-top: 10px;">
            <label id="comment-label" for="panel-comment">Resolution Action Logs / Comments</label>
            <textarea id="panel-comment" class="comment-box" rows="3" placeholder="Add troubleshooting actions here..."></textarea>
        </div>

        <div class="panel-footer-actions">
            <button class="workflow-btn btn-progress" id="btnActionProgress" onclick="moveStatusToInProgress()">
                <i class="fa-solid fa-gears"></i> Start Troubleshooting
            </button>

            <button class="workflow-btn btn-resolve" id="btnActionResolve" onclick="moveStatusToResolved()" style="display: none;">
                <i class="fa-solid fa-check-double"></i> Resolve Issue
            </button>
        </div>
    </div>

    <script>
       let currentTicketId = null;

const panel = document.getElementById('ticketPanel');
const commentField = document.getElementById('panel-comment');
const panelBadge = document.getElementById('panel-status-badge');

const btnProgress = document.getElementById('btnActionProgress');
const btnResolve = document.getElementById('btnActionResolve');

function toggleDetailPanel(shouldOpen) {
    if(shouldOpen) {
        panel.classList.add('open');
    } else {
        panel.classList.remove('open');
    }
}

// Open Drawer and Populate Metadata Attributes Dynamically
// Open Drawer and Populate Metadata Attributes Dynamically
function openDetailPanel(id, subject, safeDescription, status) {
    currentTicketId = id;
    
    // Clean up string wrapping if json_encode was processed
    let cleanDescription = safeDescription;
    if (cleanDescription.startsWith('"') && cleanDescription.endsWith('"')) {
        try {
            cleanDescription = JSON.parse(cleanDescription);
        } catch(e) {
            cleanDescription = safeDescription;
        }
    }

    document.getElementById('panel-ticket-title').innerText = `Incident Details (#INC-${id})`;
    document.getElementById('panel-subject').innerText = subject;
    document.getElementById('panel-description').innerText = cleanDescription;
    
    // Standardize status text evaluation
    const standardizedStatus = status.trim().toLowerCase();
    
    if (standardizedStatus === 'assigned') {
        panelBadge.className = "badge status-assigned";
        panelBadge.innerHTML = '<i class="fa-solid fa-user-check"></i> Assigned';
        commentField.value = ""; 
        commentField.placeholder = "Click 'Start Troubleshooting' to set default workflow log...";
        btnProgress.style.display = "flex";
        btnResolve.style.display = "none";
        commentField.disabled = false;
    } else if (standardizedStatus === 'pending' || standardizedStatus === 'in progress') {
        panelBadge.className = "badge status-progress";
        panelBadge.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Pending';
        commentField.value = ""; 
        commentField.placeholder = "Enter technical notes here to resolve this incident tracking record...";
        btnProgress.style.display = "none";
        btnResolve.style.display = "flex";
        commentField.disabled = false;
    } else if (standardizedStatus === 'resolved') {
        panelBadge.className = "badge status-resolved";
        panelBadge.innerHTML = '<i class="fa-solid fa-circle-check"></i> Resolved';
        commentField.value = "Issue resolved successfully.";
        btnProgress.style.display = "none";
        btnResolve.style.display = "none";
        commentField.disabled = true;
    }

    toggleDetailPanel(true);
}
// Action Step 1: Execute State Conversion to Pending/In Progress
function moveStatusToInProgress() {
    const commentValue = commentField.value.trim() || "Issue checked, password reset initiated.";
    
    submitWorkflowPayload('Pending', commentValue, () => {
        const targetTableBadge = document.getElementById(`table-status-badge-${currentTicketId}`);
        if(targetTableBadge) {
            targetTableBadge.className = "badge status-progress";
            targetTableBadge.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Pending';
        }
        toggleDetailPanel(false);
        window.location.reload(); // Refresh views and metrics tracking blocks
    });
}

// Action Step 2: Execute Final State Transition to Resolved (Completes Workflow)
function moveStatusToResolved() {
    const commentValue = commentField.value.trim() || "Issue checked, resolved successfully.";
    
    submitWorkflowPayload('Resolved', commentValue, () => {
        const targetTableBadge = document.getElementById(`table-status-badge-${currentTicketId}`);
        if(targetTableBadge) {
            targetTableBadge.className = "badge status-resolved";
            targetTableBadge.innerHTML = '<i class="fa-solid fa-circle-check"></i> Resolved';
        }
        toggleDetailPanel(false);
        window.location.reload(); // Refresh metrics blocks to increment resolved counter
    });
}

// Asynchronous Pipeline Handling Persistence Updates
function submitWorkflowPayload(statusString, trackingComments, successCallback) {
    fetch(`/tickets/${currentTicketId}/update-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ 
            status: statusString, 
            comments: trackingComments 
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            successCallback();
        } else {
            alert("Workflow Sync Error: " + data.message);
        }
    })
    .catch(err => {
        console.error("AJAX error execution processing failed:", err);
        alert("Network communication error updating record status.");
    });
}
    </script>
</body>
</html>