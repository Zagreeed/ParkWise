<div class="main-display">

   
            <div class="header">
                <div class="welcome">
                    <h1>Welcome back, <?= $content['userData']['username']?></h1>
                    <p>Tuesday, December 3, 2025</p>
                </div>
                <div class="user-info">
                    <div class="avatar">JD</div>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">🚗</div>
                    <h3>Total Bookings</h3>
                    <div class="value"><?= $content["totalBookings"]?></div>
                    <div class="change">+1 from last week</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">⏰</div>
                    <h3>Hours Parked (This Month)</h3>
                    <div class="value"><?= $content["totalHourseSpent"]?></div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">💰</div>
                    <h3>Total Spent</h3>
                    <div class="value">₱<?= $content["totalSpent"]?></div>
                    <div class="change">This month</div>
                </div>
            </div>

            <div class="content-grid">
                <div class="card">
                    <h2>🅿️ Available Parking Spots</h2>
                    <div class="parking-grid">


                        


                       <?php foreach($content["availableParkingSlot"] as $slot ):?>
                            <div class="parking-spot available">
                                <div class="spot-number"><?= $slot["slot_number"]?></div>
                                <div class="spot-status"><?= $slot["status"]?></div>
                            </div>
                        <?php endforeach;?>



                    </div>
                    <p class="show-parking"><a href="?controller=UserController&action=showBookingsPage">show more</a></p>
                </div>

                <div class="card">
                    <h2>🕐 Recent Activity</h2>

                    <?php foreach($content["activityHistory"] as $activity):?>
                            
                        <div class="activity-item">
                            <div class="activity-time"><?= $activity["date_booked"]?></div>
                            <div class="activity-description">Parked at Spot <?= $activity["slot_number"]?> - ₱<?= $activity["amount_paid"]?></div>
                        </div>

                    <?php endforeach;?>

                   
                </div>
            </div>

            <div class="card">
                <h2>⚡ Quick Actions</h2>
                <div class="quick-actions">
                    <button class="action-btn" onclick="window.location.href='?controller=UserController&action=showBookingsPage'">Book New Parking</button>
                    <button class="action-btn">Extend Current Booking</button>
                    <button class="action-btn" onclick="window.location.href='?controller=UserController&action=showMyVehiclePage'">Add New Vehicle</button>
                    <button class="action-btn" onclick="window.location.href='?controller=UserController&action=showActivityHistoryPage'">View Activity History</button>
                </div>
            </div>
        </div>