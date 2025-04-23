<?php
    require $_SERVER["DOCUMENT_ROOT"] . "/_base.php";

    if(is_post() && isset($_POST["search"])){

        $keyword = $_POST["search"];
        $like = "%" . $keyword . "%";

        if(str_starts_with($keyword, "#")){
            $sql = "
                        SELECT o.*, sum(oi.subtotal) as total 
                        FROM orders o JOIN order_items oi
                        ON (o.orderId = oi.orderId) 
                        GROUP BY o.orderId
                        HAVING o.orderId = ?";
            $stm = $_db->prepare($sql);
            $stm->execute([substr($keyword, 1)]);
            $orders = $stm->fetchAll();
        }
        else{
            $sql = "
                        SELECT o.*, sum(oi.subtotal) as total 
                        FROM orders o JOIN order_items oi
                        ON (o.orderId = oi.orderId) 
                        GROUP BY o.orderId
                        HAVING o.orderId LIKE ? or o.orderName LIKE ? or o.orderDate LIKE ? or o.status LIKE ?";
            $stm = $_db->prepare($sql);
            $stm->execute([$like,$like,$like,$like]);
            $orders = $stm->fetchAll();
        }

        
    }

    else{
        exit;
    }
?>

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
                </td>
            </tr>
<?php endforeach ?>