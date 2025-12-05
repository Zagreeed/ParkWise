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
                <td><span class="status <?= strtolower($slot['status'] ?? '') ?>"><?= htmlspecialchars($slot['status'] ?? '') ?></span></td>
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