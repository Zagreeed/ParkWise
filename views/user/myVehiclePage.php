<div class="main-display">

            <div class="header">
                <div class="welcome">
                    <h1>My Vehicles</h1>
                    <p>Manage your registered vehicles</p>
                </div>
            </div>

            <div class="card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                    <h2>🚗 Registered Vehicles</h2>
                    <button class="action-btn" style="padding: 0.8rem 1.5rem;">+ Add New Vehicle</button>
                </div>

                <div class="vehicle-list">

                    <?php foreach($content as $vehicle):?>
                        <div class="vehicle-card">
                            <div class="vehicle-icon">🚙</div>
                            <div class="vehicle-info">
                                <h3><?= $vehicle["brand"]?></h3>
                                <p class="plate-number"><?= $vehicle["plate_number"]?></p>
                                <p class="vehicle-details">Color: Silver | Type: <?= $vehicle["vehicle_type"]?></p>
                            </div>
                            <div class="vehicle-actions">
                                <button class="btn-edit">Edit</button>
                                <button class="btn-delete">Delete</button>
                            </div>
                        </div>
                    <?php endforeach;?>

                    
                </div>
            </div>
        </div>