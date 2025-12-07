<section id="users" class="section visible">
    <h1>Users</h1>
    <p class="section-subtitle">Manage registered users and their information.</p>

    <div class="table-wrapper">
      <table class="data-table">
        <thead>
          <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
          </tr>
        </thead>
        <tbody>
          <?php if(isset($content) && is_array($content) && count($content) > 0): ?>
            <?php foreach($content as $user): ?>
              <tr>
                <td><?= htmlspecialchars($user['user_id'] ?? '') ?></td>
                <td><?= htmlspecialchars($user['username'] ?? '') ?></td>
                <td><?= htmlspecialchars($user['email'] ?? '') ?></td>
                <td><?= htmlspecialchars($user['phonenumber'] ?? '') ?></td>
                <td><?= htmlspecialchars($user['address'] ?? '') ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5" style="text-align: center; padding: 2rem; color: #666;">
                No users found
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