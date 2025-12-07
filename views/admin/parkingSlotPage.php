<section id="slots" class="section visible">


    <h1>Parking Slots</h1>
    <p class="section-subtitle">Manage and monitor parking slots.</p>

    <div class="table-wrapper">
      <table class="data-table">
        <thead>
          <tr>
            <th>Slot ID</th>
            <th>Slot Number</th>
            <th>Location</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php if(isset($content) && is_array($content) && count($content) > 0): ?>
            <?php foreach($content as $slot): ?>
              <tr>
                <td><?= htmlspecialchars($slot['slot_id'] ?? '') ?></td>
                <td><?= htmlspecialchars($slot['slot_number'] ?? '') ?></td>
                <td><?= htmlspecialchars($slot['location'] ?? '') ?></td>
                <td>
                      <select class="status <?= $slot['status']?>" class="status-dropdown">
                        <option  class="status active"  value="Available" <?= $slot['status'] == "available" ? "selected" : "" ?>>Available</option>
                        <option  class="status completed" value="Occupied" <?= $slot['status'] == "occupied" ? "selected" : "" ?>>Occupied</option>
                        <option  class="status pending" value="Reserved" <?= $slot['status'] == "reserved" ? "selected" : "" ?>>Reserved</option>
                      </select>
                  </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="4" style="text-align: center; padding: 2rem; color: #666;">
                No parking slots found
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