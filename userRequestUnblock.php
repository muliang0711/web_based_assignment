<?php
require '../../_base.php';
// ----------------------------------------------------------------------------

if (is_post()) {
    $userID=req('userID');
    $stm = $_db->prepare('UPDATE blockeduser 
    SET status="request" 
    WHERE blockedUserID = :userID
');
$stm->execute([
    'userID' => $userID,
    
]);
temp('info','You have request unblock to the admin');
}
redirect('/pages/user/user-login.php');