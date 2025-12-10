    <div class="main-display">

         <?php if(isset($_SESSION["success"])): ?>
            <div class="success-message" style="background:  #2e7d32; color: #e8f5e9; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; animation: slideDown 0.3s ease;">
                <p style="margin: 0;">✓ <?= htmlspecialchars($_SESSION["success"]) ?></p>
            </div>
            <?php unset($_SESSION["success"]); ?>
        <?php endif; ?>

        <?php if(isset($_SESSION["errors"])): ?>
            <div class="error-message" style="background: #ffebee; color: #c62828; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; animation: slideDown 0.3s ease;">
                <p style="margin: 0;">⚠ <?= htmlspecialchars($_SESSION["errors"]) ?></p>
            </div>
            <?php unset($_SESSION["errors"]); ?>
        <?php endif; ?>


            <div class="header">

                <div class="welcome">
                    <h1>Activity History</h1>
                    <p>Your parking and payment history</p>
                </div>
            </div>



            <div class="card">
                <h2>📅 Recent Activity</h2>
                <div class="activity-list">


                    <?php foreach($content as $activity):?>
                    
                        <?php if($activity["activity_type"] == "booking_confirmed"):?>
                            
                             <div class="activity-item-full">
                                <div class="activity-header">
                                    <div>
                                        <h3><?= $activity["description"]?></h3>
                                        <p class="activity-time"><?= $activity["activity_time"]?></p>
                                    </div>
                                    <div class="activity-status <?= $activity["activity_status"]?>"><?= $activity["activity_status"]?></div>
                                </div>
                                <div class="activity-details">
                                    <p><strong>Spot:</strong> <?= $activity["slot_number"]?> | <strong>Vehicle:</strong> <?= $activity["vehicle_brand"]?> <?= $activity["vehicle_type"]?> (<?= $activity["vehicle_plate"]?>)</p>
                                    <p><strong>Duration:</strong> <?= $activity["duration_hours"]?> hours | <strong>Amount:</strong> ₱<?= $activity["amount"]?></p>
                                </div>
                            </div>

                        <?php endif;?>



                        <?php if($activity["activity_type"] == "payment_completed"):?>
                            
                               <div class="activity-item-full">
                                    <div class="activity-header">
                                        <div>
                                            <h3> <?= $activity["description"]?></h3>
                                            <p class="activity-time"><?= $activity["activity_time"]?></p>
                                        </div>
                                        <div class="activity-status completed"><?= $activity["activity_status"]?></div>
                                    </div>
                                    <div class="activity-details">
                                        <p><strong>Amount:</strong> <?= $activity["amount"]?> | <strong>Method:</strong> <?= $activity["payment_method"]?></p>
                                    </div>
                                </div>

                        <?php endif;?>

                    
                    <?php endforeach;?>


                  
                </div>
            </div>
        </div>
    </div>

    <script>
         // Confirm slot status change
  function confirmSlotStatusChange(selectElement, slotNumber, currentStatus) {
    const newStatus = selectElement.value;
    const form = selectElement.closest('form');
    
    if(newStatus === currentStatus) {
      return; 
    }

    let confirmMessage = '';
    
    if(newStatus === 'occupied') {
      confirmMessage = `Mark Slot ${slotNumber} as OCCUPIED?\n\nThis will prevent users from booking this slot.\nUse this for maintenance or blocked slots.`;
    } else if(newStatus === 'available') {
      confirmMessage = `Mark Slot ${slotNumber} as AVAILABLE?\n\nUsers will be able to book this slot.`;
    } else if(newStatus === 'reserved') {
      confirmMessage = `Mark Slot ${slotNumber} as RESERVED?\n\nThis slot will show as reserved.`;
    }

    if(confirm(confirmMessage)) {
      updateDropdownColor(selectElement);
      form.submit();
    } else {
      
      selectElement.value = selectElement.getAttribute('data-original-status');
      updateDropdownColor(selectElement);
    }
  }

  
  setTimeout(() => {
    const successMsg = document.querySelector('.success-message');
    const errorMsg = document.querySelector('.error-message');
    
    if(successMsg) {
      successMsg.style.transition = 'opacity 0.5s ease';
      successMsg.style.opacity = '0';
      setTimeout(() => successMsg.remove(), 500);
    }
    
    if(errorMsg) {
      errorMsg.style.transition = 'opacity 0.5s ease';
      errorMsg.style.opacity = '0';
      setTimeout(() => errorMsg.remove(), 500);
    }
  }, 5000);


    </script>