<?php 
    require "../../_base.php";
    $title = "Cancel Order";
    $stylesheetArray  = ["orderCancel.css?"];
    include '../../_login_guard.php';
    extract((array)$_user);
   
    $userId = $_user->userID;
    $reasons = [
        0 => "No Longer needed",
        1 => "Looking for other Brands",
        2 => "Placed the wrong quantity",
        3 => "Wanted another product",
        4 => "The price is too high",
        5 => "Do not want to disclose reason"
    ];

    if(is_get() && isset($_GET["id"])){
        $orderId = $_GET["id"];
        $stm = $_db->prepare("
                Select * from orders where orderId = ? and userId = ?
                ");
        $stm->execute([$orderId, $userId]);
        $orders = $stm->fetchAll();
        if(count($orders)<1){
            redirect("/pages/order/order.php");
        }
    }
    else{
        if(is_post() &&  isset($_POST["reason"]) && isset($_GET["id"])){
            $reason = $_POST["reason"];
            $orderId = $_GET["id"];
            try{
                $stm = $_db->prepare("
                UPDATE `orders`
                SET status = 'Canceled', cancel_reason = ?
                WHERE orderId = ? AND userId = ?
                ");
                $stm->execute([$reasons[$reason], $orderId, $userId]);
                temp('info',"Order Canceled!");
            }
            catch (Exception $e){
                ; // probably order not found
            }
            finally {
                redirect("/pages/order/order.php");
            }
            
        }
        else {
            redirect("/pages/order/order.php");
        }
        
    }
    





    include "../../_head.php";
?>

<div class="container">
    <form method="POST" id="cancel-form">
        <p>We're sorry to hear that you'd like to cancel your order. Can you help us understand why?</p>
        <p class="error-msg" style="color: red; display: none;">Please select a reason.</p>
        <?php 
            foreach($reasons as $key => $r){
                echo "<div style='display: flex; margin-bottom: 10px; border: 1px solid rgb(100, 100, 100); border-radius: 8px; padding: 5px;'>";
                echo "<input type='radio' name='reason' value='$key' id='$key'>";
                echo "<label for='$key'>$r</label>";
                echo "</div>";
            }
        ?>

        <button id="submit">Submit</button>
    </form>
</div>


<script>
    const error = document.querySelector(".error-msg");
    $("#submit").on('click', function(e){
        if($("input[type='radio']:checked").length > 0){
        }
        else {
            
            e.preventDefault();
            e.stopImmediatePropagation();
            $(error).css({
                display: "block"
            });
            
        }

    })        
</script>
<?php 
    include "../../_foot.php";
?>