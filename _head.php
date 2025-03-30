<?php
require_once __DIR__  . "/_base.php";
if (is_logged_in("user")) {
    global $_db;
    global $_user;
    // Reminder: userID is a NUMBER, therefore does not require single quotes
    $_user = $_db->query("SELECT * FROM user WHERE userID = {$_SESSION['userID']}")->fetch();
}

$userID = $_user->userID;
$statement = $_db->prepare('SELECT * FROM cartitem JOIN productStock USING (productID) WHERE userID = ?');
$statement->execute([$userID]);
$cartItemArray = $statement->fetch();
$stock = $cartItemArray->stock;
$cartQuantity = $cartItemArray->quantity;


// echo $_SERVER['REQUEST_URI']; // this line was for debugging.
if (is_post()) {
    // Handle logout request
    $logout = post('logout');
    if ($logout) { // If $logout has a truthy value (e.g. non-empty string, non-null values)
        logout();
        header('Location: /');
    }

    // Handle minus/delete operations on the cart
    $action = post('action');

    if ($action) {
        $productID = post('productID');
        $sizeID = post('sizeID');
        $userID = $_user->userID;
    }

    if ($action === 'minus') {
        $selectStmt = $_db->prepare('SELECT quantity FROM cartitem WHERE productID = :productID AND sizeID = :sizeID AND userID = :userID');
        $selectStmt->execute([
            'productID' => $productID,
            'sizeID' => $sizeID,
            'userID' => $userID,
        ]);
        $oldQuantity = $selectStmt->fetchColumn();

        if ($oldQuantity === 1) {
            removeFromCart($productID, $sizeID, $userID);
        } else {
            $updateStmt = $_db->prepare('UPDATE cartitem SET quantity = quantity - 1 WHERE productID = :productID AND sizeID = :sizeID AND userID = :userID');
            $updateStmt->execute([
                'productID' => $productID,
                'sizeID' => $sizeID,
                'userID' => $userID,
            ]);
        }
        // $updateStmt = $_db->prepare('UPDATE cartitem SET ')
    } else if ($action === 'add') {
        if ($stock > $cartQuantity) {
        $updateStmt = $_db->prepare('UPDATE cartitem SET quantity = quantity + 1 WHERE productID = :productID AND sizeID = :sizeID AND userID = :userID');
        $updateStmt->execute([
            'productID' => $productID,
            'sizeID' => $sizeID,
            'userID' => $userID,
        ]);
        temp("info", "Added to cart Successfully!");
      redirect("../product/productDetail.php?racket=$productObj->productID");
    } else {
      temp("error", "Stock unvailable! / Over limit!");
      redirect("../product/productDetail.php?racket=$productObject->productID");
    }
    } else if ($action === 'delete') {
        removeFromCart($productID, $sizeID, $userID);
    }
    redirect("../product/cartPage.php");
}

function removeFromCart($productID, $sizeID, $userID): void {
    global $_db;
    $deleteStmt = $_db->prepare('DELETE FROM cartitem WHERE productID = :productID AND sizeID = :sizeID AND userID = :userID');
    $deleteStmt->execute([
        'productID' => $productID,
        'sizeID' => $sizeID,
        'userID' => $userID,
    ]);

    if ($deleteStmt->rowCount() > 0) {
        temp('info', "Successfully removed item from cart.");
    } else {
        temp('error', "Failed to remove item from cart.");
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

            <?php if (is_logged_in("user")): ?>

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
                            <a class="dropdown-item" href="/pages/order/order.php">
                                <span>
                                    <svg style="vertical-align:text-bottom;transform:scale(1.15);transform-origin:center;" width="20px" height="20px" viewBox="-2 0 26 24" fill="black" stroke="white" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="2" y="5" width="14" height="17" rx="2" fill="none" />
                                        <path d="M6 9.5H12" stroke-linecap="round"/>
                                        <path d="M6 13.5H12" stroke-linecap="round"/>
                                        <path d="M6 17.5H10" stroke-linecap="round"/>
                                        <circle cx="16" cy="8" r="8" stroke="black"/>
                                        <circle cx="16" cy="8" r="6"/>
                                        <line x1="16" y1="8" x2="16" y2="5" stroke-linecap="round"/>
                                        <line x1="16" y1="8" x2="18" y2="10" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                <div>Order history</div>
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
                        $cartItemArray = $statement->fetchAll();
                        ?>
                        <?php if ($cartItemArray): ?>
                            <?php $status = 0 ?>

                            <table>
                                <tr>
                                    <th>Racket Name</th>
                                    <th>Grip Size</th>
                                    <th>Quantity</th>
                                </tr>
                                <?php foreach ($cartItemArray as $cartObject): ?>
                                    <tr>
                                        <td> <?php echo $cartObject->productName ?> </td>
                                        <td> <?php echo $cartObject->sizeID ?> </td>
                                        <td> <?php echo $cartObject->quantity ?> </td>
                                        <!-- Minus button -->
                                        <td>
                                            <form method="POST">
                                                <input type="hidden" name="action" value="minus"/> 
                                                <input type="hidden" name="productID" value="<?= $cartObject->productID ?>" />
                                                <input type="hidden" name="sizeID" value="<?= $cartObject->sizeID ?>" />
                                                <?php if ($cartObject->quantity === 1): ?>
                                                    <button class="minus-btn" type="submit" data-confirm="This will remove <?= $cartObject->productName ?> (<?= $cartObject->sizeID ?>) from your cart. Proceed?"><strong>-</strong></button>
                                                <?php else: ?>
                                                    <button class="minus-btn" type="submit"><strong>&ndash;</strong></button>
                                                <?php endif ?>
                                            </form>
                                        </td>
                                        <!-- Add button -->
                                        <td>
                                            <form method="POST">
                                                <input type="hidden" name="action" value="add"/> 
                                                <input type="hidden" name="productID" value="<?= $cartObject->productID ?>" />
                                                <input type="hidden" name="sizeID" value="<?= $cartObject->sizeID ?>" />
                                                <button class="add-btn" type="submit"><strong>+</strong></button>
                                            </form>
                                        </td>
                                        <!-- Delete button -->
                                        <td>
                                            <form method="POST">
                                                <input type="hidden" name="action" value="delete" />
                                                <input type="hidden" name="productID" value="<?= $cartObject->productID ?>" />
                                                <input type="hidden" name="sizeID" value="<?= $cartObject->sizeID ?>" />
                                                <button class="delete-btn" 
                                                        data-confirm="Remove <?= $cartObject->productName ?> (<?= $cartObject->sizeID ?>) from your cart?"
                                                >
                                                    <strong>&times;</strong>
                                                </button>
                                            </form>
                                        </td>
                                        <!-- <td><a onclick="onclick()" class="deleteBtn"><button><strong>X</strong></button></a></td> -->
                                    </tr>
                                <?php endforeach ?>
                            </table>
                            <?php 
                                // $action = $_POST['action'];
                                // if($action === 'minus'){
                                //     $quantity = $cartItem->quantity;
                                //     $quantity -= 1;
                                //     $statement = $_db->prepare('UPDATE cartitem SET quantity WHERE userID = ? AND productID = ? AND sizeID = ?');
                                //     $statement->execute([$quantity, $userID, $productID, $sizeID]);
                                //     $cartItem = $statement->fetchAll();
                                // }
                            ?>

                            <a onclick="onclick()" class="paymentBtn">
                            <button>Proceed to Payment </button>
                            </a>
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
        <!-- Flash messages -->
        <div class="info-container success">
            <div class="progress-bar"></div>
            <span class="info-text"><?= temp('info') ?></span>
        </div>
        
        <div class="info-container error">
            <div class="progress-bar"></div>
            <span class="info-text"><?= temp('error') ?></span>
        </div>

        <div class="info-container warn">
            <div class="progress-bar"></div>
            <span class="info-text"><?= temp('warn') ?></span>
        </div>