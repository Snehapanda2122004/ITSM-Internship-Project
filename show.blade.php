<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITSM Portal - Ticket Details Log</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #f4f6f9; color: #333; min-height: 100vh; }
        
        header {
            background: #0c369a; color: white; padding: 15px 40px;
            display: flex; justify-content: space-between; align-items: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .logo-area h2 { font-size: 22px; font-weight: 600; }
        .back-btn {
            background: rgba(255, 255, 255, 0.2); color: white; text-decoration: none;
            padding: 8px 18px; border-radius: 20px; font-size: 14px; font-weight: 500; transition: background 0.3s;
        }
        .back-btn:hover { background: rgba(255, 255, 255, 0.3); }

        .container { max-width: 1100px; margin: 30px auto; padding: 0 20px; }
        
       .detail-layout {
    display: grid; grid-template-columns: 2fr 1.2fr; gap: 25px; margin-top: 20px; align-items: flex-start;
}
        @media (max-width: 850px) { .detail-layout { grid-template-columns: 1fr; } }

        .card {
            background: #ffffff; padding: 30px; border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.03); border: 1px solid #e2e8f0;
        }
        .card-title {
            font-size: 18px; font-weight: 600; color: #1e293b; margin-bottom: 20px;
            display: flex; align-items: center; gap: 10px; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px;
        }

        /* Information Grid fields */
        .info-row { display: flex; flex-direction: column; gap: 15px; }
        .info-item { display: grid; grid-template-columns: 140px 1fr; line-height: 1.5; }
        .info-label { font-weight: 500; color: #64748b; font-size: 13.5px; }
        .info-value { color: #1e293b; font-size: 14px; }

        .badge {
            padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;
            display: inline-flex; align-items: center; gap: 4px;
        }
        .badge.open { background: #eafaf1; color: #2da44e; }
        .badge.assigned { background: #eff6ff; color: #2563eb; }
        .badge.progress { background: #fff7ed; color: #c2410c; }
        .badge.resolved { background: #f0fdf4; color: #16a34a; }
        .badge.closed { background: #f3f4f6; color: #4b5563; }
        .badge.high { background: #fef2f2; color: #991b1b; }
        .badge.medium { background: #feebd7; color: #dd6b20; }
        .badge.low { background: #edf2f7; color: #4a5568; }


    
        .description-box {
            background: #f8fafc; padding: 15px; border-radius: 8px;
            border: 1px solid #e2e8f0; margin-top: 10px; font-size: 13.5px; color: #334155;
            white-space: pre-line;
        }

        .subject-box {
            background: #f8fafc; padding: 15px; border-radius: 8px;
            border: 1px solid #e4e45f; margin-top: 10px; font-size: 13.5px; color: #11110d;
        }


        .img-preview {
            max-width: 100%; border-radius: 8px; margin-top: 10px;
            border: 1px solid #cbd5e1; box-shadow: 0 3px 8px rgba(0,0,0,0.05);
        }

        /* Form Controls */
        .form-group { display: flex; flex-direction: column; gap: 8px; margin-bottom: 15px; }
        .form-group label { font-size: 13.5px; font-weight: 500; color: #475569; }
        .form-group textarea {
            width: 100%; padding: 12px; background: #f8fafc; border: 1px solid #cbd5e1;
            border-radius: 8px; font-size: 14px; outline: none; resize: vertical; min-height: 100px;
        }
        .form-group textarea:focus { border-color: #0c369a; background: #fff; }

        .submit-btn {
            background: #0c369a; color: white; border: none; padding: 12px 24px;
            font-size: 14px; font-weight: 600; border-radius: 8px; cursor: pointer;
            display: inline-flex; align-items: center; gap: 8px; transition: background 0.2s;
        }
        .submit-btn:hover { background: #08256d; }

        .alert-success {
            background: #d4edda; color: #155724; padding: 15px; border-radius: 8px;
            margin-bottom: 20px; border: 1px solid #c3e6cb; font-size: 14px;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo-area">
            <h2>Incident Tracking Lifecycle</h2>
        </div>
        <a href="{{ url('/user-panel?section=raised') }}" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
        </a>
    </header>

    <div class="container">

        @if(session('success'))
            <div class="alert-success">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card" style="margin-bottom: 25px; padding: 20px 30px;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                <div>
                    <span style="font-size: 12px; text-transform: uppercase; tracking: 1px; color:#64748b; font-weight:600;">Incident Record Index</span>
                    <h1 style="font-size: 22px; color: #0c369a;">#INC-{{ sprintf('%03d', $ticket->Id) }}</h1>
                </div>
                <div style="display: flex; gap: 15px;">
                    <div>
                        <span style="font-size: 11px; display:block; color:#64748b; text-align:right;">Priority</span>
                        <span class="badge {{ strtolower($ticket->priority_name) }}">{{ $ticket->priority_name }}</span>
                    </div>
                    <div>
                        <span style="font-size: 11px; display:block; color:#64748b; text-align:right;">Current Ticket Status</span>
                        <span class="badge {{ strtolower(str_replace(' ', '-', $ticket->Status_name)) }}">{{ $ticket->Status_name }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="detail-layout">

        
            
            <div class="card">
                <h3 class="card-title"><i class="fa-solid fa-receipt" style="color: #0c369a;"></i> Original Ticket Details</h3>
                
                <div class="info-row">
                    <div class="info-item">
                        <span class="info-label">Subject Line:</span>
                        <span class="info-value" style="font-weight: 600;">{{ $ticket->Subject ?? $ticket->subject }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Problem Category:</span>
                        <span class="info-value">{{ $ticket->category_name }} ({{ $ticket->subcategory ?? 'General' }})</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Created At:</span>
                        <span class="info-value">{{ date('d M Y, h:i A', strtotime($ticket->created_at)) }}</span>
                    </div>
       

<div class="info-item">
    <span class="info-label">Resolved At:</span>
    <span class="info-value">
        {{ !empty($ticket->Resolved_at) ? date('d M Y, h:i A', strtotime($ticket->Resolved_at)) : 'Pending Action' }}
    </span>
</div>

        <div class="info-item">
    <span class="info-label">Closed At:</span>
    <span class="info-value" style="{{ !empty($ticket->Closed_at) ? 'color: #1e293b; font-weight: 600;' : 'color: #94a3b8; font-style: italic;' }}">
        @if(!empty($ticket->Closed_at))
            {{ date('d M Y, h:i A', strtotime($ticket->Closed_at)) }}
        @else
            Not Closed Till Now
        @endif
    </span>
</div>



                    <div class="info-item">
                        <span class="info-label">Assigned Resource:</span>
                        <span class="info-value" style="font-weight: 500; color: #2563eb;">
                            {{ $ticket->engineer_name ?? 'Tier 1 Support Queue' }}
                        </span>
                    </div>

                    <div class="info-item" style="margin-top: 5px;">
    <span class="info-label">Previous Engineer:</span>
    <span class="info-value" style="font-weight: 500; color: #64748b;">
        @if($ticket->previous_engineer == 24)
            <span class="badge" style="background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; font-size: 12px; padding: 3px 8px; border-radius: 4px;">
                <i class="fa-solid fa-laptop-code"></i> Application Team(Riya Das)
            </span>
        @elseif($ticket->previous_engineer == 25)
            <span class="badge" style="background: #fff7ed; color: #ea580c; border: 1px solid #ffedd5; font-size: 12px; padding: 3px 8px; border-radius: 4px;">
                <i class="fa-solid fa-server"></i> Network Team(Amit Sen)
            </span>
        @elseif(!empty($ticket->previous_engineer))
            <span class="badge bg-secondary text-white" style="font-size: 12px; padding: 3px 8px; border-radius: 4px;">
                <i class="fa-solid fa-user-shield"></i> {{ $ticket->previous_engineer_name ?? 'Engineer (ID: ' . $ticket->previous_engineer . ')' }}
            </span>
        @else
            <span style="color: #94a3b8; font-style: italic; font-size: 13px;">None (Initial Cycle)</span>
        @endif
    </span>
</div>
                    <div style="margin-top: 10px;">
                        <span class="info-label" style="display: block; margin-bottom: 5px;">Issue Subject:</span>
                        <div class="subject-box">
                            {{ $ticket->Subject ?? $ticket->Subject }}
                        </div>
                    </div>

                   <div style="margin-top: 10px;">
    <span class="info-label" style="display: block; margin-bottom: 5px;">Issue Narrative:</span>
    <div class="description-box">
        {{ $ticket->description }} 
    </div>
</div>
                   

    
        
        <div class="info-item" style="margin-top: 20px;">
            <span class="info-label" style="display: block; font-weight: 600; color: #4a5568; margin-bottom: 8px;">
                <i class="fa-solid fa-image" style="color: #1e56ce;"></i>Screenshot Provided by the User:
            </span>
    
    
    @if(!empty($ticket->Screenshot))
        <div style="margin-top: 8px;">
            <a href="data:image/jpeg;base64,{{ base64_encode($ticket->Screenshot) }}" target="_blank">
                <img src="data:image/jpeg;base64,{{ base64_encode($ticket->Screenshot) }}" 
                     class="img-preview" 
                     alt="User Diagnostic Screenshot Attachment"
                     style="max-width: 100%; max-height: 380px; border-radius: 6px; border: 1px solid #cbd5e1; box-shadow: 0 4px 12px rgba(0,0,0,0.06); cursor: zoom-in;">
            </a>
        </div>
    @else
        <span class="info-value" style="color: #94a3b8; font-style: italic; font-size: 13px;">
            No attachment uploaded for this ticket item.
        </span>
    @endif
</div>
</div>
</div>



@if(isset($comments) && $comments->isNotEmpty())
    <div style="background: #fff7ed; border-left: 4px solid #ce731e; padding: 20px; border-radius: 8px; margin-top: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); word-break: break-word;">
        <h3 style="color: #9a240c; margin-bottom: 15px; font-size: 16px; display: flex; align-items: center; gap: 8px; border-bottom: 2px solid #fed7aa; padding-bottom: 8px;">
            <i class="fa-solid fa-clock-rotate-left"></i> Ticket Activity Timeline & Reopen History
        </h3>
        
        <div style="font-size: 14px; color: #4a5568; line-height: 1.6;">
            @foreach($comments as $index => $comment)
                <div class="comment-entry" style="{{ $index > 0 ? 'margin-top: 20px; border-top: 1px dashed #fed7aa; padding-top: 20px;' : '' }}">
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <span style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: #ce731e; letter-spacing: 0.5px;">
                            Log Entry #{{ $loop->iteration }} ({{ $comment->commented_by ?? 'System' }})
                        </span>
                        <span style="font-size: 11px; color: #a0aec0;">
                            {{ date('d M Y, h:i A', strtotime($comment->created_at)) }}
                        </span>
                    </div>

                    <p style="font-style: italic; color: #718096; margin-bottom: 8px;">{{ $comment->Details }}</p>

                    @if(!empty($comment->reopen_comment))
                        <p style="white-space: pre-line; color: #2d3748; margin-bottom: 10px; background: #fff; padding: 10px; border-radius: 4px; border: 1px solid #ffedd5;">
                            <strong>Reason Provided:</strong> {{ $comment->reopen_comment }}
                        </p>
                    @endif

                    @if(!empty($comment->reopen_screenshot))
                        <div style="margin-top: 12px; background: rgba(254, 215, 170, 0.2); padding: 12px; border-radius: 6px; border: 1px solid #fed7aa;">
                            <strong style="display:block; color:#4a5568; margin-bottom: 8px; font-size: 13px;">
                                <i class="fa-solid fa-paperclip" style="color: #ce731e;"></i> Attached Error Screenshot:
                            </strong>
                            <a href="{{ $comment->reopen_screenshot }}" target="_blank">
                                <img src="{{ $comment->reopen_screenshot }}" 
                                     alt="Reopen Error Diagnostic Screenshot" 
                                     style="max-width:100%; max-height:250px; border-radius:6px; border:1px solid #cbd5e1; box-shadow: 0 2px 8px rgba(0,0,0,0.08); cursor: zoom-in;">
                            </a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endif



                
              

            </div>

        

</body>
</html>




