<?php
// main.php
include_once __DIR__ . "/../../_base.php";
$stylesheetArray = ['../../css/main.css' , '../../css/sidebar.css' , '../../css/topbar.css'];
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?? 'Untitled' ?></title>
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <?php link_stylesheet($stylesheetArray ?? ''); ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>

  <!-- Include Topbar -->
  <?php include __DIR__ .'/../../admin_topbar.php'; ?>

  <!-- Include Sidebar -->
  <?php include __DIR__ . '/../../admin_sidebar.php'; ?>


