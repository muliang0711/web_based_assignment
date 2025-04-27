<?php
require '../../_base.php';

$title = 'Admin Management';
$stylesheetArray = ['/css/admin_management.css'];   // 注意：这边只放特定于此页面的 .css file(s)。所有 admin 页面都会用到的 .css files 应放在 /css/admin.css

$scriptArray = ['/js/app.js'];       // 注意：这边只放特定于此页面的 .js file(s)。所有 admin 页面都会用到的 .js files 应放在 /js/admin.js
include '../../admin_login_guard.php';
require __DIR__ . "/../admin/main.php";
auth("admin", "main");
?>

<?php
$fields = [
    'id' => 'Admin ID',
    'name' => 'Name',
    'department' => 'Department'

];
$name = $_GET['name'] ?? '';
$sort = req('sort');
key_exists($sort, $fields) || $sort = 'id';
$dir = req('dir');
in_array($dir, ['asc', 'desc']) || $dir = 'asc';
$page = req('page', 1);
require_once '../../Pager.php';
 $p = new Pager("SELECT * FROM admin WHERE adminLevel ='staff' AND name like ? ORDER BY $sort $dir", ["%$name%"], 10, $page);

 $arr = $p->result;
// $stm = $_db->prepare("SELECT * FROM admin WHERE adminLevel = 'staff' and name like ? and (department=? or ?) and (id=? or ?) ORDER BY $sort $dir");
// $stm->execute(["%$name%",$department,$department==null,$id,$id==null]);
// $arr = $stm->fetchAll();

// $arr = $_db->query('SELECT * FROM admin where adminLevel ="staff"')->fetchAll();
$departments = [
    'SA' => 'Sales Department',
    'IT' => 'IT Support',
    'IN' => 'Inventory Department',
    'CS' => 'Customer Service Department',
    'PD' => 'Procurement Department',
    'TS' => 'Technical Support Department',
    'FI' => 'Finance Department'
];

$stmA = $_db->prepare("SELECT COUNT(*) AS TotalRequest FROM blockeduser WHERE role ='staff' AND status='request'");
$stmA->execute();
$resultA = $stmA->fetch();

?>

<div class="main-content">
    <div class="searchBar" style="display:flex;">
        <!-- <div> -->
            <div>
<form class="search-box" method="get" action="admin_Management.php">>

    <!-- ?= html_search('name', 'Search admin name...', 'padding: 6px; border-radius: 4px; border: 1px solid #ccc; width: 300px;') ?> -->
      <!-- <input type="text" name="searchText" placeholder="Search..." required> -->
      <input type="hidden" name="action" value="search">
    <input 
    $value ="<?= htmlentities($_GET[$name] ?? '', ENT_QUOTES, 'UTF-8');?>"
        type="text" 
        name="name" 
        placeholder="Search admin name..." 
        style="padding: 6px; border-radius: 4px; border: 1px solid #ccc; width: 300px;"
        required >


      <button onclick="playSoundx()" type="submit">Search</button>
    
    <audio id="clickSoundx" src="../../../sound/success.mp3"></audio>

  <script>
  function playSoundx() {
      const audio = document.getElementById("clickSoundx");
      audio.currentTime = 0; // 每次点击从头播放
      audio.play();
}
</script>
    </form>

</div>  

    <div style="position: absolute; right: 0;">
    <a href="/pages/admin/view_admin_request.php" class="btn-add"><i class="fa-solid fa-envelope-open-text"></i> Request <?= htmlspecialchars($resultA->TotalRequest) ?></a>
    <a href="/pages/admin/adminAdd.php" class="btn-add"><i class="fa-solid fa-plus"></i> Add Admin</a>
    </div>
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
                        <td class="td"><?= $a->name ?></td>
                        <td class="td"><?= $departments[$a->department] ?></td>
                        <td class="td"><button onclick="playSoundG()" class="action-btn-delete" data-post="/pages/admin/adminDelete.php?id=<?= $a->id ?>" data-confirm="Are you sure you want to delete"><i class="fas fa-trash"></i></button>

                        <audio id="clickSoundB" src="../../sound/m5.mp3"></audio>
                            <?php if ($a->status == 'Active'): ?>
                                <button onclick="playSoundE()" class="action-btn-delete" data-post="/pages/admin/blockAdmin.php?id=<?= $a->id  ?>" data-confirm="Are you sure you want to block this user?"><i class="fas fa-ban"></i></button>
                            <?php endif ?>
                            <?php if ($a->status == 'Blocked'): ?>
                                <button onclick="playSoundE()" class="action-btn-unblocked" data-post="/pages/admin/unblockAdmin.php?id=<?= $a->id  ?>" data-confirm="Are you sure you want to unblock this user?"><i class="fas fa-unlock"></i></button>
                            <?php endif ?>
                            <audio id="clickSoundE" src="../../sound/m4.mp3"></audio>
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
    function playSoundG() {
        const audio = document.getElementById("clickSoundB");
        audio.currentTime = 0; // 每次点击从头播放
        audio.play();
  }
</script>
<?php
require '../../admin_foot.php';
?>