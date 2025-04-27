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
    'blockedUserID' => 'Admin ID',
    'appealReason'=>'Appeal Reason'
    // 'name' => 'Name',
    // 'department' => 'Department'

];
// $name = $_GET['name'] ?? '';
$sort = req('sort');
key_exists($sort, $fields) || $sort = 'blockedUserID';
$dir = req('dir');
in_array($dir, ['asc', 'desc']) || $dir = 'asc';
$page = req('page', 1);
require_once '../../Pager.php';
//  $p = new Pager("SELECT *
// FROM blockeduser b
// JOIN admin a ON b.blockedUserID = a.id
// WHERE b.role = 'staff' AND b.name LIKE ?
//   ORDER BY $sort $dir", ["%$name%"], 10, $page);
$p = new Pager("SELECT * FROM blockeduser WHERE role ='staff' AND status='request' ORDER BY $sort $dir", [], 10, $page);

 $arr = $p->result;


?>

<div class="main-content">

    <div class="container-table">


        <div style="padding: 1rem;">
            <table class="tb">
                <div class="tb-title">
                    <h5 style="margin: 0;"><i class="fas fa-table"></i> Admin </h5>

                    <tr class="Ruquet Unblock (ADMIN)">
                        <?php

                        sorting($fields, $_GET['sort'] ?? '', $_GET['dir'] ?? '');
                        ?>
                        <th>Action</th>
                    </tr>
                </div>
                <?php foreach ($arr as $a): ?>
                    <tr class="row">
                        <td class="td"><?= $a->blockedUserID ?></td>
                        <td class="td"><?= $a->appealReason ?></td>
                        <td class="td">
                        <button onclick="playSoundE()" class="action-btn-unblocked" data-post="/pages/admin/unblockAdmin.php?id=<?= $a->blockedUserID  ?> " 
                        data-confirm="Are you sure you want to unblock this user?"><i class="fas fa-unlock"></i></button>
                        <audio id="clickSoundE" src="../../sound/m4.mp3"></audio>


                        <button onclick="playSoundB()" class="action-btn-delete" data-post="/pages/admin/rejectUnblock.php?blockedUserID=<?= $a->blockedUserID ?>&role=<?= $a->role ?>" 
                        data-confirm="Are you sure you want to reject unblock this user?"><i class="fa-solid fa-xmark"></i></button>
                        <audio id="clickSoundB" src="../../sound/m5.mp3"></audio>
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
<script>
    function playSoundE() {
        const audio = document.getElementById("clickSoundE");
        audio.currentTime = 0; // 每次点击从头播放
        audio.play();
  }
</script>
<script>
    function playSoundB() {
        const audio = document.getElementById("clickSoundB");
        audio.currentTime = 0; // 每次点击从头播放
        audio.play();
  }
</script>
<?php
require '../../admin_foot.php';
?>