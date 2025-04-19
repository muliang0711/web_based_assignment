<?php
$stylesheetArray = ['product.css', 'cartTable.css'];
$title = 'Product List';
require '../../_base.php';
include '../../_login_guard.php';



// remove item from cart
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

// Handle minus/add/delete operations on the cart
    if (is_post()) {
        $actionGroup = post('actionGroup');
        $action = post('action');

    if (isset($actionGroup) && $actionGroup == 'cart') {

        $productID = post('productID');
        $sizeID = post('sizeID');
        $userID = $_user->userID;

        // Decrement the quantity
        if ($action === 'minus') {
            $selectStmt = $_db->prepare('SELECT quantity FROM cartitem WHERE productID = :productID AND sizeID = :sizeID AND userID = :userID');
            $selectStmt->execute([
                'productID' => $productID,
                'sizeID' => $sizeID,
                'userID' => $userID,
            ]);
            $oldQuantity = $selectStmt->fetchColumn();
        
            // if the quantity is minus to 0
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
            
            $quantityStm = $_db->prepare('SELECT quantity FROM cartitem WHERE productID = :productID AND sizeID = :sizeID AND userID = :userID');
            $quantityStm->execute(['productID' => $productID, 'sizeID' => $sizeID, 'userID' => $userID]);
            $qstm = $quantityStm->fetch();
            $cartQuantity = $qstm->quantity;

            $stockStm = $_db->prepare('SELECT stock FROM productstock WHERE productID = :productID AND sizeID = :sizeID');
            $stockStm->execute(['productID' => $productID, 'sizeID' => $sizeID]);
            $sstm = $stockStm->fetch();
            $stock = $sstm->stock;

            if ($cartQuantity < $stock) {
            $updateStmt = $_db->prepare('UPDATE cartitem SET quantity = quantity + 1 WHERE productID = :productID AND sizeID = :sizeID AND userID = :userID');
            $updateStmt->execute([
                'productID' => $productID,
                'sizeID' => $sizeID,
                'userID' => $userID,
                
            ]);
        }else{
            temp("error", "Stock unvailable! / Over limit!");
        }

        /*      temp("info", "Added to cart Successfully!");
          redirect("../product/productDetail.php?racket=$productObj->productID");
        } else {
          temp("error", "Stock unvailable! / Over limit!");
          redirect("../product/productDetail.php?racket=$productObject->productID");
        }*/

        } else if ($action === 'delete') {
            removeFromCart($productID, $sizeID, $userID);
        }

        // Reload cart page after updating cart
        redirect();
    }
    }


include '../../_head.php';
?>

<?php

// if (is_logged_in("user")) {
//     global $_db;
//     global $_user;
//     // Reminder: userID is a NUMBER, therefore does not require single quotes
//     $_user = $_db->query("SELECT * FROM user WHERE userID = {$_SESSION['userID']}")->fetch();
// }
// // Note from lh: This if block has logic error!
// if(!$userID){
//     // redirect("http://localhost:8000/pages/user/user-login.php");
// }




?>

<?php
                        // Cart output
                        $userID = $_user->userID;
                        $statement = $_db->prepare('SELECT * FROM cartitem JOIN product USING (productID) WHERE userID = ?');
                        $statement->execute([$userID]);
                        $cartItemArray = $statement->fetchAll();
                        $stm = $_db->prepare('SELECT SUM(quantity) AS total FROM cartitem WHERE userID = ?');
                        $stm->execute([$userID]);
                        $total = $stm->fetch();
                        $totalItem = $total->total;
                        $stmm = $_db->prepare('SELECT SUM(product.price * cartitem.quantity) AS amount 
                                               FROM cartitem 
                                               JOIN product ON cartitem.productID = product.productID 
                                               WHERE cartitem.userID = ?');
                        $stmm->execute([$userID]);
                        $price = $stmm->fetch();
                        $totalAmount = $price->amount;
                        ?>
                        
                        <?php if ($cartItemArray): ?>
                            <?php $status = 0 ?>
                            <div class="tableHead">
                            <table>
                                <tr>
                                    <th>Racket Name</th>
                                    <th>Grip Size</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                </tr>
                                <?php foreach ($cartItemArray as $cartObject): ?>
                                    <?php $price = $cartObject->price * $cartObject->quantity ?>
                                    <tr>
                                        <td> <?php echo $cartObject->productName ?> </td>
                                        <td> <?php echo $cartObject->sizeID ?> </td>
                                        <td> <?php echo $cartObject->quantity ?> </td>
                                        <td>RM <?php echo $price ?>.00</td>
                                        <!-- Minus button -->
                                        <td>
                                            <form method="POST">
                                                <input type="hidden" name="actionGroup" value="cart"/> 
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
                                                <input type="hidden" name="actionGroup" value="cart"/> 
                                                <input type="hidden" name="action" value="add"/> 
                                                <input type="hidden" name="productID" value="<?= $cartObject->productID ?>" />
                                                <input type="hidden" name="sizeID" value="<?= $cartObject->sizeID ?>" />
                                                <button class="add-btn" type="submit"><strong>+</strong></button>
                                            </form>
                                        </td>
                                        <!-- Delete button -->
                                        <td>
                                            <form method="POST">
                                                <input type="hidden" name="actionGroup" value="cart"/> 
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
                                                </div>
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

                            <?php 
                            $overproduct = null;
                            foreach($cartItemArray as $cart){
                                $product = $cart -> productID;
                                $size = $cart -> sizeID;
                                $quantity =  $cart -> quantity;
                                $stockStatement = $_db->prepare('SELECT stock FROM productstock WHERE productID = ? AND sizeID = ?');
                                $stockStatement->execute([$product, $size]);
                                $current = $stockStatement->fetch();
                                $currentStock = $current->stock;
                                if( $cart -> quantity > $currentStock){
                                    $overproduct = $cartObject->productName;
                                }
                            }
                            ?>
                            <?php if(!$overproduct): ?>
                            <a onclick="onclick()" class="paymentBtn">
                            <button onclick="location='/pages/checkout/checkout.php?' ">Proceed to Payment </button>
                            </a>
                            <?php else: ?>
                             <div class="errorButton">
                             <p><?php echo $overproduct ?> is out of current stock limit. Please decrease the quantity from the cart to procced to payment. Thank you.</p>
                             </div>       
                            <?php endif ?>
                            <div class = "sum" ><p>Total Item(s): <?php echo $totalItem?></p>
                            <p>Total Amount: RM <?php echo $totalAmount ?> .00</p></div>
                        <?php else: ?>

                            <p>Your cart is empty.</p>

                        <?php endif ?>
<?php
include '../../_foot.php';