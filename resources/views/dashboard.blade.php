
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
            min-height: 100vh;
            background: #f4f6f9;
            display: flex;
            flex-direction: column;
        }
        header {
            background: #d0d3db;
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .role-badge {
            background: #ffb057;
            color: #333;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .logout-btn {
            background: #e6707a;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: 500;
            transition: opacity 0.2s;
        }
        .logout-btn:hover { opacity: 0.9; }
        .main-content {
            padding: 40px;
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .welcome-card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }
        .welcome-card i {
            font-size: 60px;
            color: #1e56ce;
            margin-bottom: 20px;
        }
        .welcome-card h1 {
            color: #333;
            margin-bottom: 10px;
        }
        .welcome-card p { color: #777; }
    </style>
</head>
<body>

    <header>
       
        <div class="user-info">
            <span>Welcome, <strong>{{ session('username', 'User') }}</strong></span>
            
            @if(session('role'))
                <span class="role-badge">{{ session('role') }}</span>
            @endif
            
            <a href="{{ url('/login') }}" class="logout-btn" style="text-decoration: none; display: inline-block; text-align: center;">Logout</a>
        </div>
    </header>

    <div class="main-content">
        <div class="welcome-card">
            <i class="fa-solid fa-circle-check"></i>
            <h1>Login Successful!</h1>
            <p style="margin-bottom: 30px;">You have securely accessed your dynamic portal dashboard area.</p>
            
            <hr style="border: 0; height: 1px; background: #eee; margin-bottom: 25px;">
            
            <h3 style="color: #555; margin-bottom: 15px;">Switch Dashboard Panels:</h3>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <a href="{{ url('/admin-panel') }}" style="background: #7c859b; color: white; padding: 12px; border-radius: 25px; text-decoration: none; font-weight: 500;">
                    <i class="fa-solid"></i> Go to Admin Dashboard
                </a>
                
                <a href="{{ url('/support-panel') }}" style="background: #96d095; color: white; padding: 12px; border-radius: 25px; text-decoration: none; font-weight: 500;">
                    <i class="fa-solid"></i> Go to Support Dashboard
                </a>
                
                <a href="{{ url('/user-panel') }}" style="background: #28a745; color: white; padding: 12px; border-radius: 25px; text-decoration: none; font-weight: 500;">
                    <i class="fa-solid"></i> Go to End User Dashboard
                </a>
            </div>
        </div>
    </div>

</body>
</html>