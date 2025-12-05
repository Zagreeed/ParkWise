<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>ParkWise Admin - <?= ucfirst($location ?? 'Dashboard') ?></title>
    
    <!-- FONT AWESOME ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- ADMIN STYLES -->
    <link rel="stylesheet" href="<?php echo BASE_URL?>views/static/dashboard-style.css">
</head>
<body class="dashboard-body">

    <!-- SIDEBAR -->
    <?php require_once("./views/components/NavBar.php")?>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <?php require_once("./views/admin/$fileName" . ".php")?>
    </div>

    <!-- CHART.JS LIBRARY -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- GLOBAL ADMIN SCRIPT (handles navigation, sidebar, etc.) -->
    <script>
        // Global Admin Dashboard Script
        document.addEventListener("DOMContentLoaded", () => {
        
        /* SIDEBAR TOGGLE */
        const sidebar = document.getElementById("sidebar");
        const toggleBtn = document.getElementById("toggleSidebar");

        if (toggleBtn && sidebar) {
            toggleBtn.addEventListener("click", () => {
            sidebar.classList.toggle("collapsed");
            });
        }

        /* SECTION NAVIGATION */
        window.showSection = function (sectionId, event) {
            const sections = document.querySelectorAll(".section");
            sections.forEach(sec => sec.classList.remove("visible"));

            const target = document.getElementById(sectionId);
            if (target) target.classList.add("visible");

            document.querySelectorAll(".sidebar ul li").forEach(li => li.classList.remove("active"));
            if (event && event.currentTarget) {
            event.currentTarget.classList.add("active");
            }
        };

        /* LOGOUT */
        window.logout = function () {
            if (confirm("Are you sure you want to logout?")) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '?controller=UserController&action=logout';
            document.body.appendChild(form);
            form.submit();
            }
        };

        /* AUTO-HIGHLIGHT ACTIVE PAGE */
        const urlParams = new URLSearchParams(window.location.search);
        const currentAction = urlParams.get('action');
        
        const actionToSection = {
            'getDashBoardData': 'dashboard',
            'getParkingSlotsPage': 'slots',
            'getBookingsPage': 'bookings',
            'getPaymentsPage': 'payments',
            'getUserContactPage': 'users'
        };

        if (currentAction && actionToSection[currentAction]) {
            const sectionId = actionToSection[currentAction];
            const navItems = document.querySelectorAll('.sidebar ul li');
            
            navItems.forEach(item => {
            const onclick = item.getAttribute('onclick');
            if (onclick && onclick.includes(sectionId)) {
                item.classList.add('active');
            }
            });
        }
        });
    </script>

</body>
</html>