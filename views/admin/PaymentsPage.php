 <section id="payments" class="section visible">
    <h1>Payments</h1>
    <p class="section-subtitle">Track and manage all payment transactions.</p>

    <div class="table-wrapper">
      <table class="data-table">
        <thead>
          <tr>
            <th>Payment ID</th>
            <th>Booking ID</th>
            <th>Amount</th>
            <th>Method</th>
            <th>Status</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody id="paymentsTable">

          <?php foreach($content as $payment):?>

             <tr>
              <td><?= $payment["payment_id"]?></td>
              <td><?= $payment["booking_id"]?></td>
              <td><?= $payment["amount"]?></td>
              <td><?= $payment["payment_method"]?></td>
              <td><span class="status <?= $payment["payment_status"]?>"><?= $payment["payment_status"]?></span></td>
              <td><?= $payment["payment_date"]?></td>
            </tr>

          <?php endforeach;?>

        </tbody>
      </table>
    </div>
  </section>



<script>
  // Only run sidebar toggle - remove dashboard-specific code
  document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebar');

    if (toggleBtn && sidebar) {
      toggleBtn.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
      });
    }
  });
</script>