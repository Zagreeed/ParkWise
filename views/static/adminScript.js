/* --------------------------
   LOGIN SYSTEM
--------------------------- */
function login() {
    const loginType = document.getElementById("loginType").value;
    const username = document.getElementById("username").value;
    const pass = document.getElementById("password").value;
    const errorMsg = document.getElementById("errorMsg");

    if (username === "" || pass === "") {
        errorMsg.textContent = "Please enter username and password.";
        return;
    }

    if (loginType === "admin") {
        if (username === "admin" && pass === "admin123") {
            window.location.href = "admin.html";
        } else {
            errorMsg.textContent = "Invalid admin credentials.";
        }
    } else {
        // placeholder – user dashboard later
        errorMsg.textContent = "User dashboard not yet created.";
    }
}

/* --------------------------
   SECTION SWITCHING
--------------------------- */
function showSection(sectionId) {
    document.querySelectorAll(".section").forEach(sec => sec.classList.remove("visible"));
    document.getElementById(sectionId).classList.add("visible");

    document.querySelectorAll(".sidebar li").forEach(li => li.classList.remove("active"));
    event.target.classList.add("active");
}

/* --------------------------
   LOGOUT
--------------------------- */
function logout() {
    window.location.href = "index.html";
}

/* --------------------------
   SAMPLE ERD DATA
--------------------------- */

// Parking Slots
const slotsData = [
    { id: 1, number: "A1", location: "North Wing", status: "Available" },
    { id: 2, number: "A2", location: "North Wing", status: "Occupied" },
    { id: 3, number: "B1", location: "South Wing", status: "Available" },
];

slotsData.forEach(s => {
    document.getElementById("slotsTable").innerHTML += `
        <tr>
            <td>${s.id}</td>
            <td>${s.number}</td>
            <td>${s.location}</td>
            <td>${s.status}</td>
        </tr>
    `;
});

// Bookings
const bookingsData = [
    { id: "B112", user: "John Cruz", vehicle: "ABC-123", slot: "A1", start: "10:00", end: "12:00", status: "Active" },
    { id: "B113", user: "Ana Reyes", vehicle: "XYZ-900", slot: "B1", start: "09:00", end: "11:00", status: "Completed" },
];

bookingsData.forEach(b => {
    document.getElementById("bookingsTable").innerHTML += `
        <tr>
            <td>${b.id}</td>
            <td>${b.user}</td>
            <td>${b.vehicle}</td>
            <td>${b.slot}</td>
            <td>${b.start}</td>
            <td>${b.end}</td>
            <td class="status ${b.status.toLowerCase()}">${b.status}</td>
        </tr>
    `;
});

// Users
const usersData = [
    { id: 1, username: "johnc", email: "john@gmail.com", phone: "0912345678", address: "Manila" },
    { id: 2, username: "ana", email: "ana@gmail.com", phone: "0998765432", address: "QC" },
];

usersData.forEach(u => {
    document.getElementById("usersTable").innerHTML += `
        <tr>
            <td>${u.id}</td>
            <td>${u.username}</td>
            <td>${u.email}</td>
            <td>${u.phone}</td>
            <td>${u.address}</td>
        </tr>
    `;
});

// Payments
const paymentsData = [
    { id: 1, booking: "B112", amount: "₱200", method: "GCash", status: "Paid", date: "2025-01-10" },
];

paymentsData.forEach(p => {
    document.getElementById("paymentsTable").innerHTML += `
        <tr>
            <td>${p.id}</td>
            <td>${p.booking}</td>
            <td>${p.amount}</td>
            <td>${p.method}</td>
            <td>${p.status}</td>
            <td>${p.date}</td>
        </tr>
    `;
});

// SHOW SECTIONS FUNCTION
function showSection(sectionId) {
    document.querySelectorAll('.section').forEach(sec => sec.classList.remove('visible'));
    document.getElementById(sectionId).classList.add('visible');

    document.querySelectorAll('.sidebar ul li').forEach(li => li.classList.remove('active'));
    event.target.classList.add('active');
}

/* ---------------------------
   PARKING OCCUPANCY DONUT CHART
--------------------------- */
const donutCtx = document.getElementById('donutChart').getContext('2d');

const donutChart = new Chart(donutCtx, {
    type: 'doughnut',
    data: {
        labels: ['Occupied', 'Available'],
        datasets: [{
            data: [68, 32], // Example: change numbers anytime
            backgroundColor: ['#27ae60', '#f7c66c'],
            hoverBackgroundColor: ['#1e8f4c', '#e0b35e'],
            borderWidth: 1
        }]
    },
    options: {
        cutout: '65%',
        plugins: {
            legend: {
                position: 'right',
                labels: { boxWidth: 12, padding: 15 }
            }
        }
    }
});

/* ---------------------------
   WEEKLY REVENUE BAR CHART
--------------------------- */
const barCtx = document.getElementById('barChart').getContext('2d');

const barChart = new Chart(barCtx, {
    type: 'bar',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            label: 'Revenue (₱)',
            data: [3500, 4200, 5000, 6100, 8300, 9000, 9500],
            backgroundColor: '#165036ff',
            hoverBackgroundColor: '#90ceb2ff',
            borderRadius: 8,
            barThickness: 30 // width of each bar in pixels
        }]
    },
    options: {
        scales: {
            x: {
                categoryPercentage: 0.2, // controls spacing between bars (smaller = more space)
                barPercentage: 1          // full width of bar within its category
            },
            y: {
                beginAtZero: true,
                ticks: { stepSize: 2000 }
            }
        },
        plugins: {
            legend: { display: false }
        }
    }
});

