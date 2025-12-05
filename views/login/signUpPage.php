<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo BASE_URL?>views/static/signUpStyle.css">
    <title>ParkWise - Sign Up</title>
   
</head>
<body>
    <div class="signup-container">
        <div class="signup-left">



            <div class="signup-logo">Park<span>Wise</span></div>
            <p class="signup-tagline">Smart parking solutions for modern cities</p>
            
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

        <div class="signup-right">
            <div class="signup-header">
                <h1>Create Account</h1>
                <p>Join thousands of users who trust ParkWise</p>
            </div>

            <form class="signup-form" method="post" action="?controller=UserController&action=signUp">
                <div class="form-group">
                    <label for="username">User Name</label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username"
                        class="form-input" 
                        placeholder="Enter your user name"
                        required
                    >
                    <input type="hidden" name="role" value="user">
                </div>

                <div class="form-group">
                    <label for="phonenumber">Phone Number</label>
                    <input 
                        type="text" 
                        id="phonenumber" 
                        name="phonenumber"
                        class="form-input" 
                        placeholder="Enter your phone number"
                        required
                    >
                </div>

                <div class="form-group full-width">
                    <label for="address">Address</label>
                    <input 
                        type="text" 
                        id="address" 
                        name="address"
                        class="form-input" 
                        placeholder="Enter your address"
                        required
                    >
                </div>

                <div class="form-group full-width">
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

                <div class="form-group full-width">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password"
                        class="form-input" 
                        placeholder="Create a strong password"
                        required
                    >
                </div>

                <button type="submit" class="signup-btn">Sign Up</button>

                <div class="signup-footer">
                    <p>Already have an account? <a href="?controller=UserController&action=showLoginPage" class="login-link">Login</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>