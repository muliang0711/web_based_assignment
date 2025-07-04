

<div class="sidebar" id="sidebar">
  <div class="sidebar-header">
    <h4>Dashboard</h4>
    <button class="sidebar-toggle-btn" id="sidebarToggle">
      <i class="fas fa-bars"></i>
    </button>
  </div>
  <ul class="nav-links">
    <li>
      <a href="/pages/admin/admin_home.php"><i class="fas fa-house"></i> Home Page</a>
    </li>
    <li>
      <a href="/pages/admin/view_customer.php"><i class="fas fa-users"></i> Customer</a>
    </li>
    <?php if(admin_is_level(adminLevel:"main")):?>
    <li>
      <a href="/pages/admin/admin_Management.php"><i class="fas fa-users"></i> Admin</a>
    </li>
    <?php endif?>
    <li>
      <a href="/pages/admin/product/admin_product.php"><i class="fas fa-boxes"></i> Products</a>
    </li>
    <li>
      <a href="/pages/admin/admin_order.php"><i class="fas fa-shopping-cart"></i> Orders</a>
    </li>
    <li>
      <a href="/pages/admin/product/adminProductAnlysis.php"><i class="fas fa-chart-line"></i> Reports</a>
    </li>
    <li>
      <a href="/pages/admin/product/stock.php"><i class="fas fa-chart-line"></i> Restock </a>
    </li>
    <li>
      <a href="/pages/admin/issueVoucher.php"><i class="fas fa-gift"></i> Issue Voucher </a>
    </li>
    <li>
      <a href="/pages/admin/admin_chat.php"><i class="fas fa-comments"></i> Chats </a>
    </li>
    <!-- <li>
      <a href="#"><i class="fas fa-cog"></i> Settings</a>
    </li> -->
    
  </ul>
</div>


