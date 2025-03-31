<?php
require '../../_base.php';


if (is_post()) {
    $id=req('id');
    $stm = $_db->prepare('UPDATE admin 
    SET blockedStatus="request" 
    WHERE id = :id
');
$stm->execute([
    'id' => $id,
    
]);
        temp('info','You have request unblock to the admin');
    }
    redirect('admin_login.php');


