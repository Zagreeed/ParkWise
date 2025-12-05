 <section id="dashboard" class="section visible">
    <h1>Dashboard</h1>

    <div class="greeting-card">
      <div class="greeting-content">
        <div class="greeting-left">
          <h2 id="greetingText">Good morning, ParkWise Admin!</h2>
          <p id="currentDate">Tuesday, 10:34 AM</p>
        </div>

        <div class="greeting-graphic">
          <img src="images/cartoon.png" alt="Greeting">
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
        <div class="card-number" id="bookingsCount">0</div>
      </div>

      <div class="card">
        <div class="card-top">
          <span class="card-title">Available Slots</span>
          <i class="fa-solid fa-square-parking card-icon"></i>
        </div>
        <div class="card-number" id="availableSlots">0</div>
      </div>

      <div class="card">
        <div class="card-top">
          <span class="card-title">Total Revenue</span>
          <i class="fa-solid fa-credit-card card-icon"></i>
        </div>
        <div class="card-number" id="revenueTotal">₱0</div>
      </div>

      <div class="card">
        <div class="card-top">
          <span class="card-title">Total Users</span>
          <i class="fa-solid fa-users card-icon"></i>
        </div>
        <div class="card-number" id="usersCount">0</div>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script></script>
<script>
      // Ensure DOM ready
    document.addEventListener("DOMContentLoaded", () => {

      /* ==========================
        ELEMENTS
      =========================== */
      const sidebar = document.getElementById("sidebar");
      const toggleBtn = document.getElementById("toggleSidebar");
      const greetingText = document.getElementById("greetingText");
      const currentDateEl = document.getElementById("currentDate");


      /* ==========================
        SIDEBAR TOGGLE (collapse/expand)
      =========================== */
    if (toggleBtn && sidebar) {
      toggleBtn.addEventListener("click", () => {
        sidebar.classList.toggle("collapsed");
      });
    }
    // Removed hover-expand behavior completely

      /* ==========================
        DUMMY DATA
      =========================== */
      const slotsData = [
        { id: 1, number: "A1", location: "North Wing", status: "Available" },
        { id: 2, number: "A2", location: "North Wing", status: "Occupied" },
        { id: 3, number: "B1", location: "South Wing", status: "Available" },
        { id: 4, number: "B2", location: "South Wing", status: "Occupied" },
        { id: 5, number: "C1", location: "East Wing", status: "Reserved" },
        { id: 6, number: "C2", location: "East Wing", status: "Reserved" }
      ];

      const bookingsData = [
        { id: "B112", user: "John Cruz", vehicle: "ABC-123", slot: "A1", start: "10:00", end: "12:00", status: "Active" },
        { id: "B113", user: "Ana Reyes", vehicle: "XYZ-900", slot: "B1", start: "09:00", end: "11:00", status: "Completed" },
        { id: "B114", user: "Mark Santos", vehicle: "DEF-456", slot: "C1", start: "14:00", end: "16:00", status: "Pending" }
      ];

      const usersData = [
        { id: 1, username: "johnc", email: "john@gmail.com", phone: "0912345678", address: "Manila" },
        { id: 2, username: "ana", email: "ana@gmail.com", phone: "0998765432", address: "Quezon City" }
      ];

      const paymentsData = [
        { id: 1, booking: "B112", amount: "₱200", method: "GCash", status: "Paid", date: "2025-01-10" },
        { id: 2, booking: "B114", amount: "₱150", method: "GCash", status: "Pending", date: "2025-01-15" },
        { id: 3, booking: "B113", amount: "₱300", method: "Credit Card", status: "Failed", date: "2025-01-12" }
      ];

      const vehicleTypeData = {
        Car: 312,
        Motorcycle: 145,
        Truck: 67,
      };


      /* ==========================
        REUSABLE TABLE POPULATOR
      =========================== */
      const populateTable = (tableId, data, rowCallback) => {
        const table = document.getElementById(tableId);
        if (!table) return;
        table.innerHTML = "";
        data.forEach(item => {
          table.insertAdjacentHTML("beforeend", rowCallback(item));
        });
      };


      /* ==========================
        DASHBOARD STATS
      =========================== */
      const availableSlots = slotsData.filter(s => s.status === "Available").length;
      const occupiedSlots = slotsData.filter(s => s.status === "Occupied").length;
      const totalBookings = bookingsData.length;
      const totalUsers = usersData.length;
      const totalRevenue = paymentsData.reduce((sum, p) => {
        const numeric = parseInt(p.amount.replace(/[^\d]/g, "")) || 0;
        return sum + numeric;
      }, 0);

      const setText = (id, value) => {
        const el = document.getElementById(id);
        if (el) el.textContent = value;
      };

      setText("availableSlots", availableSlots);
      setText("bookingsCount", totalBookings);
      setText("revenueTotal", `₱${totalRevenue}`);
      setText("usersCount", totalUsers);


      /* ==========================
        VEHICLE PROGRESS
      =========================== */
      const maxVehicle = Math.max(...Object.values(vehicleTypeData));

      const setProgress = (idCount, idProgress, count) => {
        const countEl = document.getElementById(idCount);
        const prog = document.getElementById(idProgress);

        if (countEl) countEl.textContent = count;
        if (prog) {
          prog.max = maxVehicle;
          prog.value = count;
        }
      };

      setProgress("carCount", "carProgress", vehicleTypeData.Car || 0);
      setProgress("motorCount", "motorProgress", vehicleTypeData.Motorcycle || 0);
      setProgress("truckCount", "truckProgress", vehicleTypeData.Truck || 0);


    /* ==========================
        DONUT CHART (SHOULD GET FROM DATABASE)
    =========================== */
    async function loadParkingDonutChart() {
      try {
        // Hardcoded data for testing
        const availableCount = 10;
        const occupiedCount = 5;
        const reservedCount = 2;

        console.log("Parking data:", availableCount, occupiedCount, reservedCount);

        const ctx = document.getElementById("donutChart").getContext("2d");

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

    // Run the function
    loadParkingDonutChart();


    loadParkingDonutChart();

      /* ==========================
        LIVE GREETING & TIME
      =========================== */
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


      /* ==========================
        LOGOUT
      =========================== */
      window.logout = function () {
        if (confirm("Are you sure you want to logout?")) {
          window.location.href = "index.html";
        }
      };


      /* ==========================
        SECTION SWITCHING + TABLE POPULATION
      =========================== */
      window.showSection = function (sectionId, event) {
        document.querySelectorAll(".section").forEach(sec => sec.classList.remove("visible"));

        const target = document.getElementById(sectionId);
        if (target) target.classList.add("visible");

        if (sectionId === "slots") {
          populateTable("slotsTable", slotsData, s => `
            <tr>
              <td>${s.id}</td>
              <td>${s.number}</td>
              <td>${s.location}</td>
              <td><span class="status ${s.status.toLowerCase()}">${s.status}</span></td>
            </tr>
          `);
        }

        if (sectionId === "bookings") {
          populateTable("bookingsTable", bookingsData, b => `
            <tr>
              <td>${b.id}</td>
              <td>${b.user}</td>
              <td>${b.vehicle}</td>
              <td>${b.slot}</td>
              <td>${b.start}</td>
              <td>${b.end}</td>
              <td>
                <select class="status-dropdown">
                  <option value="Active" ${b.status === "Active" ? "selected" : ""}>Active</option>
                  <option value="Completed" ${b.status === "Completed" ? "selected" : ""}>Completed</option>
                  <option value="Pending" ${b.status === "Pending" ? "selected" : ""}>Pending</option>
                </select>
              </td>
            </tr>
          `);
        }

        if (sectionId === "users") {
          populateTable("usersTable", usersData, u => `
            <tr>
              <td>${u.id}</td>
              <td>${u.username}</td>
              <td>${u.email}</td>
              <td>${u.phone}</td>
              <td>${u.address}</td>
            </tr>
          `);
        }

        if (sectionId === "payments") {
          populateTable("paymentsTable", paymentsData, p => `
            <tr>
              <td>${p.id}</td>
              <td>${p.booking}</td>
              <td>${p.amount}</td>
              <td>${p.method}</td>
              <td><span class="status ${p.status.toLowerCase()}">${p.status}</span></td>
              <td>${p.date}</td>
            </tr>
          `);
        }

        document.querySelectorAll(".sidebar ul li").forEach(li => li.classList.remove("active"));
        if (event && event.currentTarget) event.currentTarget.classList.add("active");
      };

      showSection("dashboard");


      /* ==========================
        DROPDOWN COLOR CONTROL
      =========================== */
      const setDropdownColor = (dropdown) => {
        dropdown.classList.remove("active", "completed", "pending");

        const val = dropdown.value.toLowerCase();
        if (val === "active") dropdown.classList.add("active");
        else if (val === "completed") dropdown.classList.add("completed");
        else if (val === "pending") dropdown.classList.add("pending");
      };

      document.querySelectorAll("#bookingsTable .status-dropdown").forEach(setDropdownColor);

      document.getElementById("bookingsTable").addEventListener("change", (e) => {
        if (e.target.classList.contains("status-dropdown")) {
          const newStatus = e.target.value;
          const row = e.target.closest("tr");
          const bookingId = row.cells[0].textContent;

          console.log(`Booking ID ${bookingId} status changed to ${newStatus}`);

          setDropdownColor(e.target);

          // TODO: send update to backend
        }
      });

    });

</script>

