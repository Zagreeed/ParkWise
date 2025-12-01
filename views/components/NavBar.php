
<div class="sidebar">
    <h2>Admin Panel</h2>

    <ul>
        <a href="?controller=AdminController&action=getDashBoardData">
            <li  class="<?php  echo $location == "dashBoard" ? "active" : "" ?>">
                    
                        <i class="fa-solid fa-chart-line"></i> Dashboard
                        
            </li>
        
        </a>

        <a href="?controller=AdminController&action=getParkingSlotsPage">
                <li  class="<?php echo $location == "slotPage" ? "active" : "" ?>">
                

                    <i class="fa-solid fa-square-parking"></i> Parking Slots
                    
                </li>
        </a>
        
        <a href="?controller=AdminController&action=getBookingsPage">
        
                    <li  class="<?php echo $location == "bookingsPages" ? "active" : "" ?>">
                
                        <i class="fa-solid fa-calendar-check"></i> Bookings
                        
                    </li>
            </a>
            
            <a href="?controller=AdminController&action=getUserContactPage">
                        <li  class="<?php echo $location == "userPages" ? "active" : "" ?>">


                            <i class="fa-solid fa-users"></i> Users
                        
                        </li>
            </a>

            <a href="?controller=AdminController&action=getPaymentsPage">
                        <li class="<?php echo $location == "paymentsPage" ? "active" : "" ?>">
                    

                             <i class="fa-solid fa-credit-card"></i> Payments
                        </li>
            </a>
              

        <li >
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </li>
    </ul>
</div>
