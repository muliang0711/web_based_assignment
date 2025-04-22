<?php
require '../../_base.php';
// ----------------------------------------------------------------------------

if (is_post()) {
    $id=req('id');
    $stm = $_db->prepare('UPDATE admin 
    SET status="Active" 
    WHERE id = :id

    
');
$stm->execute([
    'id' => $id,
    
]);

$id=req('id');
$stmB=$_db->prepare('DELETE FROM blockeduser WHERE blockedUserID=?');
$stmB->execute([$id]);

    temp('info','This andmin has been UNBLOCKED');
}

redirect('admin_Management.php');