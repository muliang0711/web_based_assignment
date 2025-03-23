<?php
// sidebar.php
include_once __DIR__ . "/_base.php";
$stylesheetArray = ['../css/sidebar.css'];
link_stylesheet($stylesheetArray);
?>
<style>

</style>

<div class="sidebar" id="sidebar">
  <div class="sidebar-header">
    <h4>Admin</h4>
    <button class="sidebar-toggle-btn" id="sidebarToggle">
      <i class="fas fa-bars"></i>
    </button>
  </div>
  <ul class="nav-links">
    <li>
      <a href="../admin/admin_home.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    </li>
    <li>
      <a href="../admin/view_customer.php"><i class="fas fa-users"></i> Customer</a>
    </li>
    <li>
      <a href="../admin/admin_Management.php"><i class="fas fa-users"></i> Admin</a>
    </li>
    <li>
      <a href="../admin/admin_product.php"><i class="fas fa-boxes"></i> Products</a>
    </li>
    <li>
      <a href="../admin/admin_order.php"><i class="fas fa-shopping-cart"></i> Orders</a>
    </li>
    <li>
      <a href="../admin/admin_test.php"><i class="fas fa-chart-line"></i> Reports</a>
    </li>
    <li>
      <a href="#"><i class="fas fa-cog"></i> Settings</a>
    </li>
  </ul>
</div>
