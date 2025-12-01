 <section id="dashboard" class="section visible">
        <h1>Dashboard</h1>

        <div class="cards-container">
         
            <div class="card"><h3>Total Bookings</h3><p> <?= $content["totalBookings"]?> </p></div>
            <div class="card"><h3>Available Slots</h3><p> <?= $content["availableSlot"]?> </p></div>
            <div class="card"><h3>Total Revenue</h3><p>  <?= $content["totalRevenue"]?> </p></div>
            <div class="card"><h3>Total Users</h3><p> <?= $content["totalUser"]?> </p></div>
        </div>

        <!-- ANALYTICS CARDS -->
        <div class="analytics-row">

            <!-- Donut Chart Card -->
            <div class="chart-card donut-chart">
                <h3>Parking Slot Status</h3>
                 <canvas id="donutChart" width="350" height="270"></canvas>
            </div>

            <!-- Weekly Revenue Card -->
            <div class="chart-card">
                <h3>Weekly Revenue</h3>
                  <canvas id="barChart"></canvas>
            </div>

        </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
                    
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

    </script>

