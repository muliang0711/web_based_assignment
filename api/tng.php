<?php 
    $root = $_SERVER["DOCUMENT_ROOT"];
    session_start();
    if(!isset($_SESSION["tempOrder"])){
        header("Location: /");
        exit();
    }
    $details = $_SESSION["tempOrder"];
    unset($_SESSION["tempOrder"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Do not refresh!</title>
    <style>
        body {
            height: 100vh;
            width: 100vw;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .container {
            
            justify-content: center;
            align-items: center;
            width: auto;
            height: auto;
            position: relative;

            >img:first-child{
                scale: 1;
            }

            >img:last-child{
                position: absolute;
                left:56px;
                bottom:46px;
                transform: scale(0.28);
                border-radius: 20px;
                transform-origin: bottom left;
            }
        }

        .buttons {
            width: 20%;
            display: flex;

            >button:first-child{
                margin-right: auto;
                height: 40px;
            }

            >button:last-child{
                margin-left: auto;
                height: 40px;
            }
        }
    </style>
</head>
<body>
    <h1>Amount : RM <?= $details->total ?></h1>
    <div class="container">
        <img src="/assets/img/standee.png">
        <img src="/assets/img/qrcode.jpg">
    </div>
    <div class="buttons">
        <button onclick="cancel()">Cancel</button>
        <button onclick="success()">I have completed my transaction</button>
    </div>


    <script>
        function success(){
            <?php $_SESSION["tempOrder"] = $details ?>
            location = "/pages/order/success.php";
        }

        function cancel(){
            location = "/pages/checkout/checkout.php";
        }
    </script>
</body>
</html>