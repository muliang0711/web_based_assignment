<?php
require '../../_base.php';

$title = 'Admin Management';
$stylesheetArray = ['/css/admin_management.css'];   // 注意：这边只放特定于此页面的 .css file(s)。所有 admin 页面都会用到的 .css files 应放在 /css/admin.css

$scriptArray = ['/js/app.js'];       // 注意：这边只放特定于此页面的 .js file(s)。所有 admin 页面都会用到的 .js files 应放在 /js/admin.js
require __DIR__ . "/../admin/main.php";
?>

<?php
$arr = $_db->query('SELECT * FROM admin')->fetchAll();
?>

<div class="main-content">
    <div class="searchBar">
        <a href="/pages/admin/adminAdd.php" class="btn-add"><i class="fa-solid fa-plus"></i>Add Admin</a>
    </div>
    <div class="container-table">

        <div class="tb-title">
            <h5 style="margin: 0;"><i class="fas fa-table"></i> Admin </h5>
        </div>
        <div style="padding: 1rem;">
            <table class="tb">
                <tr class="admin_header">
                    <th class="th">ID</th>
                    <th class="th">Position</th>
                    <th class="th">Action</th>
                </tr>
                <?php foreach ($arr as $a): ?>
                    <tr class="row">
                        <td class="td"><?= $a->id ?></td>
                        <td class="td"><?= $a->position ?></td>
                        <td class="td"><button class="action-btn-delete" data-post="/pages/admin/adminDelete.php?id=<?= $a->id ?>" data-confirm="Are you sure you want to delete"><i class="fas fa-trash"></i></button></td>
                    </tr>
                <?php endforeach ?>
            </table>
        </div>





    </div>

</div>
<?php
require '../../admin_foot.php';
?>