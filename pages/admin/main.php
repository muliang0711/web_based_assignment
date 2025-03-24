<?php
// main.php
include_once __DIR__ . "/../../_base.php";
$stylesheetArray = ['../../css/main.css' , '../../css/sidebar.css' , '../../css/topbar.css'];
link_stylesheet($stylesheetArray);
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel </title>
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>

  <!-- Include Topbar -->
  <?php include __DIR__ .'/../../admin_topbar.php'; ?>

  <!-- Include Sidebar -->
  <?php include __DIR__ . '/../../admin_sidebar.php'; ?>


</body>
</html>
