<?php
    require $_SERVER["DOCUMENT_ROOT"] . "/_base.php";
    $title = 'Checkout';
    $time = time();
    $dateToday = date("Y-m-d");
    $stylesheetArray  = ["checkout.css"];
    
    
    include $_SERVER["DOCUMENT_ROOT"] . "/_head.php";

    
    $address = $_db->prepare("Select * from savedaddress WHERE userID = ?");
    $address->execute([$userID]);
    $address = $address->fetchAll();

    $items = $_db->prepare("Select c.* , p.price as unitPrice, p.productName as name, p.productImg as img, (c.quantity * p.price) as subtotal
                            FROM cartitem c JOIN product p
                            ON (c.productID = p.productID) WHERE c.userID = ?");
    $items->execute([$userID]);
    $items = $items->fetchAll();

    $_SESSION["subtotal"] = 0.00;
    $_SESSION["discount"] = 0.00;


    $i = 0;

    
?>
<h1>Cart Review</h1>
<div class="giant-container">
    <div class="container">

    <div class="shipping-address">
        <h3>Shipping Information</h3>
        <div class="sliderContainer">
            <button class="left"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="rgb(126, 126, 126)"><path d="M400-80 0-480l400-400 71 71-329 329 329 329-71 71Z"/></svg></button>
            <div class="viewbox">
                <div class="addressSlider">
                    <?php foreach($address as $add): ?>
                    <div class="card <?= $i==0? "selected" :  ""?>">
                        <span class="name"><?= $add->name ?></span><br>
                        <span class="phone"><?= $add->phoneNo ?></span><br>
                        <span class="address"><?= $add->address?></span>
                        <?php $i++ ?>
                    </div>
                    <?php endforeach ?>
                    <div class="card">
                        <button><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="rgb(39, 39, 39)"><path d="M440-280h80v-160h160v-80H520v-160h-80v160H280v80h160v160Zm40 200q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg></button>
                        <span>Add Address</span>
                    </div> 
                </div>
            </div>
            <button class="right"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="rgb(126, 126, 126)"><path d="m321-80-71-71 329-329-329-329 71-71 400 400L321-80Z"/></svg></button>
        </div>
        
    </div>

    <div class="payment-methods">
        <h3>Payment Methods</h3>
        <div class="paymentcontainer">
            <div class="selected">Credit Card</div>
            <div>Paypal</div>
            <div>Skirll</div>
            <div class="border"></div>
        </div>

    </div>

    </div>

    <div class="container2">
    <div class="order-summary">
        <h3>Checkout Summary</h3>


        <?php foreach($items as $item): ?>
        <div class="item">
                <img src="/File/<?= $item->img ?>">
                <span class="product-name" ><?= $item->name ?></span>
                <span class="product-quantity">x<?= $item->quantity ?></span>
                <span class="product-subtotal">RM <?= $item->subtotal ?></span>
                <span class="product-variation"><?= $item->sizeID ?></span>
                <?php 
                $_SESSION["subtotal"]+=$item->subtotal;
                ?>
        </div>
        <?php endforeach ?>

        <div class="subtotal">
            <span>Subtotal</span>
            <span>RM <?= number_format($_SESSION["subtotal"], 2, '.', '') ?></span>
        </div>

        <hr>
        <div class="shipping-fee">
            <span>Shipping</span>
            <span>Free</span>
        </div>

        <div class="discount">
            <span>Discount</span>
            <span>RM <?= number_format($_SESSION["discount"], 2, '.', '') ?></span>
        </div>

        <div class="voucher">
            <span>Voucher</span>
            <input type="text" name="vcr" placeholder="Voucher Code" maxlength="12" autocomplete="false">
            <button id="appVcr">Apply</button>
        </div>

        <hr>
        <div class="total">
            <span>Total</span>
            <span>RM <?= number_format($_SESSION["subtotal"]-$_SESSION["discount"],2,'.','')?></span>
        </div>
    </div>

    <div class="buttons">
        <button id="paymentbutton">Proceed to Payment</button>
    </div>
    </div>

    

</div>

<script>

    $("#paymentbutton").on('click', function(e){
        let payMethod = $(".paymentcontainer").children(".selected")[0].innerText;
        let addressSelect = $(".card.selected");
        let name = addressSelect.children(".name")[0].innerText;
        let phone= addressSelect.children(".phone")[0].innerText;;
        let address= addressSelect.children(".address")[0].innerText;
        var addressJson = {
            name,phone,address
        };
        let discount = 0.00;
        let total = 0.00;

        //get updated values total and discount
        $.ajax({
            url:"/api/spitVal.php",
            type:"POST",
            success: function(res){
                discount = res.discount;
                total = res.total;


                var datas = {
                    total : total,
                    discount : discount,
                    payment : payMethod,
                    items : <?= json_encode($items) ?>,
                    address : addressJson,
                    user : <?= $userID ?>,
                    date : "<?= $dateToday ?>"
                };

                $.ajax({
                    url: "/api/payment.php",
                    data: datas,
                    type: "POST",
                    success: function(res2){
                        location=res2;
                    }
                });
                
            }
        });

        
    })
</script>
    


<?php
    $scriptArray = ["checkout.js"];
    include $_SERVER["DOCUMENT_ROOT"] . "/_foot.php";

?>