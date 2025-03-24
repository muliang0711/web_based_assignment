<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php
require '../../_base.php';
require  "main.php";
$title='Admin Orders';
$stylesheetArray = ['/css/admin_order.css'];   // 注意：这边只放特定于此页面的 .css file(s)。所有 admin 页面都会用到的 .css files 应放在 /css/admin.css

$scriptArray = ['/js/admin_orders.js'];       // 注意：这边只放特定于此页面的 .js file(s)。所有 admin 页面都会用到的 .js files 应放在 /js/admin.js


?>


<div class="main-content">
<div class="searchBar"></div>
    <table class="tb">
        <div class="tb-title">
                <h5 style="margin: 0;"><i class="fas fa-table"></i> Orders </h5>
        </div>
        <tr>
            <th class="th order"><i class="checkbox far fa-square" aria-hidden="true" style="cursor:pointer; margin-right:5px;"></i>Order</th>
            <th class="th date">Date<span class="fas fa-sort" style="margin-left:5px; cursor:pointer;"></span></th>
            <th class="th cust">Customer</th>
            <th class="th payment">Payment</th>
            <th class="th total">Total</th>
            <th class="th fulfil">Fulfillment</th>
            <th class="th action">Action</th>
        </tr>
        </thead>

    </table>


</div>

<?php
require '../../admin_foot.php';
?>
