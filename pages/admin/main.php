<?php
// include __DIR__ . '/../../admin_login_guard.php';
?> 

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?? 'Untitled' ?></title>
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
  <link rel="stylesheet" href="/css/main.css">
  <link rel="stylesheet" href="/css/topbar.css">
  <link rel="stylesheet" href="/css/sidebar.css">
  <link rel="stylesheet" href="/css/admin.css">


  <?php link_stylesheet($stylesheetArray ?? ''); ?>
  
</head>
<body>
      <!-- Flash message -->
      <div id="info">
        <div id="progress-bar"></div>
        <span id="info-text"><?= temp('info') ?></span>
    </div>

  <!-- Include Topbar -->
  <?php include __DIR__ . "/../../admin_topbar.php"; ?>

  <!-- Include Sidebar -->
  <?php include __DIR__ . '/../../admin_sidebar.php'; ?>
