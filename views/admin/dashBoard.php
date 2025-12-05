<section id="dashboard" class="section visible">
    <h1>Dashboard</h1>

    <div class="greeting-card">
      <div class="greeting-content">
        <div class="greeting-left">
          <h2 id="greetingText">Good morning, ParkWise Admin!</h2>
          <p id="currentDate">Tuesday, 10:34 AM</p>
        </div>

        <div class="greeting-graphic">
          <img src="<?php echo BASE_URL?>views/static/Images/cartoon.png" alt="Greeting">
        </div>
      </div>
    </div>

    <!-- TOTAL CARDS -->
    <div class="cards-container">

      <div class="card">
        <div class="card-top">
          <span class="card-title">Total Bookings</span>
          <i class="fa-solid fa-calendar-check card-icon"></i>
        </div>
        <div class="card-number" id="bookingsCount"><?= $content['totalBookings'] ?? 0 ?></div>
      </div>

      <div class="card">
        <div class="card-top">
          <span class="card-title">Available Slots</span>
          <i class="fa-solid fa-square-parking card-icon"></i>
        </div>
        <div class="card-number" id="availableSlots"><?= $content['availableSlot'] ?? 0 ?></div>
      </div>

      <div class="card">
        <div class="card-top">
          <span class="card-title">Total Revenue</span>
          <i class="fa-solid fa-credit-card card-icon"></i>
        </div>
        <div class="card-number" id="revenueTotal">₱<?= $content['totalRevenue'] ?? 0 ?></div>
      </div>

      <div class="card">
        <div class="card-top">
          <span class="card-title">Total Users</span>
          <i class="fa-solid fa-users card-icon"></i>
        </div>
        <div class="card-number" id="usersCount"><?= $content['totalUser'] ?? 0 ?></div>
      </div>

    </div>

    <!-- ANALYTICS ROW -->
    <div class="analytics-row">
        
        <div class="donut-card">
            <h3>Parking Slot Occupancy</h3>
            <div class="donut-left">
            <canvas id="donutChart"></canvas>
        </div>

        <div class="donut-legend">
          <div class="legend-item">
            <span class="legend-circle available"></span>
            <span>Available</span>
          </div>
          <div class="legend-item">
            <span class="legend-circle occupied"></span>
            <span>Occupied</span>
          </div>
          <div class="legend-item">
            <span class="legend-circle reserved"></span>
            <span>Reserved</span>
          </div>
        </div>
      </div>

      <!-- VEHICLE TYPES -->
      <div class="vehicle-card">
        <h3>Vehicles by Type</h3>

        <div class="vehicle-row">
          <div class="vehicle-label-count">
            <i class="fa-solid fa-motorcycle"></i>
            <span>Motor</span>
          </div>
          <div class="progress-bar">
            <div id="motorProgress" class="progress-fill" style="width: 45%;">
              <b id="motorCount">145</b>
            </div>
          </div>
        </div>

        <div class="vehicle-row">
          <div class="vehicle-label-count">
            <i class="fa-solid fa-car"></i>
            <span>Car</span>
          </div>
          <div class="progress-bar">
            <div id="carProgress" class="progress-fill" style="width: 97%;">
              <b id="carCount">312</b>
            </div>
          </div>
        </div>

        <div class="vehicle-row">
          <div class="vehicle-label-count">
            <i class="fa-solid fa-truck"></i>
            <span>Truck</span>
          </div>
          <div class="progress-bar">
            <div id="truckProgress" class="progress-fill" style="width: 21%;">
              <b id="truckCount">67</b>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

<script>
      // Only run dashboard-specific code if we're on the dashboard
      document.addEventListener("DOMContentLoaded", () => {
        // Check if dashboard elements exist
        const dashboardSection = document.getElementById('dashboard');
        if (!dashboardSection) return;

        const sidebar = document.getElementById("sidebar");
        const toggleBtn = document.getElementById("toggleSidebar");
        const greetingText = document.getElementById("greetingText");
        const currentDateEl = document.getElementById("currentDate");

        /* SIDEBAR TOGGLE */
        if (toggleBtn && sidebar) {
          toggleBtn.addEventListener("click", () => {
            sidebar.classList.toggle("collapsed");
          });
        }

        /* VEHICLE PROGRESS - Only if elements exist */
        const vehicleTypeData = {
          Car: 312,
          Motorcycle: 145,
          Truck: 67,
        };

        const maxVehicle = Math.max(...Object.values(vehicleTypeData));

        const setProgress = (idCount, idProgress, count) => {
          const countEl = document.getElementById(idCount);
          const prog = document.getElementById(idProgress);

          if (countEl) countEl.textContent = count;
          if (prog) {
            const percentage = (count / maxVehicle) * 100;
            prog.style.width = percentage + '%';
          }
        };

        setProgress("carCount", "carProgress", vehicleTypeData.Car || 0);
        setProgress("motorCount", "motorProgress", vehicleTypeData.Motorcycle || 0);
        setProgress("truckCount", "truckProgress", vehicleTypeData.Truck || 0);

        /* DONUT CHART */
        const donutCanvas = document.getElementById("donutChart");
        if (donutCanvas && typeof Chart !== 'undefined') {
          async function loadParkingDonutChart() {
            try {
              const availableCount = <?= $content['availableSlot'] ?? 10 ?>;
              const occupiedCount = 5;
              const reservedCount = 2;

              const ctx = donutCanvas.getContext("2d");

              new Chart(ctx, {
                type: "doughnut",
                data: {
                  labels: ["Available", "Occupied", "Reserved"],
                  datasets: [{
                    data: [availableCount, occupiedCount, reservedCount],
                    backgroundColor: ["#ff4b4b", "#30bf7f", "#ff9f40"],
                    borderWidth: 0,
                    cutout: "60%"
                  }]
                },
                options: {
                  responsive: true,
                  plugins: { legend: { display: false } }
                }
              });
            } catch (error) {
              console.error("Error loading donut chart:", error);
            }
          }
          loadParkingDonutChart();
        }

        /* LIVE GREETING & TIME */
        function updateTime() {
          const now = new Date();
          const hour = now.getHours();

          const opts = { weekday: "long", month: "long", day: "numeric", year: "numeric" };
          if (currentDateEl) {
            currentDateEl.textContent =
              now.toLocaleDateString(undefined, opts) +
              " · " +
              now.toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" });
          }

          let greeting = "Hello";
          if (hour >= 5 && hour < 12) greeting = "Good Morning";
          else if (hour >= 12 && hour < 17) greeting = "Good Afternoon";
          else greeting = "Good Evening";

          if (greetingText) greetingText.textContent = `${greeting}, ParkWise Admin`;
        }

        updateTime();
        setInterval(updateTime, 1000);
      });
  </script>