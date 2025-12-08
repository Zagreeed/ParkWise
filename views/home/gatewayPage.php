<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ParkWise - Welcome</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 50%, #66bb6a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .gateway-container {
            background: white;
            border-radius: 20px;
            padding: 2rem 1.5rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            width: 100%;
            animation: slideUp 0.6s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo {
            font-size: 2.5rem;
            font-weight: bold;
            color: #1b5e20;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .logo span {
            color: #66bb6a;
        }

        .tagline {
            font-size: 1rem;
            color: #666;
            text-align: center;
            margin-bottom: 0.3rem;
            font-weight: 500;
        }

        .subtitle {
            font-size: 0.9rem;
            color: #999;
            text-align: center;
            margin-bottom: 2rem;
        }

        .route-selection {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .route-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e8f5e9 100%);
            padding: 1.5rem;
            border-radius: 15px;
            border: 2px solid transparent;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }

        .route-card:hover {
            transform: translateY(-5px);
            border-color: #66bb6a;
            box-shadow: 0 10px 25px rgba(102, 187, 106, 0.2);
        }

        .route-icon {
            font-size: 3rem;
            margin-bottom: 0.8rem;
            display: block;
        }

        .route-title {
            font-size: 1.4rem;
            font-weight: bold;
            color: #1b5e20;
            margin-bottom: 0.5rem;
        }

        .route-description {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .route-btn {
            background: linear-gradient(135deg, #66bb6a, #43a047);
            color: white;
            border: none;
            padding: 0.9rem 2rem;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(67, 160, 71, 0.3);
            text-decoration: none;
            display: inline-block;
            width: 100%;
        }

        .route-btn:hover {
            transform: scale(1.02);
            box-shadow: 0 6px 20px rgba(67, 160, 71, 0.4);
        }

        .route-btn:active {
            transform: scale(0.98);
        }

        /* Tablet */
        @media (min-width: 640px) {
            .gateway-container {
                padding: 2.5rem 2rem;
            }

            .logo {
                font-size: 3rem;
            }

            .route-selection {
                flex-direction: row;
                gap: 1.5rem;
            }

            .route-card {
                flex: 1;
            }
        }

        /* Desktop */
        @media (min-width: 1024px) {
            .gateway-container {
                max-width: 800px;
                padding: 3rem 2.5rem;
            }

            .route-icon {
                font-size: 4rem;
            }

            .route-title {
                font-size: 1.6rem;
            }
        }

        /* Small mobile */
        @media (max-width: 360px) {
            .logo {
                font-size: 2rem;
            }

            .route-icon {
                font-size: 2.5rem;
            }

            .route-title {
                font-size: 1.2rem;
            }

            .route-btn {
                padding: 0.8rem 1.5rem;
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>
    <div class="gateway-container">
        <div class="logo">Park<span>Wise</span></div>
        <p class="tagline">Smart Parking Management</p>
        <p class="subtitle">Choose how you want to continue</p>

        <div class="route-selection">
          
            <div class="route-card">
                <span class="route-icon">🚗</span>
                <h2 class="route-title">User Portal</h2>
                <p class="route-description">Book parking spots and manage your vehicles</p>
                <a href="?controller=UserController&action=showLoginPage" class="route-btn">Continue as User</a>
            </div>

            <div class="route-card">
                <span class="route-icon">⚙️</span>
                <h2 class="route-title">Admin Panel</h2>
                <p class="route-description">Manage slots and monitor bookings</p>
                <a href="?controller=AdminController&action=showAdminLoginPage" class="route-btn">Continue as Admin</a>
            </div>
        </div>
    </div>
</body>
</html>