<div class="main-display">

    <div class="header">
        <div class="welcome">
            <h1>My Vehicles</h1>
            <p>Manage your registered vehicles</p>
        </div>
    </div>

    <div class="card">
        <?php if(isset($_SESSION["success"])): ?>
            <div class="success-message" style="background: #e8f5e9; color: #2e7d32; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                <p style="margin: 0;">✓ <?= htmlspecialchars($_SESSION["success"]) ?></p>
            </div>
            <?php unset($_SESSION["success"]); ?>
        <?php endif; ?>

        <?php if(isset($_SESSION["errors"])): ?>
            <div class="error-message" style="background: #ffebee; color: #c62828; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                <?php 
                    if(is_array($_SESSION["errors"])){
                        foreach($_SESSION["errors"] as $error){
                            echo "<p style='margin: 0.3rem 0;'>• " . htmlspecialchars($error) . "</p>";
                        }
                    } else {
                        echo "<p style='margin: 0;'>" . htmlspecialchars($_SESSION["errors"]) . "</p>";
                    }
                    unset($_SESSION["errors"]);
                ?>
            </div>
        <?php endif; ?>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h2>🚗 Registered Vehicles</h2>
            <button class="action-btn" onclick="openAddVehicleModal()" style="padding: 0.8rem 1.5rem;">
                <i class="fa-solid fa-plus"></i> Add New Vehicle
            </button>
        </div>

        <?php if(empty($content)): ?>
            <div style="text-align: center; padding: 3rem; color: #666;">
                <i class="fa-solid fa-car" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                <p style="font-size: 1.1rem;">No vehicles registered yet</p>
                <p>Add your first vehicle to start booking parking spots</p>
            </div>
        <?php else: ?>
            <div class="vehicle-list">
                <?php foreach($content as $vehicle): ?>
                    <div class="vehicle-card">
                        <div class="vehicle-icon">
                            <?= $vehicle["vehicle_type"] == 'Car' ? "🚗" : ($vehicle["vehicle_type"] == 'Motorcycle' ? "🏍" : "🚛") ?>
                        </div>
                        <div class="vehicle-info">
                            <h3><?= htmlspecialchars($vehicle["brand"]) ?></h3>
                            <p class="plate-number"><?= htmlspecialchars($vehicle["plate_number"]) ?></p>
                            <p class="vehicle-details">
                                Added: <?= date('M d, Y', strtotime($vehicle["created_at"])) ?> | 
                                Type: <?= htmlspecialchars($vehicle["vehicle_type"]) ?>
                            </p>
                        </div>
                        <div class="vehicle-actions">
                            <a href="?controller=UserController&action=showEditVehiclePage&vehicle_id=<?= $vehicle["vehicle_id"] ?>" 
                               class="btn-edit" 
                               style="text-decoration: none; display: inline-block;">
                                <i class="fa-solid fa-edit"></i> Edit
                            </a>
                            <button type="button" 
                                    class="btn-delete" 
                                    onclick="confirmDelete(<?= $vehicle['vehicle_id'] ?>)">
                                <i class="fa-solid fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <?php require_once("./views/components/addVehicleModal.php") ?>
</div>


<form id="deleteVehicleForm" method="post" action="?controller=UserController&action=deleteVehicle" style="display: none;">
    <input type="hidden" name="vehicle_id" id="deleteVehicleId">
</form>

<script>
    function confirmDelete(vehicleId) {
        if(confirm('Are you sure you want to delete this vehicle? This action cannot be undone.')) {
            document.getElementById('deleteVehicleId').value = vehicleId;
            document.getElementById('deleteVehicleForm').submit();
        }
    }
</script>

<style>
    .success-message, .error-message {
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .btn-edit, .btn-delete {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .btn-edit i, .btn-delete i {
        font-size: 0.9rem;
    }
</style>