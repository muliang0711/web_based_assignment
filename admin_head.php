<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $title ?? 'Untitled' ?></title>
    <link rel="stylesheet" href="/css/admin.css">
    <?= link_stylesheet($stylesheetArray ?? ''); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <div class="side-container">
        <p class="display_topleft adminHeader"><b><i>Admin</i></b></p>
        <a href="/pages/admin/admin_home.php" class="button">Home</a>
        <a href="/pages/product/productlist.php" class="button">Order</a>
        <a class="button">Product</a>
        <a class="button">Customer</a>
        <a class="button">Discount/Voucher</a>
        <a class="button">Analysis</a>
        <a class="display_bottomleft">
            <img src="/assets/img/signout.jpg" width="20px">
        </a>
    </div>

    <div class="main">
         <div>
            <header><?= $title ?? 'Untitled' ?></header>
        </div>
        <!-- <div id="container"> -->