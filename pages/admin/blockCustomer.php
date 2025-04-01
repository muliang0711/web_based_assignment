<?php
require '../../_base.php';
// ----------------------------------------------------------------------------

if (is_post()) {
    $userID=req('userID');
    $stm = $_db->prepare('UPDATE user 
        SET memberStatus="Blocked" 
        WHERE userID = :userID
    ');
    $stm->execute([
        'userID' => $userID,
        
    ]);
    temp('info','the user has been BLOCKED');
}
redirect('view_customer.php');