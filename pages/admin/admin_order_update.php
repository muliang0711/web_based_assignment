<?php 
    require $_SERVER["DOCUMENT_ROOT"] . "/_base.php";


    if(!is_logged_in("admin")){
        echo json_encode(false);
        exit();
    }else{
        //update database here;
        if(is_post()){
            $orderid = $_POST["id"];
            $status = $_POST["status"];
            $tracking = $_POST["tracking"];
            $deliveredDate = $_POST["deliveredDate"];
            $deliveredDate = empty($deliveredDate) ? null : $deliveredDate;
            $tracking = empty($tracking) ? null : $tracking;

            try{
                $stm = $_db->prepare("UPDATE orders SET status = ?,
                 tracking =  ?, 
                 deliveredDate = ?
                WHERE orderId = ?");
                $stm->bindValue(1, $status, PDO::PARAM_STR);
                $stm->bindValue(2, $tracking, is_null($tracking) ? PDO::PARAM_NULL : PDO::PARAM_STR);
                $stm->bindValue(3, $deliveredDate, is_null($deliveredDate) ? PDO::PARAM_NULL : PDO::PARAM_STR);
                $stm->bindValue(4, $orderid, PDO::PARAM_STR);
                $stm->execute();

                //upon updating notify the users

                $stm = $_db->prepare("
                    Select u.username, u.email, o.notify from user u
                    JOIN orders o ON u.userID = o.userId
                    WHERE o.orderId = ?");
                $stm->execute([$orderid]);
                $result = $stm->fetchAll();

                if($result[0]->notify == "1"){
                    $email = $result[0]->email;
                    $username = $result[0]->username;
                    $url = base("pages/order/orderDetails.php?id=$orderid");
                    $cid = 'myimagecid';

                    $m = get_mail();
                    $m->addAddress($email, $username);
                    $m->addEmbeddedImage("../../assets/img/logo.jpg",$cid);
                    $m->isHTML(true); 
                    $m->Subject = 'Delivery Updates';
                    $m->Body = get_notify_order_body($username, $url, $orderid, $cid);
                    $m->send();
                }
                

                echo "success";
                exit();
            }
            catch(PDOException $e){
                echo $e;
                exit();
            }
        }
    }
?>