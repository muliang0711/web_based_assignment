<?php

require $_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php";
session_start();





if($_SERVER["REQUEST_METHOD"] == "POST"){
    $items = $_POST["items"];
    foreach ($items as &$item) {
        $item = (object) $item; // Convert each element to an object
    }

    $address = $_POST["address"];
    $address = (object)$address;

    $payment = $_POST["payment"];
    $total = $_POST["total"];
    $discount = $_POST["discount"];
    $uid = $_POST["user"];
    $date = $_POST["date"];

    $_SESSION["tempOrder"] = (object)[
        "userId" => $uid,
        "orderDate" => $date,
        "status" => "Pending",
        "orderAddress" => $address->address,
        "orderName" => $address->name,
        "orderPhone" => $address->phone,
        "deliveryMethod" => "Standard",
        "discount" => $discount,
        "items" => $items,
        "total" => $total
    ];



    //if payment is stripe
    if($payment == "Credit Card"){
        $stripe_secret = "sk_test_51R7zgiQj7xprG6v4zOUrIW6DqfGVcq5TMzcV5IokFgU7RLs1xCtVaJO97tyIu8RxliCiFzfAPJ0kcaeCBlDCHyNU00wVb0X5Nw";
        \Stripe\Stripe::setApiKey($stripe_secret);

        $line = [];
        foreach($items as $i){
            $line[] = [
                "quantity" => $i->quantity,
                "price_data" => [
                    "currency" => "myr",
                    "unit_amount" => $i->unitPrice * 100,
                    "product_data" => [
                        "name" => $i->name
                    ]
                ]
            ];
        }

        if($discount>0){
            $coupon = \Stripe\Coupon::create([
                'amount_off' => $discount*100, // RM 10.00 off (Stripe uses cents)
                'currency' => 'myr',
            ]);
            
            $checkout_session = \Stripe\Checkout\Session::create([
                "mode" => "payment",
                "success_url" => "http://localhost/pages/order/success.php",
                "line_items" => $line,
                "discounts" => [
                    [
                        "coupon" => $coupon->id // Apply the dynamically created coupon
                    ]
                ]
    
    
    
    
            ]);
        }



        else{
            $checkout_session = \Stripe\Checkout\Session::create([
                "mode" => "payment",
                "success_url" => "http://localhost/pages/order/success.php",
                "line_items" => $line
    
            ]);
        }

        

        echo $checkout_session->url;
    }


    else if($payment == "Ewallet"){
        echo "/api/tng.php";
    }
};
?>