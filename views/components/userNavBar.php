
            <div class="logo">Park<span>Wise</span></div>
            <nav>
                <a href="?controller=UserController&action=showDashBoard" class="<?= $location == 'dashBoard' ? 'active' : '' ?>">
                    <img src="<?php echo BASE_URL?>views/static/Images/dashboard-icon.png" alt="Dashboard" class="menu-icon">
                    <span>Dashboard</span>
                </a>
                <a href="?controller=UserController&action=showMyVehiclePage"class="<?= $location == 'myVehiclePage' ? 'active' : '' ?>">
                    <img src="<?php echo BASE_URL?>views/static/Images/vehicle-icon.png" alt="My Vehicles" class="menu-icon">
                    <span>My Vehicles</span>
                </a>
                <a href="?controller=UserController&action=showBookingsPage" class="<?= $location == 'bookParkingPage' ? 'active' : '' ?>">
                    <img src="<?php echo BASE_URL?>views/static/Images/book-icon.png" alt="Book Parking" class="menu-icon">
                    <span>Book Parking</span>
                </a>
                <a href="?controller=UserController&action=showActivityHistoryPage" class=" <?= $location == 'activityHistoryPage' ? 'active' : '' ?>">
                    <img src="<?php echo BASE_URL?>views/static/Images/activity-icon.png" alt="Activity History" class="menu-icon">
                    <span>Activity History</span>
                </a>
                <a href="?controller=UserController&action=showProfilePage" class="<?= $location == 'profilePage' ? 'active' : '' ?>" >
                    <img src="<?php echo BASE_URL?>views/static/Images/profile-icon.png" alt="Profile" class="menu-icon">
                    <span>Profile</span>
                </a>
                <a id="logout" href="#">
                    <img src="<?php echo BASE_URL?>views/static/Images/profile-icon.png" alt="Logout" class="menu-icon">
                    <span>Logout</span>
                </a>
            </nav>
