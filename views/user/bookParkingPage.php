    <div class="main-display">

            <div class="header">
                <div class="welcome">
                    <h1>Book Parking</h1>
                    <p>Find and reserve your parking spot</p>
                </div>
            </div>

            <div class="parking-card">
                <h2>🔍 Select Parking Slot</h2>
                    <div class="parking-grid">

                        <?php foreach($content as $slot):?>
                            <div class="parking-spot <?= $slot["status"]?>" onclick="selectSpot('A3')">
                                <div class="spot-number"><?= $slot["slot_number"]?></div>
                                <div class="spot-status"><?= $slot["status"]?></div>
                            </div>
                        <?php endforeach;?>

                        
                    </div>
                </div>
            </div>
            <!-- You can open the modal using ID.showModal() method -->
            <dialog id="my_modal_3" class="modal">
            <div class="modal-box">
                <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <h3 class="text-lg font-bold">Hello!</h3>
                <p class="py-4">Press ESC key or click on ✕ button to close</p>
            </div>
            </dialog>
    </div>