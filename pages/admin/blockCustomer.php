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

    
$stmB = $_db->prepare('INSERT INTO blockeduser
(blockedUserID, role, status, appealReason)
VALUES(?, ?, ?, ?)');
$stmB->execute([$userID, "user", "-", ""]);

    temp('info','the user has been BLOCKED');
}
redirect('view_customer.php');