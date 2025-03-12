<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $title ?? 'Untitled' ?></title>
    <link rel="stylesheet" href="/css/admin.css">
    <!-- <link rel="stylesheet" href="/css/flash_msg.css"> -->
    <?= link_stylesheet($stylesheetArray ?? ''); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <!-- Flash message -->
    <div id="info">
        <div id="progress-bar"></div>
        <span id="info-text"><?= temp('info') ?></span>
    </div>

    <div class="side-container">
        <p class="display_topleft adminHeader"><b><i>Admin</i></b></p>
        <a href="/pages/admin/admin_home.php" class="button">Home</a>
        <a href="" class="button">Order</a>
        <a class="button" href="/pages/admin/admin_product.php">Product</a>
        <a class="button" herf="/pages/admin/view_customer.php">Customer</a>
        <a class="button">Discount/Voucher</a>
        <a class="button">Analysis</a>
        <!-- ?php if (is_logged_in()): ?> -->
        <a href="/pages/admin/admin_Management.php" class="button">Admin Management</a>
        <!-- ?php endif ?> -->
        <a class="display_bottomleft">
            <img src="/assets/img/signout.jpg" width="20px">
        </a>
    </div>

    <div class="main">
         <div>
            <header><?= $title ?? 'Untitled' ?></header>
        </div>
        <!-- <div id="container"> -->