<?php
if (is_post()) {
    $logout = post('logout');
    if ($logout) { // If $logout has a truthy value (e.g. non-empty string, non-null values)
        logout();
        header('Location: /');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Untitled' ?></title>
    <link rel="icon" type="image/svg+xml" href="/assets/img/shuttlecock.svg">
    <link rel="stylesheet" href="/css/app.css" />
    <?php link_stylesheet($stylesheetArray ?? ''); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <header>
        <a href="/" class="logo"><img src="/assets/img/logo.jpg" class="top-nav-store-logo" alt="(Store logo)" /></a>
        <nav>
            <a href="/pages/template/template.php">(dev only) Template page</a>
            <a href="/">Home</a>
            <a href="/pages/product/productlist.php">Shop</a>
            <a href="/pages/About/about.html">About us</a>

            <?php if (is_logged_in()): ?>

                <div class="cart-btn">
                    <img src="/assets/img/icon-cart.png" alt="Cart" title="Cart" />
                </div>

                <div class="account dropdown">
                    <div class="dropdown-label">
                        <img class="account-icon" src="/assets/img/profile-default-icon-dark.svg" alt="Account" title="Account" />
                    </div>
                    <div class="dropdown-content">
                        <div class="dropdown-header">
                            <img class="profile-pic" src="/assets/img/profile-default-icon-dark.svg" alt="Account" title="Account" />
                            <div class="username"><?= $_user->username ?></div>
                        </div>
                        <div class="dropdown-main">
                            <a class="dropdown-item" href="/pages/user/profile.php">
                                <span><img src="/assets/img/icon-profile.svg" /></span>
                                <div>Profile</div>
                            </a>
                            <a class="dropdown-item" href="/logout.php">
                                <span><img src="/assets/img/icon-signout.svg" /></span>
                                <div>Log out</div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="cart-popup">
                    <div class="content">
                        <span class="close-popup">&times;</span>
                        <h2>Shopping Cart</h2>

                        <?php
                        $userID = $_user->userID;
                        $statement = $_db->prepare('SELECT * FROM cartitem JOIN product USING (productID) WHERE userID = ?');
                        $statement->execute([$userID]);
                        $cartItem = $statement->fetchAll();
                        ?>
                        <?php if ($cartItem): ?>


                            <table>
                                <tr>
                                    <th>Racket Name</th>
                                    <th>Grip Size</th>
                                    <th>Quantity</th>
                                </tr>
                                <?php foreach ($cartItem as $cartObject): ?>
                                    <tr>
                                        <td> <?php echo $cartObject->productName ?> </td>
                                        <td> <?php echo $cartObject->sizeID ?> </td>
                                        <td> <?php echo $cartObject->quantity ?> </td>
                                        <td><a onclick="onclick()" class="minusBtn"><button><strong>-</strong></button></a></td>
                                    </tr>
                                <?php endforeach ?>
                            </table>


                        <?php else: ?>

                            <p>Your cart is empty.</p>

                        <?php endif ?>
                    </div>
                </div>

            <?php else: ?>

                <a href="/pages/user/user-login.php">Log in</a>
                <a class="signup" href="/pages/user/user-signup.php">Sign up</a>

            <?php endif ?>
        </nav>
    </header>
    <main>