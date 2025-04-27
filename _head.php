<?php
require_once __DIR__  . "/_base.php";
/*
if (is_logged_in("user")) {
    global $_db;
    global $_user;
    // Reminder: userID is a NUMBER, therefore does not require single quotes
    $_user = $_db->query("SELECT * FROM user WHERE userID = {$_SESSION['userID']}")->fetch();
}

$userID = $_user->userID;
$statement = $_db->prepare('SELECT * FROM cartitem WHERE userID = ?');
$statement->execute([$userID]);
$cartItemArray = $statement->fetch();
$stock = $cartItemArray->stock;
$cartQuantity = $cartItemArray->quantity;
*/

// if (is_logged_in("user")) {
//     global $_db;
//     global $_user;
//     // Reminder: userID is a NUMBER, therefore does not require single quotes
//     $_user = $_db->query("SELECT * FROM user WHERE userID = {$_SESSION['userID']}")->fetch();
//     $userID = $_user->userID;
// }else{
//     $userID = null;
// }

logout_and_redirect_if_blocked();

if ($_user) {
    $userID = $_user->userID;

    $stm = $_db->prepare('SELECT SUM(quantity) AS total FROM cartitem WHERE userID = ?');
    $stm->execute([$userID]);
    $total = $stm->fetch();
    $totalItem = $total->total;

    $stm = $_db->prepare("Select * from messages where senderID = ? order by sent_at asc");
    $stm->execute([$userID]);
    $messageHistory = $stm->fetchAll();
}


// echo $_SERVER['REQUEST_URI']; // this line was for debugging.
if (is_post()) {
    // Handle logout request
    $logout = post('logout');
    if ($logout) { // If $logout has a truthy value (e.g. non-empty string, non-null values)
        logout('user');
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
    <link rel="stylesheet" href="/css/chat.css" />
    <?php link_stylesheet($stylesheetArray ?? ''); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <header>
        <a href="/" class="logo">
            <div class="top-nav-store-logo">
                The<span>Shuttle</span>Store
                <svg fill="#aaa" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path d="M18.034,1a3.964,3.964,0,0,0-2.975,1.349c-.007-.008-.011-.017-.018-.025A3.984,3.984,0,0,0,12.071,1h-.142a3.984,3.984,0,0,0-2.97,1.324c-.007.008-.011.017-.018.025a3.974,3.974,0,0,0-6.208.3,3.854,3.854,0,0,0-.524,3.52L6.01,17.2a5.993,5.993,0,0,0,11.98,0l3.8-11.031a3.851,3.851,0,0,0-.526-3.514A3.986,3.986,0,0,0,18.034,1ZM10.451,3.657a2.143,2.143,0,0,1,3.1,0,1.868,1.868,0,0,1,.473,1.474L13.1,13.352,12.8,16H11.2l-.3-2.648L9.978,5.131A1.868,1.868,0,0,1,10.451,3.657ZM7.713,16,4.1,5.524a1.87,1.87,0,0,1,.256-1.707,1.976,1.976,0,0,1,3.559.894L9.19,16ZM12,21a4.008,4.008,0,0,1-3.874-3h7.748A4.008,4.008,0,0,1,12,21ZM19.9,5.519,16.287,16H14.81L16.083,4.711a1.976,1.976,0,0,1,3.559-.894A1.869,1.869,0,0,1,19.9,5.519Z"></path>
                    </g>
                </svg>
                <!-- <img src="../../assets/img/shuttlecock.svg" style="height:1em;transform:rotate(45deg);fill:currentColor;" /> -->
            </div>
        </a>
        <!-- <a href="/" class="logo"><img src="/assets/img/logo.jpg" class="top-nav-store-logo" alt="(Store logo)" /></a> -->
        <button class="hamburger" aria-label="Toggle Menu">☰</button>
        <nav>
            <!-- <a href="/pages/template/template.php">(dev only) Template page</a> -->
            <a href="/">Home</a>
            <a href="/pages/product/productlist.php">Shop</a>
            <a href="/pages/About/about.php">About us</a>
            <!-- <a href="/contact.php">Contact</a> -->

            <?php if (is_logged_in("user")): ?>

                <div class="cart-btn">
                    <a href="/pages/product/cartPage.php" ?>
                        <img src="/assets/img/icon-cart.png" alt="Cart" title="Cart" />
                        <div class="itemCount"><?php echo $totalItem ?></div>
                    </a>
                </div>

                <div class="account dropdown">
                    <div class="dropdown-label with-dropdown-icon">
                        <img class="account-icon" src="<?= $_user->profilePic ? "/File/user-profile-pics/{$_user->profilePic}" : '/assets/img/profile-default-icon-dark.svg' ?>" alt="Account" title="Account" />
                    </div>
                    <div class="dropdown-content">
                        <div class="dropdown-header">
                            <img class="profile-pic" src="<?= $_user->profilePic ? "/File/user-profile-pics/{$_user->profilePic}" : '/assets/img/profile-default-icon-dark.svg' ?>" alt="Account" title="Account" />
                            <div class="username"><?= $_user->username ?></div>
                        </div>
                        <div class="dropdown-main">
                            <a class="dropdown-item" href="/pages/user/settings/profile.php">
                                <span><img src="/assets/img/icon-profile.svg" /></span>
                                <div>Settings</div>
                            </a>
                            <a class="dropdown-item" href="/pages/order/order.php">
                                <span>
                                    <svg style="vertical-align:text-bottom;transform:scale(1.15);transform-origin:center;" width="20px" height="20px" viewBox="-2 0 26 24" fill="black" stroke="white" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="2" y="5" width="14" height="17" rx="2" fill="none" />
                                        <path d="M6 9.5H12" stroke-linecap="round" />
                                        <path d="M6 13.5H12" stroke-linecap="round" />
                                        <path d="M6 17.5H10" stroke-linecap="round" />
                                        <circle cx="16" cy="8" r="8" stroke="black" />
                                        <circle cx="16" cy="8" r="6" />
                                        <line x1="16" y1="8" x2="16" y2="5" stroke-linecap="round" />
                                        <line x1="16" y1="8" x2="18" y2="10" stroke-linecap="round" />
                                    </svg>
                                </span>
                                <div>Order history</div>
                            </a>
                            <a class="dropdown-item" href="/logout.php">
                                <span><img src="/assets/img/icon-signout.svg" /></span>
                                <div>Log out</div>
                            </a>
                        </div>
                    </div>
                </div>
                <!--
                <div class="cart-popup">
                    <div class="content">
                        <span class="close-popup">&times;</span>
                        <h2>Shopping Cart</h2>
                                    -->
                <?php
                $userID = $_user->userID;
                $statement = $_db->prepare('SELECT * FROM cartitem JOIN product USING (productID) WHERE userID = ?');
                $statement->execute([$userID]);
                $cartItemArray = $statement->fetchAll();
                ?>
                <?php /*if ($cartItemArray): ?>
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
                </div> */ ?>

            <?php else: ?>

                <a href="/pages/user/user-login.php?fromPage=<?= $_SERVER['REQUEST_URI'] ?>">Log in</a>
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

        <div class="info-container error-toast">
            <div class="progress-bar"></div>
            <span class="info-text"><?= temp('error') ?></span>
        </div>

        <div class="info-container warn">
            <div class="progress-bar"></div>
            <span class="info-text"><?= temp('warn') ?></span>
        </div>

        <?php
        if (is_logged_in('user')) {
            echo '
                <div class="supportButton">
                    <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="rgb(0,0,0)"><path d="M440-120v-80h320v-284q0-117-81.5-198.5T480-764q-117 0-198.5 81.5T200-484v244h-40q-33 0-56.5-23.5T80-320v-80q0-21 10.5-39.5T120-469l3-53q8-68 39.5-126t79-101q47.5-43 109-67T480-840q68 0 129 24t109 66.5Q766-707 797-649t40 126l3 52q19 9 29.5 27t10.5 38v92q0 20-10.5 38T840-249v49q0 33-23.5 56.5T760-120H440Zm-80-280q-17 0-28.5-11.5T320-440q0-17 11.5-28.5T360-480q17 0 28.5 11.5T400-440q0 17-11.5 28.5T360-400Zm240 0q-17 0-28.5-11.5T560-440q0-17 11.5-28.5T600-480q17 0 28.5 11.5T640-440q0 17-11.5 28.5T600-400Zm-359-62q-7-106 64-182t177-76q89 0 156.5 56.5T720-519q-91-1-167.5-49T435-698q-16 80-67.5 142.5T241-462Z"/></svg>
                </div>

                <div class="chatContainer">
                    <div class="chatBody">
                        <div class="admin">
                            Hello, How may I assist you today? 😃
                        </div>
                    ';
            foreach ($messageHistory as $m) {
                if ($m->userSent == "1") {
                    echo "<div class='user'>
                            $m->content
                        </div>";
                } else {
                    echo "<div class='admin'>
                            $m->content
                        </div>";
                }
            }
            echo '
                </div>
                    <div class="chatInput">
                        <textarea id="textarealol" type="text" maxlength="200" placeholder="Enter a message"></textarea>
                        <button type="button" id="emojiBtn"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="rgb(54, 54, 54)"><path d="M620-520q25 0 42.5-17.5T680-580q0-25-17.5-42.5T620-640q-25 0-42.5 17.5T560-580q0 25 17.5 42.5T620-520Zm-280 0q25 0 42.5-17.5T400-580q0-25-17.5-42.5T340-640q-25 0-42.5 17.5T280-580q0 25 17.5 42.5T340-520Zm140 260q68 0 123.5-38.5T684-400H276q25 63 80.5 101.5T480-260Zm0 180q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-400Zm0 320q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Z"/></svg></button>
                        <div id="emojiPicker" class="emoji-picker">
                        <span>😁</span> <span>😂</span> <span>🤣</span> <span>😍</span> <span>🥰</span> <span>😎</span> <span>🤔</span> <span>😢</span> <span>🙌</span> <span>🎉</span>
                        </div>
                        <button class="send"><svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="rgb(78, 118, 250)"><path d="M120-160v-640l760 320-760 320Zm80-120 474-200-474-200v140l240 60-240 60v140Zm0 0v-400 400Z"/></svg></button>
                    </div>
                </div>
            ';
        }
        ?>