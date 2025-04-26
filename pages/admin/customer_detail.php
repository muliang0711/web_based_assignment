<?php
require '../../_base.php';

$title = 'View Customer';
$stylesheetArray = ['/css/admin_customer_detail.css','/css/admin_customer.css', '/css/zoomable-img.css'];
$scriptArray = ['/js/app.js', '/js/admin.js', '/js/zoomable-img.js'];

require_once  "../admin/main.php";
include '../../admin_login_guard.php';
?>

<?php
// 获取 userID
$userId = req('userID');
if (!$userId) {
    temp('info', 'No userID selected!');
    redirect('/pages/admin/view_customer.php');
}

// 处理排序方式
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'ASC'; // 默认为升序，可改为 DESC

// 获取用户信息
$stm = $_db->prepare('SELECT * FROM user WHERE userID = ?');
$stm->execute([$userId]);
$s = $stm->fetch(PDO::FETCH_OBJ);

// 获取订单信息
$ordersStmt = $_db->prepare("SELECT o.*, SUM(oi.subtotal) AS total_price 
FROM orders o 
JOIN order_items oi ON (o.orderId = oi.orderId) 
WHERE o.userId = ? 
GROUP BY o.orderId 
ORDER BY o.orderDate $sort;");
$ordersStmt->execute([$userId]);
$orders = $ordersStmt->fetchAll(PDO::FETCH_OBJ);

// 获取订单商品信息
$order_itemsStmt = $_db->prepare("SELECT oi.*, p.productName 
FROM order_items oi 
JOIN product p ON (oi.productId = p.productID) 
JOIN orders o ON (oi.orderId = o.orderId)
WHERE o.userId = ?");
$order_itemsStmt->execute([$userId]);
$order_items = $order_itemsStmt->fetchAll(PDO::FETCH_OBJ);


if (!isset($order_items) || !is_array($order_items)) {
    $order_items = [];
}
?>

<!-- Modal Zoom Viewer -->
<div id="imageModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="zoomedImage">
</div>

<div class="main-content" style="  margin-left: var(--sidebar-width);
  margin-top: 50px;
  padding: 1rem;">
  <div class="whole">
<button data-get="view_customer.php" class="searchBar back">Back</button>

    <table class="customer_container customer_detail">
        <tr>
            <th>Picture</th>
            <td><img class="profile-image zoomable-img" src="/File/user-profile-pics/<?= htmlspecialchars($s->profilePic) ?>"/></td>
        </tr>
        <tr>
            <th>User Id</th>
            <td><?= htmlspecialchars($s->userID) ?></td>
        </tr>
        <tr>
            <th>Customer Name</th>
            <td><?= htmlspecialchars($s->username) ?></td>
        </tr>
        <tr>
            <th>Address</th>
            <td><?= htmlspecialchars($s->address) ?></td>
        </tr>
        <tr>
            <th>Birthdate</th>
            <td><?= htmlspecialchars($s->birthdate) ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= htmlspecialchars($s->email) ?></td>
        </tr>
        <tr>
            <th>Contact Number</th>
            <td><?= htmlspecialchars($s->phoneNo) ?></td>
        </tr>
        <tr>
            <th>Gender</th>
            <td><?= htmlspecialchars($s->gender) ?></td>
        </tr>
        <tr>
            <th>Member Status</th>
            <td><?= htmlspecialchars($s->memberStatus) ?></td>
        </tr>
    </table>

    <br>

    <div class="purchase_container">
        <h1>Purchase history</h1>
        <div class="order-header">
            <span>Order ID</span>
            <span>Address</span>
            <span>Ordered Date</span>
            <span>Status</span>
            <span>Total</span>
        </div>

        <div class="orders-container">
            <?php foreach ($orders as $o): ?>
                <div class="order">
                    <span class="orderID"><?= htmlspecialchars($o->orderId) ?></span>
                    <span class="orderAddress"><?= htmlspecialchars($o->orderAddress) ?></span>
                    <span class="orderDate"><?= date("d/m/Y", strtotime($o->orderDate)) ?></span>
                    <span class="orderStatus"><?= htmlspecialchars($o->status) ?></span>
                    <span class="total-text"><?= htmlspecialchars($o->total_price) ?></span>
                    <button class="dropdown">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                            <path d="m321-80-71-71 329-329-329-329 71-71 400 400L321-80Z"/>
                        </svg>
                    </button>
                </div>

                <div class="orderDetailed">
                    <div class="order-details-wrapper">
                        <div class="order-items-container">
                            <?php foreach ($order_items as $oi): ?>
                                <?php if ($o->orderId === $oi->orderId): ?>
                                    <div class='items-container'>
                                        <span class="item-name"><?= htmlspecialchars($oi->productName) ?></span>
                                        <span class="item-series"><?= htmlspecialchars($oi->gripSize) ?></span>
                                        <span class="item-quantity">x <?= htmlspecialchars($oi->quantity) ?></span>
                                        <span class="item-subtotal">RM <?= htmlspecialchars($oi->subtotal) ?></span>
                                    </div>
                                <?php endif ?>
                            <?php endforeach ?>
                        </div>
                        
                    </div>                  
                </div>


            <?php endforeach; ?>
        </div>
    </div>
 </div>
<?php
require '../../admin_foot.php';
?>
