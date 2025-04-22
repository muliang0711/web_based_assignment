<?php
require '../../_base.php';
// ----------------------------------------------------------------------------

if (is_post()) {
    $id=req('id');
    $stm = $_db->prepare('UPDATE admin 
    SET status="Blocked" 
    WHERE id = :id
');
$stm->execute([
    'id' => $id,
    
]);


    $stmB = $_db->prepare('INSERT INTO blockeduser
                        (blockedUserID, role, status, appealReason)
                        VALUES(?, ?, ?, ?)');
    $stmB->execute([$id, "staff", "-", ""]);




    temp('info','the admin has been BLOCKED');
}
redirect('admin_Management.php');