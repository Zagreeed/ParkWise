<section class="section visible">
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
        <tbody>
          <?php if(isset($content) && is_array($content) && count($content) > 0): ?>
            <?php foreach($content as $booking): ?>
              <tr>
                <td><?= htmlspecialchars($booking['booking_id'] ?? '') ?></td>
                <td><?= htmlspecialchars($booking['username'] ?? '') ?></td>
                <td><?= htmlspecialchars($booking['vehicle'] ?? '') ?></td>
                <td><?= htmlspecialchars($booking['slot'] ?? '') ?></td>
                <td><?= htmlspecialchars($booking['start_time'] ?? '') ?></td>
                <td><?= htmlspecialchars($booking['end_time'] ?? '') ?></td>
                
                  <td>
                    <form  class="updateForm" action="?controller=AdminController&action=updateBookingStatus" method="post">
                      <input type="hidden" name="booking_id" value="<?= $booking['booking_id']?>">
                      <select name="status" onchange="this.form.submit()" id="selectedStatus" class="status <?= $booking['status']?>" class="status-dropdown">
                        <option  class="status active"  value="active" <?= $booking['status'] == "active" ? "selected" : "" ?>>Active</option>
                        <option  class="status completed" value="completed" <?= $booking['status'] == "completed" ? "selected" : "" ?>>Completed</option>
                        <option  class="status pending" value="pending" <?= $booking['status'] == "pending" ? "selected" : "" ?>>Pending</option>
                      </select>
                    </form>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="7" style="text-align: center; padding: 2rem; color: #666;">
                No bookings found
              </td>
            </tr>
          <?php endif; ?>
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