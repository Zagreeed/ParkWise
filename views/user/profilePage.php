   <div class="main-display">

            <div class="header">
                <div class="welcome">
                    <h1>My Profile</h1>
                    <p>Manage your account information</p>
                </div>
            </div>
            <div class="content-grid">
                <form class="card" method="post" action="?controller=UserController&action=updateProfile">
                    <h2>👤 Personal Information</h2>
                    <div class="profile-section">
                        <div class="avatar-large">JD</div>
                        <div class="profile-form">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="username" class="form-input" value="<?=$content["username"]?>">
                                <input type="hidden" name="id" value="<?=$content["user_id"]?>">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-input" value="<?=$content["email"]?>">
                            </div>
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="tel" name="phonenumber" class="form-input" value="<?=$content["phonenumber"]?>">
                            </div>
                            <button class="action-btn" style="width: 100%;">Update Profile</button>
                        </div>
                    </div>
                </form>

                <div class="card-security">
                    <h2>🔒 Security</h2>
                    <div class="security-section">
                        <button class="action-btn-outline">Change Password</button>
                        <button class="action-btn-outline">Enable Two-Factor Authentication</button>
                    </div>
                </div>
            </div>
        </div>