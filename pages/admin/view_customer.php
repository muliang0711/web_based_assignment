<?php
require '../../_base.php';

$title='View Customer';
$stylesheetArray = ['/css/admin_product.css','/css/admin_customer.css'];   // 注意：这边只放特定于此页面的 .css file(s)。所有 admin 页面都会用到的 .css files 应放在 /css/admin.css
$scriptArray = ['/js/app.js'];       // 注意：这边只放特定于此页面的 .js file(s)。所有 admin 页面都会用到的 .js files 应放在 /js/admin.js

include '../../admin_head.php';
?>
<?php
$arr = $_db->query('SELECT * FROM user')->fetchAll();
?>
<div class="searchBar">
<a href="" class="add">Add Admin</a>
</div>

<div class="customer_container">
<table class="customer_table">
<tr>
    <th>Customer ID</th>
    <th>Name</th>
    <th>Contact Number</th>
    <th>Member Status</th>
    <th></th>
</tr>
<?php foreach ($arr as $c): ?>
    <tr class="row">
        <td class="content"><?= $c->userID ?></td>
        <td class="content"><?= $c->username ?></td>
        <td class="content"><?= $c->phoneNo ?></td>
        <td class="content"><?= $c->memberStatus ?></td>
        <td>
            <div class="action">
                <button class="btn btn-detail" data-get="customer_detail.php?userID=<?=$c->userID?>">Detail</button>
        <button class="btn btn-delete" data-get="customer_detail.php?userID=<?=$c->userID?>">Block</button>
        </div></td>
        
    </tr>
    <?php endforeach ?>
</table>


</table>
</div>


<?php
require '../../admin_foot.php';
?> 