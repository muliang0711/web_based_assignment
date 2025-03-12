<?php
require '../../_base.php';

$title='View Customer';
$stylesheetArray = ['/css/admin_customer.css'];   // 注意：这边只放特定于此页面的 .css file(s)。所有 admin 页面都会用到的 .css files 应放在 /css/admin.css
$scriptArray = ['/js/app.js'];       // 注意：这边只放特定于此页面的 .js file(s)。所有 admin 页面都会用到的 .js files 应放在 /js/admin.js

include '../../admin_head.php';
?>

<?php
$userID = req('userID');//得到id

$stm = $_db->prepare('SELECT * FROM user WHERE userID = ?');//!!!传来这里，来获得资料
$stm->execute([$userID]);
$s = $stm->fetch();

// if (!$s) {
//     redirect('/');
// }

$_title = 'Customer Detail';
?>

<table class="">
    <tr>
        <th>Picture</th>
        <td><?= $s->profilePic ?></td>
    </tr>

    <tr>
        <th>User Id</th>
        <td><?= $s->userID ?></td>
    </tr>
    <tr>
        <th>Customer Name</th>
        <td><?= $s->username ?></td>
    </tr>
    <tr>
        <th>Address</th>
        <td><?= $s->address ?></td>
    </tr>
    <tr>
        <th>Birthdate</th>
        <td><?= $s->birthdate ?></td>
    </tr>
    <tr>
        <th>Email</th>
        <td><?= $s->email ?></td>
    </tr>
    <tr>
        <th>Contact Number</th>
        <td><?= $s->phoneNo ?></td>
    </tr>
    <tr>
        <th>Gender</th>
        <td><?= $s->gender ?></td>
    </tr>
    <tr>
        <th>Member Status</th>
        <td><?= $s->memberStatus ?></td>
    </tr>




</table>

<br>

<button data-get="/">Back</button>

<?php
require '../../admin_foot.php';
?>