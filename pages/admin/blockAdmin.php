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
    temp('info','the admin has been BLOCKED');
}
redirect('admin_Management.php');