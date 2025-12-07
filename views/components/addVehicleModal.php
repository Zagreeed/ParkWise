 <!-- Modal -->
    <div class="modal-overlay" id="addVehicleModal">
        <div class="modal-container">
            <div class="modal-header">
                <h2>🚗 Add New Vehicle</h2>
                <button class="modal-close" onclick="closeAddVehicleModal()">&times;</button>
            </div>

            <form class="modal-form" method="post" action="?controller=UserController&action=addVehicle">
                <!-- Hidden User ID (you'll need to set this from PHP) -->
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['userId'] ?? ''; ?>">

                <!-- License Plate Number -->
                <div class="form-group">
                    <label for="plate_number">License Plate Number</label>
                    <input 
                        type="text" 
                        id="plate_number" 
                        name="plate_number"
                        class="form-input" 
                        placeholder="e.g., ABC-1234"
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
                        required
                        maxlength="50"
                    >
                </div>

                <div class="form-group">
                    <label class="vehicle-type-label">Vehicle Type</label>
                    <div class="vehicle-type-grid">
                  
                        <div class="vehicle-type-option">
                            <input type="radio" name="vehicle_type" value="Car" id="type_car" required>
                            <label for="type_car" class="vehicle-type-button">
                                <span class="vehicle-type-icon">🚗</span>
                                <span class="vehicle-type-name">Car</span>
                            </label>
                        </div>

                     
                        <div class="vehicle-type-option">
                            <input type="radio" name="vehicle_type" value="Motorcycle" id="type_motorcycle" required>
                            <label for="type_motorcycle" class="vehicle-type-button">
                                <span class="vehicle-type-icon">🏍️</span>
                                <span class="vehicle-type-name">Motorcycle</span>
                            </label>
                        </div>

                        <div class="vehicle-type-option">
                            <input type="radio" name="vehicle_type" value="Truck" id="type_truck" required>
                            <label for="type_truck" class="vehicle-type-button">
                                <span class="vehicle-type-icon">🚚</span>
                                <span class="vehicle-type-name">Truck</span>
                            </label>
                        </div>
                    </div>
                </div>

                
                <button type="submit" class="modal-submit">Add Vehicle</button>
            </form>
        </div>
    </div>


     <script>
        function openAddVehicleModal() {
            document.getElementById('addVehicleModal').classList.add('active');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        function closeAddVehicleModal() {
            document.getElementById('addVehicleModal').classList.remove('active');
            document.body.style.overflow = ''; // Restore scrolling
        }

        // Close modal when clicking outside
        document.getElementById('addVehicleModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAddVehicleModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAddVehicleModal();
            }
        });
    </script>