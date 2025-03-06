<?php
require '../../_base.php';

$title='Admin Management';
$stylesheetArray = ['/css/admin_management.css'];   // 注意：这边只放特定于此页面的 .css file(s)。所有 admin 页面都会用到的 .css files 应放在 /css/admin.css
$scriptArray = ['../../base.js'];       // 注意：这边只放特定于此页面的 .js file(s)。所有 admin 页面都会用到的 .js files 应放在 /js/admin.js

include '../../admin_head.php';
?>
<?php
//  未完成
if(is_post()){
    $id=req('id');
    $position=req('position');
    $password=req('password');
    $level=req('level');

     // Validate id
    //  if ($id == '') {
    //     $_err['id'] = 'Required';
    // }
    // else if (!preg_match('/^\d{2}[A-Z]{3}\d{5}$/', $id)) {
    //     $_err['id'] = 'Invalid format';
    // }
    // else if (!is_unique($id, 'student', 'id')) {
    //     $_err['id'] = 'Duplicated';
    // }
    // else {

    //     $stm = $_db->prepare("SELECT COUNT(*) FROM admin WHERE id = ?");
    //     $stm->execute([$id]);

    //     if($stm->fetchColumn() > 0)
    //     {
    //         $_err['id'] = 'Duplicated';
    //     }
    // }  

    //   // Validate position
    //   if ($position == '') {
    //     $_err['position'] = 'Required';
    // }
    // else if (strlen($position) > 100) {
    //     $_err['position'] = 'Maximum length 100';
    // }

    //   // Validate password
    //   if ($id == '') {
    //     $_err['id'] = 'Required';
    // }
    // else if (!preg_match('/^\d{2}[A-Z]{3}\d{5}$/', $id)) {
    //     $_err['id'] = 'Invalid format';
    // }

    //     // Validate level
    //     if ($program_id == '') {
    //         $_err['program_id'] = 'Required';
    //     }
    //     else if (!array_key_exists($program_id, $_programs)) {
    //         $_err['program_id'] = 'Invalid value';
    //     }




}

?>
<?php
require '../../admin_foot.php';
?>