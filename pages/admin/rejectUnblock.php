<?php
require '../../_base.php';
// ----------------------------------------------------------------------------
    $blockedUserID=req('blockedUserID');
    $role=req('role');
    // var_dump($role); exit;
if (is_post()) {
    

    $stm = $_db->prepare('UPDATE blockeduser 
        SET status="reject" 
        WHERE blockedUserID = :blockedUserID
    ');
    $stm->execute([
        'blockedUserID' => $blockedUserID,
        
    ]);
    temp('info','the request has been REJECTED');


}
    if($role=="staff"){
redirect('view_admin_request.php');}
elseif($role=="user"){
    redirect('view_customer_request.php');}