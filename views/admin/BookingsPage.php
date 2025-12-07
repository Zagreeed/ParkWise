 <section class="section">
    <h1>Bookings</h1>
    <p class="section-subtitle">View and manage all parking bookings.</p>

    <div class="table-wrapper">
      <table class="data-table">
        <thead>
          <tr>
            <th>Booking ID</th>
            <th>User</th>
            <th>Vehicle</th>
            <th>Slot</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </section>

  <script>
      // Sidebar Toggle
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebar');

    toggleBtn.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
    });
</script>

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


