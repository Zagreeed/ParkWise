<div class="main-display">
            <div class="header">
                <div class="welcome">
                    <h1>Welcome back, John!</h1>
                    <p>Tuesday, December 3, 2025</p>
                </div>
                <div class="user-info">
                    <div class="avatar">JD</div>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">🚗</div>
                    <h3>Active Bookings</h3>
                    <div class="value">2</div>
                    <div class="change">+1 from last week</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">⏰</div>
                    <h3>Hours Parked (This Month)</h3>
                    <div class="value">48</div>
                    <div class="change">12 hours remaining</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">💰</div>
                    <h3>Total Spent</h3>
                    <div class="value">₱2,450</div>
                    <div class="change">This month</div>
                </div>
            </div>

            <div class="content-grid">
                <div class="card">
                    <h2>🅿️ Available Parking Spots</h2>
                    <div class="parking-grid">
                        <div class="parking-spot available">
                            <div class="spot-number">A1</div>
                            <div class="spot-status">VACANT</div>
                        </div>
                        <div class="parking-spot available">
                            <div class="spot-number">A2</div>
                            <div class="spot-status">VACANT</div>
                        </div>
                        <div class="parking-spot available">
                            <div class="spot-number">A3</div>
                            <div class="spot-status">VACANT</div>
                        </div>
                        <div class="parking-spot available">
                            <div class="spot-number">A4</div>
                            <div class="spot-status">VACANT</div>
                        </div>
                        <div class="parking-spot available">
                            <div class="spot-number">A5</div>
                            <div class="spot-status">VACANT</div>
                        </div>
                        <div class="parking-spot available">
                            <div class="parking-spot-number">A6</div>
                            <div class="spot-status">VACANT</div>
                        </div>
                        <div class="parking-spot available">
                            <div class="spot-number">A7</div>
                            <div class="spot-status">VACANT</div>
                        </div>
                        <div class="parking-spot available">
                            <div class="spot-number">A8</div>
                            <div class="spot-status">VACANT</div>
                        </div>
                        <div class="parking-spot available">
                            <div class="spot-number">A9</div>
                            <div class="spot-status">VACANT</div>
                        </div>
                        <div class="parking-spot available">
                            <div class="spot-number">A10</div>
                            <div class="spot-status">VACANT</div>
                        </div>
                        <div class="parking-spot available">
                            <div class="spot-number">A11</div>
                            <div class="spot-status">VACANT</div>
                        </div>
                        <div class="parking-spot available">
                            <div class="spot-number">A12</div>
                            <div class="spot-status">VACANT</div>
                        </div>
                    </div>
                    <p class="show-parking"><a href="?controller=UserController&action=showBookingsPage">show more</a></p>
                </div>

                <div class="card">
                    <h2>🕐 Recent Activity</h2>
                    <div class="activity-item">
                        <div class="activity-time">2 hours ago</div>
                        <div class="activity-description">Parked at Spot A4 - Ayala Mall</div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-time">Yesterday, 3:30 PM</div>
                        <div class="activity-description">Payment completed - ₱200</div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-time">Dec 1, 10:00 AM</div>
                        <div class="activity-description">Booking confirmed - SM North</div>
                    </div>
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