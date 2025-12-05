<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ParkWise - Login</title>
    
    <link rel="stylesheet" href="<?php echo BASE_URL?>views/static/userStyle.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">Park<span>Wise</span></div>
                <p class="login-subtitle">Smart Parking Management System</p>
            </div>

            <form class="login-form" method="post" action="?controller=UserController&action=login" >
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email"
                        class="form-input" 
                        placeholder="Enter your email"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password"
                        class="form-input" 
                        placeholder="Enter your password"
                        required
                    >
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" id="remember">
                        <span>Remember me</span>
                    </label>
                    <a href="#" class="forgot-password">Forgot Password?</a>
                </div>

                <button type="submit" class="login-btn">Login</button>
            </form>

            <div class="login-footer">
                <p>Don't have an account? <a href="?controller=UserController&action=showSignUpPage" class="signup-link">Sign up</a></p>
            </div>
        </div>

        <div class="login-features">
            <h2>Why Choose ParkWise?</h2>
            <div class="feature-list">
                <div class="feature-item">
                    <div class="feature-icon">🚗</div>
                    <div class="feature-text">
                        <h3>Easy Booking</h3>
                        <p>Book parking spots in advance with just a few clicks</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">💰</div>
                    <div class="feature-text">
                        <h3>Save Money</h3>
                        <p>Get the best rates and exclusive parking deals</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">📱</div>
                    <div class="feature-text">
                        <h3>Real-Time Updates</h3>
                        <p>Check availability and manage bookings on the go</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">🔒</div>
                    <div class="feature-text">
                        <h3>Secure Payment</h3>
                        <p>Multiple payment options with bank-level security</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>