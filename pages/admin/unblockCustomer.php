<?php
require '../../_base.php';
// ----------------------------------------------------------------------------

if (is_post()) {
    $userID=req('userID');
    $stm = $_db->prepare('UPDATE user 
    SET memberStatus="Inactive" 
    WHERE userID = :userID
');
$stm->execute([
    'userID' => $userID,
    
]);

$stmB=$_db->prepare('DELETE FROM blockeduser WHERE blockedUserID=?');
$stmB->execute([$userID]);


    temp('info','the user has been UNBLOCKED');
}

redirect('view_customer.php');