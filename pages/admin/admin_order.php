<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php

require '../../_base.php';
$title='Admin Orders';
$stylesheetArray = ['/css/admin_order.css'];



$scriptArray = ['/js/admin_orders.js'];    

include '../../admin_login_guard.php';
require  "main.php";
//fetch all order from database;
$orders = $_db->query("Select o.*, sum(oi.subtotal) as total from orders o JOIN order_items oi
                        ON (o.orderId = oi.orderId) GROUP BY o.orderId")->fetchAll();
?>


<div class="main-content">

<div class="formwrapper">
    <form class="updateform">
        <span>Order ID</span>
        <button type="button" class="exitButton">X</button>
        <br><br><br>

        <label for="status">Status</label>
        <br>
        <Select name="status" id="status">
            <option value="Pending">Pending</option>
            <option value="In Transit">In Transit</option>
            <option value="Delivered">Delivered</option>
            <option value="Canceled">Canceled</option>
        </Select>

        <br><br><br>
        <label>Tracking ID</label>
        <br>
        <input type="text" placeholder="Example: 1234567">

        <br><br><br>
        <label>Delivered On</label>
        <br>
        <input type="date" >

        <br><br><br>
        <button type="button" id="editSave">Save Changes</button>
    </form>
</div>


<div class="searchBar">
    <input type="search" name="order-search" id="order-search" placeholder="Search for an order">
</div>

    
    <table class="tb">
        <div class="tb-title">
                <h5 style="margin: 0;"><i class="fas fa-table"></i> Orders </h5>
        </div>

        <thead>
            <tr>
                <th class="th order">Order</th>
                <th class="th date">Date</span></th>
                <th class="th cust">Customer</th>
                <th class="th tracking">Tracking ID</th>
                <th class="th delivered">Delivered on</th>
                <th class="th total">Total</span></th>
                <th class="th fulfil">Fulfillment</th>
                <th class="th action">Action</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach($orders as $order): ?>
            <tr id="<?= $order->orderId ?>">
                <!-- rows of records here -->
                <td class="td order">#<?= $order->orderId ?></td>
                <td class="td date"><?= $order->orderDate?></td>
                <td class="td cust"><?= $order->orderName ?></td>
                <td class="td tracking <?= $order->orderId ?>"><?= $order->tracking == 0 ? "Null" : $order->tracking ?></td>
                <td class="td delivered <?= $order->orderId ?>"><?= $order->deliveredDate == null? "Null" : $order->deliveredDate ?></td>
                <td class="td total">RM <?= $order->total ?></td>
                <td class="td stat <?= $order->orderId ?>"><?= $order->status ?></td>
                <td class="td action">
                    <i class="fa-solid fa-pen-to-square update" data-update="<?= $order->orderId ?>"></i>
                    <a href="admin_orderDetails.php?id=<?= $order->orderId ?>"><i class="fas fa-eye" data-view="<?= $order->orderId ?>"></i></a>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
        


    </table>


</div>

<?php
require '../../admin_foot.php';
?>
