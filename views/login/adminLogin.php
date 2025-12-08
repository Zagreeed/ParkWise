<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parkwise Admin Login</title>
    <link rel="icon" type="image/png" href="images/logo1.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
   <style>
            /* ===================== GENERAL BODY ===================== */
        body {
            margin: 0;
            font-family: "Poppins", Arial, sans-serif;
            background: #f4f7f5;
            min-height: 100vh;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        /* ===================== LOGIN PAGE ===================== */
        body.login-body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(
                to bottom,
                #9becd84d,
                #1f7e6999
            ),
            url("<?php echo BASE_URL?>views/static/Images/parkingbg.png") center/cover no-repeat;
            font-family: "Poppins", Arial, sans-serif;
        }


        /* ===================== LOGIN CONTAINER ===================== */
        .login-container {
            width: 330px;
            padding: 30px;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.85);
            text-align: center;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(6px);

            /* entrance */
            animation:
            floatIn 1s ease forwards,
            softFloat 4s ease-in-out infinite;
        }

        @keyframes softFloat {
            0%   { transform: translateY(0); }
            50%  { transform: translateY(-6px); }
            100% { transform: translateY(0); }
        }

        .login-logo1 {
            width: 130px;
            display: block;
            margin: 0 auto 20px;
        }

        .login-container h2 {
            margin-bottom: 25px;
            color: #2f5147;
            font-weight: 600;
            font-size: 22px;
        }

        /* ===================== LABELS & INPUTS ===================== */
        .label {
            font-size: 14px;
            margin-top: 8px;
            display: block;
            color: #3f4442;
            font-weight: 500;
            text-align: left;
        }

        /* ===================== INPUTS WITH ICONS REFINED ===================== */
        .input-icon {
            position: relative;
            width: 100%;
            display: flex;
            align-items: center;
        }

        .input-icon input {
            flex: 1;
            padding: 12px 12px 12px 40px; /* left padding for icon space */
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #165036;
            outline: none;
            font-size: 14px;
            transition: 0.3s ease;
            box-sizing: border-box;
        }

        .input-icon i {
            position: absolute;
            left: 12px;
            font-size: 18px;
            color: #165036;
            transition: 0.3s ease;
            top: 35%;
            transform: translateY(-50%);
            pointer-events: none; /* icon does not block input */
        }

        /* FOCUS / HOVER EFFECTS */
        .input-icon input:focus {
            border-color: #2e6b55;
            box-shadow: 0 0 10px rgba(46,107,85,0.25);
        }

        .input-icon:focus-within i,
        .input-icon:hover i {
            color: #1d7a4a;
        }

        .input-icon input:hover,
        .input-icon input:focus {
            border-color: #168f60;
        }

        .input-icon input:hover + i,
        .input-icon input:focus + i {
            color: #168f60 !important;
        }


        /* ===================== BUTTONS ===================== */
        .btn {
            width: 100%;
            padding: 12px;
            margin-top: 18px;
            background: #14452F;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            cursor: pointer;
            transition: 0.25s ease;
            font-weight: 500;
        }

        .btn:hover {
            background: #246b4d;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(20, 69, 47, 0.3);
        }

        .btn:active {
            transform: scale(0.97);
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }

        /* ===================== REMEMBER ME & FORGOT PASSWORD ===================== */
        .remember-forgot {
            display: flex;
            justify-content: space-between; /* align checkbox left, forgot password right */
            align-items: center;
            margin: 12px 0 18px 0;
            font-size: 14px; /* same as input labels */
            color: #606462; /* matches label color */
        }

        .remember-forgot label {
            display: flex;
            align-items: center;
            gap: 6px; /* space between checkbox and text */
            cursor: pointer;
            font-weight: 500;
        }

        .remember-forgot input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #3e8666; /* checkbox color matches input icon/border */
            cursor: pointer;
            margin: 0;
        }

        .remember-forgot a {
            text-decoration: none;
            color: #2f5147; /* darker accent for link */
            font-weight: 500;
            transition: 0.25s ease;
        }

        .remember-forgot a:hover {
            text-decoration: underline;
            color: #1d7a4a; /* hover accent */
        }
   </style>
</head>

<body class="login-body">

<div class="login-container">
 
    <img src="<?php echo BASE_URL?>views/static/Images/logo1.png" class="login-logo1" alt="Parkwise Logo">
    <h2>ParkWise Admin</h2>

    <form action="?controller=AdminController&action=Adminlogin" method="post">
                <div class="form-group">
                <label class="label">Email</label>
                <div class="input-icon">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="email" id="username" placeholder="Enter Email">
                </div>
            </div>

            <div class="form-group">
                <label class="label">Password</label>
                <div class="input-icon">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" id="password" placeholder="Enter password">
                </div>
            </div>

            <div class="remember-forgot">
                <label>
                    <input type="checkbox" id="rememberMe">Remember me</label>
                    <a href="#" id="forgotPassword">Forgot password?</a>
            </div>
                <button class="btn">Login</button>
                <p id="errorMsg" class="error"></p>
            </div>
    </form>

    

<script src="script.js"></script>
</body>
</html>
