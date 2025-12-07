<div class="sidebar collapsed" id="sidebar">

  <!-- Logo -->
  <div class="sidebar-icon" onclick="showSection('dashboard', event)">
    <img src="<?php echo BASE_URL?>views/static/Images/logo1.png" alt="ParkWise Icon">
  </div>

  <!-- Menu Toggle -->
  <div class="menu-toggle" id="toggleSidebar">
    <i class="fa-solid fa-bars burger"></i>
    <span class="menu-label">Menu</span>
    
  </div>

  <ul class="sidebar-nav">

    <li class="nav-item <?= $location == 'dashBoard' ? 'active' : '' ?>" data-tooltip="Dashboard">
      <a href="?controller=AdminController&action=getDashBoardData">
        <i class="fa-solid fa-chart-line"></i>
        <span class="nav-label">Dashboard</span>
      </a>
    </li>

    <li class="nav-item <?= $location == 'slotPage' ? 'active' : '' ?>" data-tooltip="Parking Slots">
      <a href="?controller=AdminController&action=getParkingSlotsPage">
        <i class="fa-solid fa-square-parking"></i>
        <span class="nav-label">Parking Slots</span>
      </a>
    </li>

    <li class="nav-item <?= $location == 'bookingsPages' ? 'active' : '' ?>"  data-tooltip="Bookings">
      <a href="?controller=AdminController&action=getBookingsPage">
        <i class="fa-solid fa-calendar-check"></i>
        <span class="nav-label">Bookings</span>
      </a>
    </li>

    <li class="nav-item <?= $location == 'userPages' ? 'active' : '' ?>" data-tooltip="Users">
      <a href="?controller=AdminController&action=getUserContactPage">
        <i class="fa-solid fa-users"></i>
        <span class="nav-label">Users</span>
      </a>
    </li>

    <li class="nav-item <?= $location == 'paymentsPage' ? 'active' : '' ?>"  data-tooltip="Payments">
      <a href="?controller=AdminController&action=getPaymentsPage">
        <i class="fa-solid fa-credit-card"></i>
        <span class="nav-label">Payments</span>
      </a>
    </li>

    <li class="nav-item" data-tooltip="Logout">
      <a href="?controller=AdminController&action=">
        <i class="fa-solid fa-right-from-bracket"></i>
        <span class="nav-label">Logout</span>
      </a>
    </li>

  </ul>
</div>

<script>
    // Sidebar Toggle
  const sidebar = document.getElementById('sidebar');
  const toggleBtn = document.getElementById('toggleSidebar');

  toggleBtn.addEventListener('click', function() {
      sidebar.classList.toggle('collapsed');
  });
</script>
