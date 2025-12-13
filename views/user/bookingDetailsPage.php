<div class="main-display">
    <div class="header">
        <div class="welcome">
            <h1>Booking Details</h1>
            <p>Reserve your parking slot</p>
        </div>
    </div>


    <form method="POST" action="?controller=UserController&action=showPaymentPage" class="booking-details-wrapper">
        
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
                        <span class="info-value amount-highlight" id="display-amount">₱50.00</span>
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

                <div class="form-group" id="end-time-group">
                    <label for="end_time">
                        <i class="fa-solid fa-clock"></i>
                        End Time
                    </label>
                    <input type="datetime-local" name="end_time" id="end_time" class="form-input">
                </div>
            </div>

            <!-- Open Time Checkbox -->
           
            <div class="form-group" style="margin-top: 1rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" id="open_time_checkbox" name="open_time" value="1" 
                        style="width: 18px; height: 18px; cursor: pointer; accent-color: #66bb6a;">
                    <span style="font-weight: 600; color: #1b5e20;">
                        <i class="fa-solid fa-infinity"></i>
                        Open Time (Uncertain end time)
                    </span>
                </label>
                <p style="font-size: 0.85rem; color: #666; margin-top: 0.5rem; margin-left: 1.5rem;">
                    Select this if you don't know how long you'll need the parking spot. Payment will be calculated when you leave.
                </p>
            </div>

            <input type="hidden" name="slot_id" value="<?= $content['slotDetails']['slot_id'] ?>">
        </div>

        <div class="card rate-info-card">
            <h2>💰 Per Hour Amount Base Rate</h2>
            
            <div class="rate-display">
                <div class="rate-circle">
                    <div class="rate-amount">₱50.00</div>
                    <div class="rate-text">per 1 hour</div>
                </div>
            </div>

            <div class="rate-details">
                <p id="rate-description"><strong>The total amount based on the start time to the end time, the total amount based on the booking's duration</strong></p>
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
        const openTimeCheckbox = document.getElementById('open_time_checkbox');
        const endTimeGroup = document.getElementById('end-time-group');
        const displayAmount = document.getElementById('display-amount');
        const rateDescription = document.getElementById('rate-description');
        
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

        // Handle Open Time checkbox
        openTimeCheckbox.addEventListener('change', function() {
            if(this.checked) {
                // Disable end time input
                endInput.disabled = true;
                endInput.required = false;
                endInput.value = '';
                endTimeGroup.style.opacity = '0.5';
                endTimeGroup.style.pointerEvents = 'none';
                
                // Update display
                displayAmount.textContent = 'TBD';
                displayAmount.style.color = '#ff9800';
                rateDescription.innerHTML = '<strong>⏰ Open Time selected. The total amount will be calculated based on actual parking duration when you check out.</strong>';
                rateDescription.style.background = '#fff3e0';
                rateDescription.style.borderLeft = '4px solid #ff9800';
            } else {
                // Enable end time input
                endInput.disabled = false;
                endInput.required = true;
                endTimeGroup.style.opacity = '1';
                endTimeGroup.style.pointerEvents = 'auto';
                
                // Reset display
                displayAmount.textContent = '₱50.00';
                displayAmount.style.color = '#2e7d32';
                rateDescription.innerHTML = '<strong>The total amount based on the start time to the end time, the total amount based on the booking\'s duration</strong>';
                rateDescription.style.background = '#fff3cd';
                rateDescription.style.borderLeft = '4px solid #ffc107';
            }
        });

        // When start time changes, update end time minimum
        startInput.addEventListener('change', function() {
            if(!openTimeCheckbox.checked) {
                endInput.min = this.value;
                if(endInput.value && endInput.value <= this.value) {
                    endInput.value = '';
                }
            }
        });

        // Validate end time is after start time
        endInput.addEventListener('change', function() {
            if(!openTimeCheckbox.checked && startInput.value && this.value <= startInput.value) {
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
            const isOpenTime = openTimeCheckbox.checked;

            if(!vehicleId) {
                e.preventDefault();
                alert('Please select a vehicle');
                return false;
            }

            if(!startTime) {
                e.preventDefault();
                alert('Please select start time');
                return false;
            }

            if(!isOpenTime && !endTime) {
                e.preventDefault();
                alert('Please select end time or check "Open Time"');
                return false;
            }

            if(!isOpenTime && endTime <= startTime) {
                e.preventDefault();
                alert('End time must be after start time');
                return false;
            }
        });
    });
</script>