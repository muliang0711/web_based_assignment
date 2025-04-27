<?php
require $_SERVER["DOCUMENT_ROOT"] . "/_base.php";

if(is_post()){
    
    $task = $_POST["task"];
    $oid = $_POST["id"];
    if($task == "setNotify" || $task == "removeNotify"){
        $val = 0;
        if($task == "setNotify") $val = 1;
        try {
            extract((array)$_user);
           
            $userId = $_user->userID;
        }
        catch (Exception $e){
            echo "error";
            exit;
        }
        $stm = $_db->prepare("Update orders set notify = ? WHERE orderId = ? and userId = ?");
        $stm->execute([$val, $oid, $userId]);
        echo "success";
        exit;
    }
}
?>