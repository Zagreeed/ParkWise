<div class="main-display">
    <div class="header">
        <div class="welcome">
            <h1>Payment Method</h1>
            <p>Complete your booking payment</p>
        </div>
    </div>

    <form method="POST" action="?controller=UserController&action=processPayment" class="payment-wrapper">
 
        <div class="card payment-card">
            <h2>💳 Payment Method</h2>

            <div class="payment-summary">
                <div class="summary-item">
                    <span class="summary-label">Booking ID</span>
                    <span class="summary-value">#<?= str_pad($content['bookingData']['slot_id'], 6, '0', STR_PAD_LEFT) ?></span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Amount</span>
                    <?php if($content['is_open_time']): ?>
                        <span class="summary-value" style="color: #ff9800; font-weight: 700;">
                            <i class="fa-solid fa-infinity"></i> TBD
                        </span>
                    <?php else: ?>
                        <span class="summary-value amount-highlight">₱<?= number_format($content['amount'], 2) ?></span>
                    <?php endif; ?>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Date</span>
                    <span class="summary-value"><?= date('M d, Y', strtotime($content['bookingData']['start_time'])) ?></span>
                </div>
            </div>

            <?php if($content['is_open_time']): ?>
                <div style="background: #fff3e0; border-left: 4px solid #ff9800; padding: 1rem; border-radius: 8px; margin: 1.5rem 0;">
                    <p style="margin: 0; color: #e65100; font-weight: 600;">
                        <i class="fa-solid fa-info-circle"></i> Open Time Booking
                    </p>
                    <p style="margin: 0.5rem 0 0 0; font-size: 0.85rem; color: #ef6c00;">
                        Payment will be calculated based on your actual parking duration. Final amount will be determined when you complete the booking.
                    </p>
                </div>
            <?php endif; ?>
   
            <div class="payment-methods-section">
                <h3>Digital Wallets</h3>
                
                <label class="payment-method-option">
                    <input type="radio" name="payment_method" value="gcash" required>
                    <div class="payment-method-card">
                        <div class="payment-icon gcash-bg">
                            <i class="fa-solid fa-wallet"></i>
                        </div>
                        <div class="payment-name">
                            <span>Gcash</span>
                        </div>
                        <div class="payment-arrow">
                            <i class="fa-solid fa-circle-plus"></i>
                        </div>
                    </div>
                </label>

                <h3>Credit/Debit Cards</h3>
                
                <label class="payment-method-option">
                    <input type="radio" name="payment_method" value="mastercard">
                    <div class="payment-method-card">
                        <div class="payment-icon card-bg">
                            <i class="fa-solid fa-credit-card"></i>
                        </div>
                        <div class="payment-name">
                            <span>Credit/Debit Card</span>
                        </div>
                        <div class="payment-arrow">
                            <i class="fa-solid fa-circle-plus"></i>
                        </div>
                    </div>
                </label>

                <h3>Other Payment Options</h3>
                
                <label class="payment-method-option">
                    <input type="radio" name="payment_method" value="paypal">
                    <div class="payment-method-card">
                        <div class="payment-icon paypal-bg">
                            <i class="fa-brands fa-paypal"></i>
                        </div>
                        <div class="payment-name">
                            <span>PayPal</span>
                        </div>
                        <div class="payment-arrow">
                            <i class="fa-solid fa-circle-plus"></i>
                        </div>
                    </div>
                </label>

                <label class="payment-method-option">
                    <input type="radio" name="payment_method" value="cash">
                    <div class="payment-method-card">
                        <div class="payment-icon cash-bg">
                            <i class="fa-solid fa-money-bill-wave"></i>
                        </div>
                        <div class="payment-name">
                            <span>Cash Payment</span>
                        </div>
                        <div class="payment-arrow">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                    </div>
                </label>
            </div>

            <div class="security-note">
                <i class="fa-solid fa-shield-halved"></i>
                <p>For security, we do not save payment info. We do not have access to your payment details platform, so we do not have access to your payment details</p>
            </div>
        </div>

        <div class="card booking-details-card">
            <h2>📄 Booking Details</h2>

            <div class="details-list">
                <div class="detail-row">
                    <span class="detail-label">Username</span>
                    <span class="detail-value"><?= htmlspecialchars($content['userData']['username']) ?></span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Vehicle</span>
                    <span class="detail-value">
                        <?= htmlspecialchars($content['vehicleDetails']['brand']) ?> 
                        <?= htmlspecialchars($content['vehicleDetails']['vehicle_type']) ?>
                    </span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Plate Number</span>
                    <span class="detail-value"><?= htmlspecialchars($content['vehicleDetails']['plate_number']) ?></span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Slot</span>
                    <span class="detail-value"><?= htmlspecialchars($content['slotDetails']['slot_number']) ?></span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Location</span>
                    <span class="detail-value"><?= htmlspecialchars($content['slotDetails']['location']) ?></span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Start Time</span>
                    <span class="detail-value"><?= date('M d, Y - h:i A', strtotime($content['bookingData']['start_time'])) ?></span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">End Time</span>
                    <?php if($content['is_open_time']): ?>
                        <span class="detail-value" style="color: #ff9800;">
                            <i class="fa-solid fa-infinity"></i> Open Time
                        </span>
                    <?php else: ?>
                        <span class="detail-value"><?= date('M d, Y - h:i A', strtotime($content['bookingData']['end_time'])) ?></span>
                    <?php endif; ?>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Duration</span>
                    <?php if($content['is_open_time']): ?>
                        <span class="detail-value" style="color: #ff9800;">To be determined</span>
                    <?php else: ?>
                        <span class="detail-value"><?= $content['hours'] ?> hour(s)</span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="total-section">
                <span class="total-label">Total Amount</span>
                <?php if($content['is_open_time']): ?>
                    <span class="total-amount" style="color: white;">
                        <i class="fa-solid fa-infinity"></i> TBD
                    </span>
                <?php else: ?>
                    <span class="total-amount">₱<?= number_format($content['amount'], 2) ?></span>
                <?php endif; ?>
                <button type="submit" class="confirm-payment-btn">
                    <i class="fa-solid fa-lock"></i>
                    Confirm Payment
                </button>
            </div>
        </div>

    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('.payment-wrapper');
        const isOpenTime = <?= $content['is_open_time'] ? 'true' : 'false' ?>;
        
        form.addEventListener('submit', function(e) {
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
            
            if(!paymentMethod) {
                e.preventDefault();
                alert('Please select a payment method');
                return false;
            }

            // Show specific confirmation for open time bookings
            if(isOpenTime) {
                const confirmMsg = 'This is an Open Time booking.\n\n' +
                                 'Payment status will remain PENDING until you complete your parking.\n' +
                                 'The final amount will be calculated based on your actual parking duration.\n\n' +
                                 'Continue?';
                if(!confirm(confirmMsg)) {
                    e.preventDefault();
                    return false;
                }
            } else if(paymentMethod.value === 'cash') {
                // Show confirmation for cash payment on normal bookings
                if(!confirm('You have selected Cash payment. Please pay at the parking facility when you arrive.')) {
                    e.preventDefault();
                    return false;
                }
            }
        });
    });
</script>