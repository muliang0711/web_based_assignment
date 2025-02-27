<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Untitled' ?></title>
    <link rel="icon" type="image/svg+xml" href="/assets/img/shuttlecock.svg">
    <link rel="stylesheet" href="/css/app.css" />
    <?= link_stylesheet($stylesheetArray ?? ''); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <header>
        <a href="/" class="logo"><img alt="(Store logo)" /></a>
        <nav>
            <a href="/pages/example/example1.php">(temp) Example 1</a>
            <a href="/pages/example/example2.php">(temp) Example 2</a>
            <a href="/pages/product/productlist.php">Shop</a>
            <a href="/pages/About/about.html">About us</a>
            <a href="/pages/user/user-login.php">Account</a>
        </nav>
    </header>
    <main>