<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
            display: flex;
            justify-content: center;
            align-items: center;
            /* Recreating the vibrant blue background from the image */
            background: radial-gradient(circle at 20% 30%, #1e56ce 0%, #0c369a 70%);
            padding: 20px;
        }

        .login-card {
            background-color: #ffffff;
            width: 100%;
            max-width: 400px;
            padding: 40px 35px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .login-card h2 {
            color: #555555;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 35px;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        /* Styling for the icons inside inputs */
        .input-group i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #b3b3b3;
            font-size: 18px;
        }

        .input-group input {
            width: 100%;
            padding: 15px 15px 15px 55px;
            background-color: #f2f2f2;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            color: #333333;
            outline: none;
            transition: background-color 0.3s;
        }

        .input-group input::placeholder {
            color: #b3b3b3;
        }

        .input-group input:focus {
            background-color: #e8e8e8;
        }

        .options-row {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            padding-left: 5px;
        }

        /* Customizing the checkbox appearance */
        .options-row input[type="checkbox"] {
            accent-color: #ffb057; 
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .options-row label {
            color: #888888;
            font-size: 15px;
            margin-left: 10px;
            cursor: pointer;
            user-select: none;
        }

        /* Gradient Submit Button */
        .login-btn {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 30px;
            background: linear-gradient(to right, #ffb057, #e6707a);
            color: #ffffff;
            font-size: 18px;
            font-weight: 600;
            letter-spacing: 1px;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(230, 112, 122, 0.3);
            transition: transform 0.2s, opacity 0.3s;
        }

        .login-btn:hover {
            opacity: 0.95;
            transform: translateY(-1px);
        }

        .login-btn:active {
            transform: translateY(1px);
        }

        .forgot-password {
            display: inline-block;
            margin-top: 20px;
            color: #888888;
            text-decoration: none;
            font-size: 15px;
            transition: color 0.2s;
        }

        .forgot-password:hover {
            color: #555555;
        }

        .signup-text {
            margin-top: 50px;
            color: #888888;
            font-size: 15px;
        }

        .signup-text a {
            color: #4a69bd;
            text-decoration: none;
            font-weight: 500;
            margin-left: 3px;
        }

        .signup-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <h2>Login</h2>
        <?php if(session('error')): ?>
    <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 14px; text-align: center;">
        <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>

<?php if(session('success')): ?>
    <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 14px; text-align: center;">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>
        
        <form action="<?php echo e(url('/login')); ?>" method="POST">
            <?php echo csrf_field(); ?> <div class="input-group">
                <i class="fa-regular fa-user"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>
            
            <div class="input-group">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            
            <div class="options-row">
                <input type="checkbox" id="remember-me" checked>
                <label href="#" for="remember-me">Remember me</label>
            </div>
            
            <button type="submit" class="login-btn">LOG IN</button>
            
            <div>
                <a href="#" class="forgot-password">Forget Password</a>
            </div>
        </form>
        
        <div class="signup-text">
            Not a member?<a href="<?php echo e(url('/register')); ?>" >Sign up now</a>
        </div>
    </div>

</body>
</html><?php /**PATH C:\internship\project1\resources\views/Project1/login.blade.php ENDPATH**/ ?>