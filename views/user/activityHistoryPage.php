    <div class="main-display">
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