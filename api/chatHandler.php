<?php
require $_SERVER["DOCUMENT_ROOT"] . "/_base.php";



if(is_post() && isset($_POST["message"]) && !isset($_POST["task"])){
    try {
        extract((array)$_user);
       
        $userId = $_user->userID;
    }
    catch (Exception $e){
        echo "error";
        exit;
    }
    $msg = $_POST["message"];
    $adminID = $_POST["adminID"] ?? "A001";

    try{
        $stm = $_db->prepare("Insert Into messages(senderID, adminID, content) values(?,?,?)");
        $stm->execute([$userId, $adminID, $msg]);
        $messageID = $_db->lastInsertId('messageID');
        $data = [
            "msgID" => $messageID,
            "response" => "<div class='user'>$msg</div>"
        ];
        echo json_encode($data);
        exit;
    }
    catch (Exception $e){
        echo "error";
        exit;
    }
    

}
else if(is_post() && isset($_POST["task"])){
    $task = $_POST["task"];
    if($task == "loadMessage"){
        $result="";
        $userID = $_POST["id"];
        try{
            $stm = $_db->prepare("Select * from messages WHERE senderID = ? ORDER BY sent_at asc");
            $stm->execute([$userID]);
            $messages = $stm->fetchAll();
        }
        catch(Exception $e){
            echo "error";
            exit;
        }
        

        foreach($messages as $m){
            if($m->userSent == "1"){
                $result .= "<div class='user'>$m->content</div>";
            }
            else{
                $result .= "<div class='admin'>$m->content</div>";
            }
        }
        echo $result;
        exit;
    }

    else if($task == "adminSend"){
        $adminID = $_SESSION['adminID'] ?? null;
        $userId = $_POST["userid"];
        $msg = $_POST["message"];
        if($adminID == null){
            echo "error";
            exit;
        }

        try{
            $stm = $_db->prepare("Insert Into messages(senderID, adminID, content, userSent) values(?,?,?,0)");
            $stm->execute([$userId, $adminID, $msg]);
            $messageID = $_db->lastInsertId('messageID');
            $data = [
                "msgID" => $messageID,
                "response" => "<div class='admin'>$msg</div>"
            ];
            echo json_encode($data);
            exit;
        }
        catch (Exception $e){
            echo "error";
            exit;
        }
    }

    else if($task == "userGetMessage"){
        try {
            extract((array)$_user);
           
            $userId = $_user->userID;
        }
        catch (Exception $e){
            echo "error";
            exit;
        }
        $lastID = $_POST["lastID"];
        $stm = $_db->prepare('
        Select content, messageID from messages WHERE senderID = ? AND userSent = "0" 
        AND sent_at = (Select MAX(sent_at) from messages 
        WHERE senderID = ? AND userSent = "0") AND messageID > ?');
        $stm->execute([$userId,$userId,$lastID]);
        $msg = $stm->fetchAll();
        if(count($msg)>0){
            $data = [
            "msgID" => $msg[0]->messageID,
            "response" => "<div class='admin'>{$msg[0]->content}</div>"
            ];
            echo json_encode($data);
            exit;
        }
        else{
            echo "error";
            exit;
        }
        

    }

    else if($task == "adminGetMessage"){
        $lastID = $_POST["lastID"];
        $userId = $_POST["userid"];
        $stm = $_db->prepare('
        Select content, messageID from messages WHERE senderID = ? AND userSent = "1" 
        AND sent_at = (Select MAX(sent_at) from messages 
        WHERE senderID = ? AND userSent = "1") AND messageID > ?');
        $stm->execute([$userId,$userId,$lastID]);
        $msg = $stm->fetchAll();
        if(count($msg)>0){
            $data = [
            "msgID" => $msg[0]->messageID,
            "response" => "<div class='user'>{$msg[0]->content}</div>"
            ];
            echo json_encode($data);
            exit;
        }
        else{
            echo "error";
            exit;
        }
        

    }


    else if($task == "getMaxUser"){
        try {
            extract((array)$_user);
           
            $userId = $_user->userID;
        }
        catch (Exception $e){
            echo "error";
            exit;
        }

        $stm = $_db->prepare("Select MAX(messageID) from messages WHERE senderID = ?");
        $stm->execute([$userId]);
        echo $stm->fetchColumn();
        exit;
    }


    else if($task == "getMaxAdmin"){
        $userId = $_POST["userid"];
        $stm = $_db->prepare("Select MAX(messageID) from messages WHERE senderID = ?");
        $stm->execute([$userId]);
        echo $stm->fetchColumn();
        exit;
    }
}
else{
    echo "error";
    exit;
}
?>