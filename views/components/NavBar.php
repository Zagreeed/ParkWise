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

    <li class="nav-item active" onclick="showSection('dashboard', event)" data-tooltip="Dashboard">
      <i class="fa-solid fa-chart-line"></i>
      <span class="nav-label">Dashboard</span>
    </li>

    <li class="nav-item" onclick="showSection('slots', event)" data-tooltip="Parking Slots">
      <i class="fa-solid fa-square-parking"></i>
      <span class="nav-label">Parking Slots</span>
    </li>

    <li class="nav-item" onclick="showSection('bookings', event)" data-tooltip="Bookings">
      <i class="fa-solid fa-calendar-check"></i>
      <span class="nav-label">Bookings</span>
    </li>

    <li class="nav-item" onclick="showSection('users', event)" data-tooltip="Users">
      <i class="fa-solid fa-users"></i>
      <span class="nav-label">Users</span>
    </li>

    <li class="nav-item" onclick="showSection('payments', event)" data-tooltip="Payments">
      <i class="fa-solid fa-credit-card"></i>
      <span class="nav-label">Payments</span>
    </li>

    <li class="nav-item" onclick="logout()" data-tooltip="Logout">
      <i class="fa-solid fa-right-from-bracket"></i>
      <span class="nav-label">Logout</span>
    </li>

  </ul>
</div>
