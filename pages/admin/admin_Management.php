<?php
require '../../_base.php';

$title = 'Admin Management';
$stylesheetArray = ['/css/admin_management.css'];   // 注意：这边只放特定于此页面的 .css file(s)。所有 admin 页面都会用到的 .css files 应放在 /css/admin.css

$scriptArray = ['/js/app.js'];       // 注意：这边只放特定于此页面的 .js file(s)。所有 admin 页面都会用到的 .js files 应放在 /js/admin.js
require __DIR__ . "/../admin/main.php";
include '../../admin_login_guard.php';
auth("admin", "main");
?>

<?php
$fields = [
    'id' => 'Admin ID',
    'position' => 'Position'
];

$sort = req('sort');
key_exists($sort, $fields) || $sort = 'id';
$dir = req('dir');
in_array($dir, ['asc', 'desc']) || $dir = 'asc';
$page = req('page', 1);
require_once '../../Pager.php';
$p = new Pager("SELECT * FROM admin where adminLevel ='staff' ORDER BY $sort $dir", [], 10, $page);
$arr = $p->result;

// $arr = $_db->query('SELECT * FROM admin where adminLevel ="staff"')->fetchAll();
?>

<div class="main-content">
    <div class="searchBar">
        <a href="/pages/admin/adminAdd.php" class="btn-add"><i class="fa-solid fa-plus"></i>Add Admin</a>
    </div>
    <div class="container-table">


        <div style="padding: 1rem;">
            <table class="tb">
                <div class="tb-title">
                    <h5 style="margin: 0;"><i class="fas fa-table"></i> Admin </h5>

                    <tr class="admin_header">
                        <?php

                        sorting($fields, $_GET['sort'] ?? '', $_GET['dir'] ?? '');
                        ?>
                        <th>Action</th>
                    </tr>
                </div>
                <?php foreach ($arr as $a): ?>
                    <tr class="row">
                        <td class="td"><?= $a->id ?></td>
                        <td class="td"><?= $a->position ?></td>
                        <td class="td"><button class="action-btn-delete" data-post="/pages/admin/adminDelete.php?id=<?= $a->id ?>" data-confirm="Are you sure you want to delete"><i class="fas fa-trash"></i></button>
                            <?php if ($a->status == 'Active'): ?>
                                <button class="action-btn-delete" data-post="/pages/admin/blockAdmin.php?id=<?= $a->id  ?>" data-confirm="Are you sure you want to block this user?"><i class="fas fa-ban"></i></button>
                            <?php endif ?>
                            <?php if ($a->status == 'Blocked'): ?>
                                <button class="action-btn-unblocked" data-post="/pages/admin/unblockAdmin.php?id=<?= $a->id  ?>" data-confirm="Are you sure you want to unblock this user?"><i class="fas fa-unlock"></i></button>
                            <?php endif ?>
                        </td>

                    </tr>
                <?php endforeach ?>
            </table>
            <div class="pagination" style="text-align: center; margin-top: 1rem;">
                <?= $p->html("sort=$sort&dir=$dir") ?>
            </div>
        </div>





    </div>

</div>
<?php
require '../../admin_foot.php';
?>