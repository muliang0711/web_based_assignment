<?php 
    require $_SERVER["DOCUMENT_ROOT"] . "/_base.php";


    if(!is_logged_in("admin")){
        echo json_encode(false);
        exit();
    }else{
        //update database here;
        if(is_post()){
            $oid = $_POST['id'];

            try{
                $stm = $_db->prepare("DELETE FROM order_items where orderId = ?")->execute([$oid]);
                $stm = $_db->prepare("DELETE FROM orders where orderId = ?")->execute([$oid]);
                echo "success";
            }
            catch(PDOException $e){
                echo $e;
                exit();
            }
        }
    }
?>