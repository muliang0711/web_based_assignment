<?php
require '../../_base.php';

$title='Admin Management';
$stylesheetArray = ['/css/admin_management.css'];   // 注意：这边只放特定于此页面的 .css file(s)。所有 admin 页面都会用到的 .css files 应放在 /css/admin.css
$scriptArray = ['/js/app.js'];       // 注意：这边只放特定于此页面的 .js file(s)。所有 admin 页面都会用到的 .js files 应放在 /js/admin.js

include '../../admin_head.php';
?>
<?php
$arr = $_db->query('SELECT * FROM admin')->fetchAll();
?>
<div class="searchBar">
<button class="add">Add Admin</button>
</div>

<div class="admin_container">
<table class="admin_table">
<tr>
    <th>ID</th>
    <th>Position</th>
</tr>
<?php foreach ($arr as $a): ?>
    <tr>
        <td class="content"><?= $a->id ?></td>
        <td class="content"><?= $a->position ?></td>
        <td><button data-post="/pages/admin/adminDelete.php?id=<?=$a->id?>" data-confirm="Are you sure you want to delete">Delete</button></td>
        
    </tr>
    <?php endforeach ?>
</table>





</table>
</div>


<?php
require '../../admin_foot.php';
?>