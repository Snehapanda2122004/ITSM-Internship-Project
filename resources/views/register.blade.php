<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITSM Portal - Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f6f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.05); width: 100%; max-width: 400px; }
        h2 { color: #0c369a; margin-bottom: 20px; font-weight: 600; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-size: 13px; color: #64748b; font-weight: 500; margin-bottom: 5px; }
        input, select { width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; }
        .btn { width: 100%; background: #0c369a; color: white; border: none; padding: 12px; border-radius: 6px; font-weight: 600; cursor: pointer; margin-top: 10px; }
        .error { color: #dc3545; font-size: 12px; margin-top: 5px; }
    </style>
</head>
<body>

<div class="card">
    <h2>Create Account</h2>

    @if ($errors->any())
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 13px;">
            <ul style="margin: 0; padding-left: 15px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register.store') }}" method="POST">
        @csrf 
        
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" value="{{ old('username') }}" required>
        </div>

        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label>Account Role</label>
            <select name="role_id" required>
                <option value="3">User / Employee</option>
            </select>
        </div>

        <div class="form-group">
            <label>Password (Min 5 Characters)</label>
            <input type="password" name="password" required>
        </div>

        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn">Register User</button>
    </form>
</div>

</body>
</html>