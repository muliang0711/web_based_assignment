<?php
// main.php
include_once __DIR__ . "/../../_base.php";
$stylesheetArray = ['../../css/main.css'];
link_stylesheet($stylesheetArray);
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel (No Bootstrap)</title>
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>

  <!-- Include Topbar -->
  <?php include 'topbar.php'; ?>

  <!-- Include Sidebar -->
  <?php include 'sidebar.php'; ?>

  <!-- Main Content Area -->
  <div class="main-content">
    <!-- Example Search/Filter Section -->
    <div style="margin-bottom: 1rem;">
      <form style="display: flex; gap: 1rem;">
        <div style="flex: 1;">
          <input type="text" placeholder="Search..." style="width: 100%; padding: 0.5rem;">
        </div>
        <select style="padding: 0.5rem;">
          <option>All Categories</option>
          <option>Active</option>
          <option>Pending</option>
          <option>Archived</option>
        </select>
        <input type="date" style="padding: 0.5rem;">
        <button type="reset" style="padding: 0.5rem;">
          <i class="fas fa-undo"></i> Reset
        </button>
      </form>
    </div>

    <!-- Alert -->
    <div style="background-color: #d4edda; color: #155724; padding: 0.75rem; margin-bottom: 1rem; border: 1px solid #c3e6cb;">
      <i class="fas fa-check-circle"></i> Data updated successfully!
    </div>

    <!-- Example Data Table -->
    <div style="border: 1px solid #ccc; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
      <div style="background-color: #007bff; color: #fff; padding: 0.75rem;">
        <h5 style="margin: 0;"><i class="fas fa-table"></i> Recent Orders</h5>
      </div>
      <div style="padding: 1rem;">
        <table style="width: 100%; border-collapse: collapse;">
          <thead>
            <tr style="background-color: #f9f9f9;">
              <th style="padding: 0.75rem; border: 1px solid #ddd;">Order ID</th>
              <th style="padding: 0.75rem; border: 1px solid #ddd;">Customer</th>
              <th style="padding: 0.75rem; border: 1px solid #ddd;">Status</th>
              <th style="padding: 0.75rem; border: 1px solid #ddd;">Total</th>
              <th style="padding: 0.75rem; border: 1px solid #ddd;">Status</th>
              <th style="padding: 0.75rem; border: 1px solid #ddd;">Total</th>
              <th style="padding: 0.75rem; border: 1px solid #ddd;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="padding: 0.75rem; border: 1px solid #ddd;">#1234</td>
              <td style="padding: 0.75rem; border: 1px solid #ddd;">John Doe</td>
              <td style="padding: 0.75rem; border: 1px solid #ddd;">#1234</td>
              <td style="padding: 0.75rem; border: 1px solid #ddd;">John Doe</td>
              <td style="padding: 0.75rem; border: 1px solid #ddd;">
                <span style="background-color: #28a745; color: #fff; padding: 0.25rem 0.5rem; border-radius: 0.25rem;">Completed</span>
              </td>
              <td style="padding: 0.75rem; border: 1px solid #ddd;">$199.99</td>
              <td style="padding: 0.75rem; border: 1px solid #ddd;">
                <button style="padding: 0.3rem 0.6rem; border: 1px solid #007bff; background: none; cursor: pointer; color: #007bff;">
                  <i class="fas fa-eye"></i>
                </button>
                <button style="padding: 0.3rem 0.6rem; border: 1px solid #dc3545; background: none; cursor: pointer; color: #dc3545;">
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>
            <tr>
              <td style="padding: 0.75rem; border: 1px solid #ddd;">#1234</td>
              <td style="padding: 0.75rem; border: 1px solid #ddd;">John Doe</td>
              <td style="padding: 0.75rem; border: 1px solid #ddd;">#1234</td>
              <td style="padding: 0.75rem; border: 1px solid #ddd;">John Doe</td>
              <td style="padding: 0.75rem; border: 1px solid #ddd;">
                <span style="background-color: #28a745; color: #fff; padding: 0.25rem 0.5rem; border-radius: 0.25rem;">Completed</span>
              </td>
              <td style="padding: 0.75rem; border: 1px solid #ddd;">$199.99</td>
              <td style="padding: 0.75rem; border: 1px solid #ddd;">
                <button style="padding: 0.3rem 0.6rem; border: 1px solid #007bff; background: none; cursor: pointer; color: #007bff;">
                  <i class="fas fa-eye"></i>
                </button>
                <button style="padding: 0.3rem 0.6rem; border: 1px solid #dc3545; background: none; cursor: pointer; color: #dc3545;">
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>
            <!-- Additional rows as needed -->
          </tbody>
        </table>

      </div>
    </div>
  </div>

  <script>
    // SIDEBAR TOGGLE
    document.getElementById('sidebarToggle').addEventListener('click', function() {
      document.getElementById('sidebar').classList.toggle('active');
    });

    // DARK MODE TOGGLE
    document.getElementById('darkModeToggle').addEventListener('click', function() {
      const htmlEl = document.documentElement;
      const isDark = htmlEl.getAttribute('data-theme') === 'dark';
      htmlEl.setAttribute('data-theme', isDark ? 'light' : 'dark');
    });
  </script>
</body>
</html>
