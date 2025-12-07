<div class="main-display">
    <div class="header">
        <div class="welcome">
            <h1>Booking Details</h1>
            <p>Reserve your parking slot</p>
        </div>
    </div>

    <form method="POST" action="?controller=UserController&action=showPaymentPage" class="booking-details-wrapper">
        
        <!-- Left Card - Booking Information -->
        <div class="card booking-info-card">
            <h2>📋 Booking Information</h2>
            
            <div class="info-section">
                <div class="info-row">
                    <div class="info-box">
                        <span class="info-label">Booking ID</span>
                        <span class="info-value">#<?= str_pad($content['slotDetails']['slot_id'], 6, '0', STR_PAD_LEFT) ?></span>
                    </div>
                    <div class="info-box">
                        <span class="info-label">Amount</span>
                        <span class="info-value amount-highlight">₱50.00</span>
                    </div>
                </div>

                <div class="info-row single">
                    <div class="info-box full">
                        <span class="info-label">Date</span>
                        <span class="info-value"><?= date('F d, Y') ?></span>
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <div class="parking-info-section">
                <h3>Parking Info</h3>
                
                <div class="parking-details">
                    <div class="parking-item">
                        <span class="parking-label">User ID</span>
                        <span class="parking-value">#<?= str_pad($content['userData']['user_id'], 6, '0', STR_PAD_LEFT) ?></span>
                    </div>

                    <div class="parking-item">
                        <span class="parking-label">Vehicle ID</span>
                        <span class="parking-value" id="display-vehicle-id">#000000</span>
                    </div>

                    <div class="parking-item">
                        <span class="parking-label">Slot ID</span>
                        <span class="parking-value">#<?= str_pad($content['slotDetails']['slot_id'], 6, '0', STR_PAD_LEFT) ?></span>
                    </div>

                    <div class="parking-item">
                        <span class="parking-label">Slot</span>
                        <span class="parking-value"><?= htmlspecialchars($content['slotDetails']['slot_number']) ?></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="vehicle_id">
                    <i class="fa-solid fa-car"></i>
                    Select Vehicle
                </label>
                <select name="vehicle_id" id="vehicle_id" class="form-input" required>
                    <option value="">-- Choose a vehicle --</option>
                    <?php foreach($content['userVehicles'] as $vehicle): ?>
                        <option value="<?= $vehicle['vehicle_id'] ?>" 
                                data-brand="<?= htmlspecialchars($vehicle['brand']) ?>"
                                data-type="<?= htmlspecialchars($vehicle['vehicle_type']) ?>"
                                data-plate="<?= htmlspecialchars($vehicle['plate_number']) ?>">
                            <?= htmlspecialchars($vehicle['brand']) ?> - 
                            <?= htmlspecialchars($vehicle['vehicle_type']) ?> 
                            (<?= htmlspecialchars($vehicle['plate_number']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="time-selection">
                <div class="form-group">
                    <label for="start_time">
                        <i class="fa-solid fa-clock"></i>
                        Start Time
                    </label>
                    <input type="datetime-local" name="start_time" id="start_time" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="end_time">
                        <i class="fa-solid fa-clock"></i>
                        End Time
                    </label>
                    <input type="datetime-local" name="end_time" id="end_time" class="form-input" required>
                </div>
            </div>

            <input type="hidden" name="slot_id" value="<?= $content['slotDetails']['slot_id'] ?>">
        </div>

        <!-- Right Card - Rate Information -->
        <div class="card rate-info-card">
            <h2>💰 Per Hour Amount Base Rate</h2>
            
            <div class="rate-display">
                <div class="rate-circle">
                    <div class="rate-amount">₱50.00</div>
                    <div class="rate-text">per 1 hour</div>
                </div>
            </div>

            <div class="rate-details">
                <p><strong>The total amount base on the start time to the end time, the total amount based on the booking's duration</strong></p>
            </div>

            <button type="submit" class="confirm-btn">
                <i class="fa-solid fa-check-circle"></i>
                Confirm Booking
            </button>
        </div>

    </form>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set minimum datetime to current time
        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        const currentDateTime = now.toISOString().slice(0, 16);
        
        const startInput = document.getElementById('start_time');
        const endInput = document.getElementById('end_time');
        
        startInput.min = currentDateTime;
        endInput.min = currentDateTime;

        // Update vehicle ID display when vehicle is selected
        const vehicleSelect = document.getElementById('vehicle_id');
        const vehicleIdDisplay = document.getElementById('display-vehicle-id');
        
        vehicleSelect.addEventListener('change', function() {
            if(this.value) {
                vehicleIdDisplay.textContent = '#' + String(this.value).padStart(6, '0');
            } else {
                vehicleIdDisplay.textContent = '#000000';
            }
        });

        // When start time changes, update end time minimum
        startInput.addEventListener('change', function() {
            endInput.min = this.value;
            if(endInput.value && endInput.value <= this.value) {
                endInput.value = '';
            }
        });

        // Validate end time is after start time
        endInput.addEventListener('change', function() {
            if(startInput.value && this.value <= startInput.value) {
                alert('End time must be after start time');
                this.value = '';
            }
        });

        // Form validation before submit
        const form = document.querySelector('.booking-details-wrapper');
        form.addEventListener('submit', function(e) {
            const vehicleId = document.getElementById('vehicle_id').value;
            const startTime = document.getElementById('start_time').value;
            const endTime = document.getElementById('end_time').value;

            if(!vehicleId) {
                e.preventDefault();
                alert('Please select a vehicle');
                return false;
            }

            if(!startTime || !endTime) {
                e.preventDefault();
                alert('Please select start and end time');
                return false;
            }

            if(endTime <= startTime) {
                e.preventDefault();
                alert('End time must be after start time');
                return false;
            }
        });
    });
</script>