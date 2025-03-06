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
        ],
        (object) [
            "orderId" => "12346",
            "userId" => "98765432100",
            "orderDate" => "2024-09-15",
            "total_price" => "150.75",
            "status" => "In Transit",
        ],
        (object) [
            "orderId" => "12347",
            "userId" => "55566778899",
            "orderDate" => "2024-08-05",
            "total_price" => "89.99",
            "status" => "Delivered",
        ],
        (object) [
            "orderId" => "12348",
            "userId" => "11223344556",
            "orderDate" => "2024-07-20",
            "total_price" => "320.50",
            "status" => "Pending",
        ],
        (object) [
            "orderId" => "12349",
            "userId" => "22334455667",
            "orderDate" => "2024-06-10",
            "total_price" => "560.00",
            "status" => "Delivered",
        ],
        (object) [
            "orderId" => "12350",
            "userId" => "99887766554",
            "orderDate" => "2024-05-30",
            "total_price" => "42.25",
            "status" => "In Transit",
        ]
    ];

    foreach($orders as $o){
        echo "<pre>";
        $dates = $o->orderDate;
        $dates_formatted = substr($dates,8,2) . "/" . substr($dates,5,2) . "/" . substr($dates,0,4);
        echo "$dates_formatted <br>";
        echo "</pre>";
    }
?>


<h1>My orders</h1>
<div class="orders-container">
    <div class="order-header">
        <span>Order ID</span>
        <span>Address</span>
        <span>Ordered Date</span>
        <span>Status</span>
    </div>
    
    <div class="order">
        <span class="orderID">#12345</span>
        <span class="orderAddress">PV18 RESIDENCES Kuala  Jalan Langkawi LUMPUR</span>
        <span class="orderDate">27/2/2025</span>
        <span class="orderStatus">Pending</span>
        <button class="dropdown">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="m321-80-71-71 329-329-329-329 71-71 400 400L321-80Z"/></svg>
        </button>
    </div>

    <div class="orderDetailed">
            <div class="order-details-wrapper">
                <div class="orderProgress">

                    <div class="order-placed">
                        <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#e3e3e3"><path d="M440-183v-274L200-596v274l240 139Zm80 0 240-139v-274L520-457v274Zm-80 92L160-252q-19-11-29.5-29T120-321v-318q0-22 10.5-40t29.5-29l280-161q19-11 40-11t40 11l280 161q19 11 29.5 29t10.5 40v318q0 22-10.5 40T800-252L520-91q-19 11-40 11t-40-11Zm200-528 77-44-237-137-78 45 238 136Zm-160 93 78-45-237-137-78 45 237 137Z"/></svg>
                        <div>Order Placed</div>
                        <div class="progress1"></div>
                    </div>
                    <div class="order-intransit">
                        <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#e3e3e3"><path d="M280-160q-50 0-85-35t-35-85H60l18-80h113q17-19 40-29.5t49-10.5q26 0 49 10.5t40 29.5h167l84-360H182l4-17q6-28 27.5-45.5T264-800h456l-37 160h117l120 160-40 200h-80q0 50-35 85t-85 35q-50 0-85-35t-35-85H400q0 50-35 85t-85 35Zm357-280h193l4-21-74-99h-95l-28 120Zm-19-273 2-7-84 360 2-7 34-146 46-200ZM20-427l20-80h220l-20 80H20Zm80-146 20-80h260l-20 80H100Zm180 333q17 0 28.5-11.5T320-280q0-17-11.5-28.5T280-320q-17 0-28.5 11.5T240-280q0 17 11.5 28.5T280-240Zm400 0q17 0 28.5-11.5T720-280q0-17-11.5-28.5T680-320q-17 0-28.5 11.5T640-280q0 17 11.5 28.5T680-240Z"/></svg>
                        <div>In Transit</div>
                        <div class="progress2"></div>
                    </div>
                    <div class="order-delivered">
                        <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#e3e3e3"><path d="M382-240 154-468l57-57 171 171 367-367 57 57-424 424Z"/></svg>
                        <div>Delivered</div>
                    </div>
                </div>

                <div class="order-items-container"></div>

                <div class="order-total-container">
                    <button class="cancel-order">Cancel Order</button>
                    <div class="total-text">Total: RM52.00</div>
                </div>

            </div>
    </div>

    
    <div class="order">
        <span class="orderID">#55125</span>
        <span class="orderAddress">jalan ujong Pasir melaka 707070 malaysia</span>
        <span class="orderDate">12/8/2025</span>
        <span class="orderStatus">Delivered</span>
        <button class="dropdown">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="m321-80-71-71 329-329-329-329 71-71 400 400L321-80Z"/></svg>
        </button>
    </div>
    <div class="orderDetailed"></div>
    
    <div class="order">
        <span class="orderID">#66125</span>
        <span class="orderAddress">PV18 RESIDENCES Kuala  Jalan Langkawi LUMPUR</span>
        <span class="orderDate">27/2/2025</span>
        <span class="orderStatus">In Transit</span>
        <button class="dropdown">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="m321-80-71-71 329-329-329-329 71-71 400 400L321-80Z"/></svg>
        </button>
    </div>
    <div class="orderDetailed"></div>
</div>

<?php 
$scriptArray = ["order.js"];
include '../../_foot.php'; 
?>