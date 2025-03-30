<?php
$stylesheetArray = ['product.css', 'cartTable.css'];
$title = 'Product List';
require '../../_base.php';
include '../../_head.php';
?>

<?php

if (is_logged_in("user")) {
    global $_db;
    global $_user;
    // Reminder: userID is a NUMBER, therefore does not require single quotes
    $_user = $_db->query("SELECT * FROM user WHERE userID = {$_SESSION['userID']}")->fetch();
}
if(!$userID){
    redirect("http://localhost:8000/pages/user/user-login.php");
}


?>

<?php


                        $userID = $_user->userID;
                        $statement = $_db->prepare('SELECT * FROM cartitem JOIN product USING (productID) WHERE userID = ?');
                        $statement->execute([$userID]);
                        $cartItemArray = $statement->fetchAll();
                        $stm = $_db->prepare('SELECT COUNT(quantity) AS total FROM cartitem WHERE userID = ?');
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

                            <a onclick="onclick()" class="paymentBtn">
                            <button>Proceed to Payment </button>
                            </a>
                            
                            <div class = "sum" ><p>Total Item(s): <?php echo $totalItem?></p>
                            <p>Total Amount: RM <?php echo $totalAmount ?> .00</p></div>
                        <?php else: ?>

                            <p>Your cart is empty.</p>

                        <?php endif ?>
<?php
include '../../_foot.php';