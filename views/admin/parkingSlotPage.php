<section id="slots" class="section visible">

    <h1>Parking Slots</h1>
    <p class="section-subtitle">Manage and monitor parking slots.</p>

    <?php if(isset($_SESSION["success"])): ?>
        <div class="success-message" style="background: #e8f5e9; color: #2e7d32; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; animation: slideDown 0.3s ease;">
            <p style="margin: 0;">✓ <?= htmlspecialchars($_SESSION["success"]) ?></p>
        </div>
        <?php unset($_SESSION["success"]); ?>
    <?php endif; ?>

    <?php if(isset($_SESSION["errors"])): ?>
        <div class="error-message" style="background: #ffebee; color: #c62828; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; animation: slideDown 0.3s ease;">
            <p style="margin: 0;">⚠ <?= htmlspecialchars($_SESSION["errors"]) ?></p>
        </div>
        <?php unset($_SESSION["errors"]); ?>
    <?php endif; ?>

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
                <td><strong><?= htmlspecialchars($slot['slot_number'] ?? '') ?></strong></td>
                <td><?= htmlspecialchars($slot['location'] ?? '') ?></td>
                
                <td>
                  <form class="updateSlotForm" action="?controller=AdminController&action=updateSlotStatus" method="post">
                    <input type="hidden" name="slot_id" value="<?= $slot['slot_id'] ?>">
                    <select 
                      name="status" 
                      class="status-dropdown status slot-status-dropdown <?= $slot['status'] ?>" 
                      onchange="confirmSlotStatusChange(this, '<?= htmlspecialchars($slot['slot_number']) ?>', '<?= $slot['status'] ?>')"
                      data-original-status="<?= $slot['status'] ?>"
                    >
                      <option class="status available" value="available" <?= $slot['status'] == "available" ? "selected" : "" ?>>
                        Available
                      </option>
                      <option class="status occupied" value="occupied" <?= $slot['status'] == "occupied" ? "selected" : "" ?>>
                        Occupied
                      </option>
                      <option class="status reserved" value="reserved" <?= $slot['status'] == "reserved" ? "selected" : "" ?>>
                        Reserved
                      </option>
                    </select>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5" style="text-align: center; padding: 2rem; color: #666;">
                No parking slots found
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
</section>

<script>
  // Sidebar Toggle
  document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebar');

    if (toggleBtn && sidebar) {
      toggleBtn.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
      });
    }

    // Initialize dropdown colors
    document.querySelectorAll('.slot-status-dropdown').forEach(dropdown => {
      updateDropdownColor(dropdown);
    });
  });

  // Confirm slot status change
  function confirmSlotStatusChange(selectElement, slotNumber, currentStatus) {
    const newStatus = selectElement.value;
    const form = selectElement.closest('form');
    
    if(newStatus === currentStatus) {
      return; 
    }

    let confirmMessage = '';
    
    if(newStatus === 'occupied') {
      confirmMessage = `Mark Slot ${slotNumber} as OCCUPIED?\n\nThis will prevent users from booking this slot.\nUse this for maintenance or blocked slots.`;
    } else if(newStatus === 'available') {
      confirmMessage = `Mark Slot ${slotNumber} as AVAILABLE?\n\nUsers will be able to book this slot.`;
    } else if(newStatus === 'reserved') {
      confirmMessage = `Mark Slot ${slotNumber} as RESERVED?\n\nThis slot will show as reserved.`;
    }

    if(confirm(confirmMessage)) {
      updateDropdownColor(selectElement);
      form.submit();
    } else {
      
      selectElement.value = selectElement.getAttribute('data-original-status');
      updateDropdownColor(selectElement);
    }
  }

 
  function updateDropdownColor(dropdown) {
    dropdown.classList.remove('available', 'occupied', 'reserved');
    const selectedValue = dropdown.value;
    dropdown.classList.add(selectedValue);
  }

  
  setTimeout(() => {
    const successMsg = document.querySelector('.success-message');
    const errorMsg = document.querySelector('.error-message');
    
    if(successMsg) {
      successMsg.style.transition = 'opacity 0.5s ease';
      successMsg.style.opacity = '0';
      setTimeout(() => successMsg.remove(), 500);
    }
    
    if(errorMsg) {
      errorMsg.style.transition = 'opacity 0.5s ease';
      errorMsg.style.opacity = '0';
      setTimeout(() => errorMsg.remove(), 500);
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


  .slot-status-dropdown {
    font-size: 0.9rem;
    padding: 0.5rem 0.8rem;
    min-width: 110px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .slot-status-dropdown:hover {
    transform: scale(1.02);
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
  }


  td .status {
    display: inline-block;
    min-width: 90px;
    text-align: center;
  }
</style>