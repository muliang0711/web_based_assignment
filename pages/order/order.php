<?php 
    require "../../_base.php";
    $title = 'Order | Page';
    $time = time();
    $stylesheetArray  = ["order.css?"];
    include "../../_head.php";

    
    $orders = [
        (object) [
            "orderId" => "12345",
            "userId" => "12345678911",
            "orderDate" => "2024-10-25",
            "total_price" => "245.00",
            "status" => "Pending",
            "orderAddress" => "2 Jalan Port Dickson Langkawi, 72010, Kuala Lumpur"
        ],
        (object) [
            "orderId" => "12346",
            "userId" => "98765432122",
            "orderDate" => "2024-11-02",
            "total_price" => "99.99",
            "status" => "In Transit",
            "orderAddress" => "88, Lorong Bukit Jaya, 43000, Selangor"
        ],
        (object) [
            "orderId" => "12347",
            "userId" => "56789012333",
            "orderDate" => "2024-09-15",
            "total_price" => "399.50",
            "status" => "Delivered",
            "orderAddress" => "16, Jalan Taman Utama, 80000, Johor Bahru"
        ],
        (object) [
            "orderId" => "12348",
            "userId" => "19283746555",
            "orderDate" => "2024-08-30",
            "total_price" => "150.75",
            "status" => "Pending",
            "orderAddress" => "7, Jalan Ampang, 50450, Kuala Lumpur"
        ],
        (object) [
            "orderId" => "12349",
            "userId" => "67890123444",
            "orderDate" => "2024-12-10",
            "total_price" => "520.00",
            "status" => "In Transit",
            "orderAddress" => "22, Jalan Sutera Indah, 81100, Johor"
        ],
        (object) [
            "orderId" => "12350",
            "userId" => "11223344556",
            "orderDate" => "2024-07-20",
            "total_price" => "75.99",
            "status" => "Delivered",
            "orderAddress" => "5, Lorong Melati, 10460, Penang"
        ],
        (object) [
            "orderId" => "12351",
            "userId" => "99887766554",
            "orderDate" => "2024-06-15",
            "total_price" => "199.90",
            "status" => "Pending",
            "orderAddress" => "33, Jalan SS2, 47300, Petaling Jaya"
        ],
        (object) [
            "orderId" => "12352",
            "userId" => "33445566778",
            "orderDate" => "2024-05-28",
            "total_price" => "349.25",
            "status" => "In Transit",
            "orderAddress" => "11, Taman Bukit Mewah, 56000, Kuala Lumpur"
        ],
        (object) [
            "orderId" => "12353",
            "userId" => "77665544332",
            "orderDate" => "2024-04-05",
            "total_price" => "650.00",
            "status" => "Delivered",
            "orderAddress" => "45, Jalan Raya Timur, 41100, Klang"
        ],
        (object) [
            "orderId" => "12354",
            "userId" => "22334455667",
            "orderDate" => "2024-03-22",
            "total_price" => "129.99",
            "status" => "Pending",
            "orderAddress" => "99, Lorong Seberang Perai, 12345, Penang"
        ]
    ];
    


    $colorStatusBar = "linear-gradient(90deg, rgba(29,204,29,1) 0%, rgba(255,177,0,1) 77%)";
    $colorStatusDefault = "rgba(221, 214, 214, 0.514)";
    $colorStatusDone = "rgb(29, 204, 29)";
    $colorStatusPending = "rgb(255,177,0)";

    $colorArr = [
        //colors for pending
        [$colorStatusDone, $colorStatusBar, $colorStatusPending, $colorStatusDefault, $colorStatusDefault],
        //colors for in transit
        [$colorStatusDone,$colorStatusDone,$colorStatusDone,$colorStatusBar,$colorStatusPending],
        //colors for delivered
        [$colorStatusDone,$colorStatusDone,$colorStatusDone,$colorStatusDone,$colorStatusDone]
    ];
    $index = 0;
?>


<h1>My orders</h1>
<div class="order-header">
        <span>Order ID</span>
        <span>Address</span>
        <span>Ordered Date</span>
        <span>Status</span>
</div>

<div class="orders-container">
    

    <?php foreach($orders as $o): ?>

        <?php 
            if($o->status === "Pending")
                $index = 0;
            else if ($o->status === "In Transit")
                $index = 1;
            else $index = 2;

        ?>
    <div class="order">
        <span class="orderID">#<?=$o->orderId?></span>
        <span class="orderAddress"><?=$o->orderAddress?></span>
        <span class="orderDate"><?=$o->orderDate?></span>
        <span class="orderStatus"><?=$o->status?></span>
        <button class="dropdown">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="m321-80-71-71 329-329-329-329 71-71 400 400L321-80Z"/></svg>
        </button>
    </div>

    <div class="orderDetailed">
            <div class="order-details-wrapper">
                <div class="orderProgress">

                    <div class="order-placed">
                        <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="<?= $colorArr[$index][0] ?>"><path d="M440-183v-274L200-596v274l240 139Zm80 0 240-139v-274L520-457v274Zm-80 92L160-252q-19-11-29.5-29T120-321v-318q0-22 10.5-40t29.5-29l280-161q19-11 40-11t40 11l280 161q19 11 29.5 29t10.5 40v318q0 22-10.5 40T800-252L520-91q-19 11-40 11t-40-11Zm200-528 77-44-237-137-78 45 238 136Zm-160 93 78-45-237-137-78 45 237 137Z"/></svg>
                        <div>Order Placed</div>
                        <div class="progress1" style="background: <?= $colorArr[$index][1] ?>;"></div>
                    </div>
                    <div class="order-intransit">
                        <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="<?= $colorArr[$index][2] ?>"><path d="M280-160q-50 0-85-35t-35-85H60l18-80h113q17-19 40-29.5t49-10.5q26 0 49 10.5t40 29.5h167l84-360H182l4-17q6-28 27.5-45.5T264-800h456l-37 160h117l120 160-40 200h-80q0 50-35 85t-85 35q-50 0-85-35t-35-85H400q0 50-35 85t-85 35Zm357-280h193l4-21-74-99h-95l-28 120Zm-19-273 2-7-84 360 2-7 34-146 46-200ZM20-427l20-80h220l-20 80H20Zm80-146 20-80h260l-20 80H100Zm180 333q17 0 28.5-11.5T320-280q0-17-11.5-28.5T280-320q-17 0-28.5 11.5T240-280q0 17 11.5 28.5T280-240Zm400 0q17 0 28.5-11.5T720-280q0-17-11.5-28.5T680-320q-17 0-28.5 11.5T640-280q0 17 11.5 28.5T680-240Z"/></svg>
                        <div>In Transit</div>
                        <div class="progress2" style="background: <?= $colorArr[$index][3] ?>;"></div>
                    </div>
                    <div class="order-delivered">
                        <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="<?= $colorArr[$index][4] ?>"><path d="M382-240 154-468l57-57 171 171 367-367 57 57-424 424Z"/></svg>
                        <div>Delivered</div>
                    </div>
                </div>

                <div class="order-items-container"></div>

                <div class="order-total-container">
                    <button class="cancel-order">Cancel Order</button>
                    <div class="total-text">Total: RM <?= $o->total_price ?></div>
                </div> 

            </div>
    </div>

    <?php endforeach; ?>
</div>

<?php 
$scriptArray = ["order.js"];
include '../../_foot.php'; 
?>