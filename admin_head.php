<?php
// topbar.php
include_once __DIR__ . "/_base.php";
$stylesheetArray = ['../css/topbar.css'];
link_stylesheet($stylesheetArray);
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>

</style>

<div class="topbar">
  <h3>Dashboard</h3>
  <div class="topbar-right">
    <!-- User Dropdown -->
    <div class="dropdown">
      <button class="dropdown-toggle" type="button">
        <i class="fas fa-user"></i> Admin
      </button>
      <ul class="dropdown-menu">
        <li>
          <a href="#"><i class="fas fa-user-cog"></i> Profile</a>
        </li>
        <li>
          <a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </li>
      </ul>
    </div>
  </div>
</div>
