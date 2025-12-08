<div class="main-display">
    <div class="header">
        <div class="welcome">
            <h1>Edit Vehicle</h1>
            <p>Update your vehicle information</p>
        </div>
    </div>

    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <h2>🚗 Edit Vehicle Details</h2>

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

        <form method="post" action="?controller=UserController&action=updateVehicle" class="modal-form">
            <input type="hidden" name="vehicle_id" value="<?= $content['vehicle_id'] ?>">

            <div class="form-group">
                <label for="plate_number">License Plate Number</label>
                <input 
                    type="text" 
                    id="plate_number" 
                    name="plate_number"
                    class="form-input" 
                    placeholder="e.g., ABC-1234"
                    value="<?= htmlspecialchars($content['plate_number']) ?>"
                    required
                    maxlength="20"
                >
            </div>

            <div class="form-group">
                <label for="brand">Vehicle Brand</label>
                <input 
                    type="text" 
                    id="brand" 
                    name="brand"
                    class="form-input" 
                    placeholder="e.g., Toyota, Honda, Ford"
                    value="<?= htmlspecialchars($content['brand']) ?>"
                    required
                    maxlength="50"
                >
            </div>

            <div class="form-group">
                <label class="vehicle-type-label">Vehicle Type</label>
                <div class="vehicle-type-grid">
                    <div class="vehicle-type-option">
                        <input type="radio" name="vehicle_type" value="Car" id="type_car" 
                            <?= $content['vehicle_type'] == 'Car' ? 'checked' : '' ?> required>
                        <label for="type_car" class="vehicle-type-button">
                            <span class="vehicle-type-icon">🚗</span>
                            <span class="vehicle-type-name">Car</span>
                        </label>
                    </div>

                    <div class="vehicle-type-option">
                        <input type="radio" name="vehicle_type" value="Motorcycle" id="type_motorcycle" 
                            <?= $content['vehicle_type'] == 'Motorcycle' ? 'checked' : '' ?> required>
                        <label for="type_motorcycle" class="vehicle-type-button">
                            <span class="vehicle-type-icon">🏍️</span>
                            <span class="vehicle-type-name">Motorcycle</span>
                        </label>
                    </div>

                    <div class="vehicle-type-option">
                        <input type="radio" name="vehicle_type" value="Truck" id="type_truck" 
                            <?= $content['vehicle_type'] == 'Truck' ? 'checked' : '' ?> required>
                        <label for="type_truck" class="vehicle-type-button">
                            <span class="vehicle-type-icon">🚚</span>
                            <span class="vehicle-type-name">Truck</span>
                        </label>
                    </div>
                </div>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="action-btn" style="flex: 1;">
                    <i class="fa-solid fa-save"></i> Update Vehicle
                </button>
                <a href="?controller=UserController&action=showMyVehiclePage" 
                   class="action-btn-outline" 
                   style="flex: 1; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                    <i class="fa-solid fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<style>
.error-message p {
    margin: 0.3rem 0;
}
</style>