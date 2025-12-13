<section class="section visible">
    <h1>Bookings</h1>
    <p class="section-subtitle">View and manage all parking bookings.</p>

  
    <!-- SUCCESS MESSAGE ONLY -->
    <?php if(isset($_SESSION["success"])): ?>
        <div class="success-message" style="background: #e8f5e9; color: #2e7d32; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; animation: slideDown 0.3s ease;">
            <p style="margin: 0;">✓ <?= htmlspecialchars($_SESSION["success"]) ?></p>
        </div>
        <?php unset($_SESSION["success"]); ?>
    <?php endif; ?>

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
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if(isset($content) && is_array($content) && count($content) > 0): ?>
            <?php foreach($content as $booking): ?>
              <?php 
                $endDateTime = new DateTime($booking['end_time']);
                $startDateTime = new DateTime($booking['start_time']);
                
                // Check if this is an open time booking by comparing start + 1 hour with end time
                $startPlusOneHour = clone $startDateTime;
                $startPlusOneHour->modify('+1 hour');
                
                // It's open time if end_time equals start_time + 1 hour AND status is not completed
                $isOpenTime = ($endDateTime->format('Y-m-d H:i:s') === $startPlusOneHour->format('Y-m-d H:i:s')) 
                              && $booking['status'] !== 'completed';
              ?>
              <tr>
                <td><?= htmlspecialchars($booking['booking_id'] ?? '') ?></td>
                <td><?= htmlspecialchars($booking['username'] ?? '') ?></td>
                <td><?= htmlspecialchars($booking['vehicle'] ?? '') ?></td>
                <td><?= htmlspecialchars($booking['slot'] ?? '') ?></td>
                <td><?= htmlspecialchars($booking['start_time'] ?? '') ?></td>
                <td>
                  <?php if($isOpenTime): ?>
                    <span style="color: #ff9800; font-weight: 600;">
                      <i class="fa-solid fa-infinity"></i> OPEN TIME
                    </span>
                  <?php else: ?>
                    <?= htmlspecialchars($booking['end_time'] ?? '') ?>
                  <?php endif; ?>
                </td>
                <td>
                  <form class="updateForm" action="?controller=AdminController&action=updateBookingStatus" method="post">
                    <input type="hidden" name="booking_id" value="<?= $booking['booking_id']?>">
                    <select name="status" onchange="this.form.submit()" class="status <?= $booking['status']?>">
                      <option class="status active" value="active" <?= $booking['status'] == "active" ? "selected" : "" ?>>Active</option>
                      <option class="status completed" value="completed" <?= $booking['status'] == "completed" ? "selected" : "" ?>>Completed</option>
                      <option class="status pending" value="pending" <?= $booking['status'] == "pending" ? "selected" : "" ?>>Pending</option>
                    </select>
                  </form>
                </td>
                <td>
                  <?php if($isOpenTime && $booking['status'] == 'active'): ?>
                    <form action="?controller=AdminController&action=completeOpenTimeBooking" method="post" style="display: inline;">
                      <input type="hidden" name="booking_id" value="<?= $booking['booking_id']?>">
                      <button type="submit" 
                              class="btn-complete-open-time"
                              onclick="return confirm('Complete this open-time booking? This will calculate the total amount based on actual parking duration.');"
                              style="background: linear-gradient(135deg, #66bb6a, #43a047); color: white; border: none; padding: 0.5rem 1rem; border-radius: 6px; cursor: pointer; font-size: 0.85rem; font-weight: 600; transition: all 0.3s ease;">
                        <i class="fa-solid fa-check-circle"></i> Complete & Calculate
                      </button>
                    </form>
                  <?php else: ?>
                    <span style="color: #999; font-size: 0.85rem;">—</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="8" style="text-align: center; padding: 2rem; color: #666;">
                No bookings found
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebar');

    if (toggleBtn && sidebar) {
      toggleBtn.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
      });
    }

    document.querySelectorAll('.btn-complete-open-time').forEach(btn => {
      btn.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-2px)';
        this.style.boxShadow = '0 4px 15px rgba(67, 160, 71, 0.4)';
      });
      
      btn.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
        this.style.boxShadow = 'none';
      });
    });
  });

  // AUTO-HIDE SUCCESS MESSAGE ONLY
  setTimeout(() => {
    const successMsg = document.querySelector('.success-message');
    if(successMsg) {
      successMsg.style.transition = 'opacity 0.5s ease';
      successMsg.style.opacity = '0';
      setTimeout(() => successMsg.remove(), 500);
    }
  }, 5000);
</script>

<style>
  @keyframes slideDown {
    from {
      opacity: 0;
      transform: translateY(-10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
</style>