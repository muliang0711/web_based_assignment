<?php 

require $_SERVER["DOCUMENT_ROOT"] . "/_base.php";
$method = $_SERVER["REQUEST_METHOD"];

if($method == "POST"){
    $index = $_POST["indexToDelete"];

    try{
        extract((array)$_user);
        $userID = $_user->userID;   
        $stm = $_db->prepare("DELETE FROM savedaddress WHERE userID=? AND addressIndex=?");
        $stm->execute([$userID, $index]);
        echo "success";
    }catch(PDOException $e){
        echo $e;
        exit();
    }
}else{
    redirect("/");
}
?>