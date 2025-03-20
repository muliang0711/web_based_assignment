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
          <input type="text" placeholder="Search..." style="width: 50%; padding: 0.5rem;">
        </div>
          <!--filter bar or what right here -->

        <select style="padding: 0.5rem;">
          <option>All Categories</option>
          <option>Active</option>
          <option>Pending</option>
          <option>Archived</option>
        </select>

        <select style="padding: 0.5rem;">
          <option>All Categories</option>
          <option>Active</option>
          <option>Pending</option>
          <option>Archived</option>
        </select>

        <select style="padding: 0.5rem;">
          <option>All Categories</option>
          <option>Active</option>
          <option>Pending</option>
          <option>Archived</option>
        </select>
        
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

    <!-- Example Data Table ： -->
    <table class="tb">
          <thead>
            <tr style="background-color: #f9f9f9;">
              <th class="th">Order ID</th>
              <th class="th">Customer</th>
              <th class="th">Status</th>
              <th class="th">Total</th>
              <th class="th">Status</th>
              <th class="th">Total</th>
              <th class="th">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="td">#1234</td>
              <td class="td">John Doe</td>
              <td class="td">#1234</td>
              <td class="td">John Doe</td>
              <td class="td">
                <span class="status-span">Completed</span>
              </td>
              <td class="td">199.99</td>
              <td class="td">
                <button class="action-btn-add">
                  <i class="fas fa-eye"></i>
                </button>
                <button class="action-btn-delete">
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>
           
            <!-- Additional rows as needed -->
          </tbody>
        </table>


  </div>

  <script>
    // SIDEBAR TOGGLE
    document.getElementById('sidebarToggle').addEventListener('click', function() {
      document.getElementById('sidebar').classList.toggle('active');
    });

  </script>
</body>
</html>
