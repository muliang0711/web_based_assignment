<?php
require '../../_base.php';
// ----------------------------------------------------------------------------

if (is_post()) {
    $id=req('id');
    $stm=$_db->prepare('DELETE FROM admin WHERE id=?');
    $stm->execute([$id]);
    temp('info','Record deleted');
}
redirect('admin_Management.php');