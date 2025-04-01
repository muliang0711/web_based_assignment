<?php
require '../../_base.php';
// ----------------------------------------------------------------------------

if (is_post()) {
    $userID=req('userID');
    $stm = $_db->prepare('UPDATE user 
    SET blockedStatus="request" 
    WHERE userID = :userID
');
$stm->execute([
    'userID' => $userID,
    
]);
temp('info','You have request unblock to the admin');
}
redirect('view_customer.php');


