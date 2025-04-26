<?php
require $_SERVER["DOCUMENT_ROOT"] . "/_base.php";

try {
    extract((array)$_user);
   
    $userId = $_user->userID;
}
catch (Exception $e){
    echo "error";
    exit;
}

if(is_post() && isset($_POST["message"])){
    $msg = $_POST["message"];
    $adminID = $_POST["adminID"] ?? "A001";

    try{
        $stm = $_db->prepare("Insert Into messages(senderID, adminID, content) values(?,?,?)");
        $stm->execute([$userId, $adminID, $msg]);
        echo "
        <div class='user'>
        $msg
        </div>";
    }
    catch (Exception $e){
        echo "error";
        exit;
    }
    

}
else{
    echo "error";
    exit;
}
?>