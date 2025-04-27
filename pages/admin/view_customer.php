<?php
require '../../_base.php';

$title = 'View Customer';
$stylesheetArray = ['/css/admin_product.css', '/css/admin_customer.css'];   // 注意：这边只放特定于此页面的 .css file(s)。所有 admin 页面都会用到的 .css files 应放在 /css/admin.css
$scriptArray = ['/js/app.js'];       // 注意：这边只放特定于此页面的 .js file(s)。所有 admin 页面都会用到的 .js files 应放在 /js/admin.js

include '../../admin_login_guard.php';
require_once  "../admin/main.php";
?>
<?php
$fields = [
    'userID' => 'Customer ID',
    'username' => 'Name',
    'phoneNo' => 'Contact Number',
    'memberStatus' => 'Member Status'
];
$username = $_GET['username'] ?? '';
$sort = req('sort');
key_exists($sort,$fields)||$sort='userID';
$dir = req('dir');
in_array($dir,['asc','desc'])||$dir='asc';
$page = req('page', 1);
require_once '../../Pager.php';
$p = new Pager("SELECT * FROM user WHERE username like ? ORDER BY $sort $dir", ["%$username%"], 10, $page);
$arr = $p->result;

// $arr = $_db->query("SELECT * FROM user order by $sort $dir")->fetchAll();
$stmA = $_db->prepare("SELECT COUNT(*) AS TotalRequest FROM blockeduser WHERE role ='user' AND status='request'");
$stmA->execute();
$resultA = $stmA->fetch();

?>


<div class="main-content" style="  margin-left: var(--sidebar-width);
margin-top: 50px;
padding: 1rem;">
<div class="searchBar" style="display:flex;">
    <div>
<!-- <form class="search-box" method="get">

    ?= html_search('username', 'Search customer name...', 'padding: 6px; border-radius: 4px; border: 1px solid #ccc; width: 200px;') ?>

      
    <button  type="submit">Search</button>
     

    </form> -->


    <form class="search-box" method="get" action="view_customer.php">>

<!-- ?= html_search('name', 'Search admin name...', 'padding: 6px; border-radius: 4px; border: 1px solid #ccc; width: 300px;') ?> -->
  <!-- <input type="text" name="searchText" placeholder="Search..." required> -->
  <input type="hidden" name="action" value="search">
<input 
$value ="<?= htmlentities($_GET[$username] ?? '', ENT_QUOTES, 'UTF-8');?>"
    type="text" 
    name="username" 
    placeholder="Search customer name..." 
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
    <a href="/pages/admin/view_customer_request.php" class="btn-add"><i class="fa-solid fa-envelope-open-text"></i> Request <?= htmlspecialchars($resultA->TotalRequest) ?></a>

    </div>

</div>


    <div class="container-table">


        <div class="tb-title">
            <h5 style="margin: 0;"><i class="fas fa-table"></i> Customer </h5>
        </div>

        <div style="padding: 1rem;">
            <table class="tb">
                <tr>
                <?php
        
        sorting($fields, $_GET['sort'] ?? '', $_GET['dir'] ?? '');
        ?>
        <th>Action</th> 
                </tr>
                <?php foreach ($arr as $c): ?>
                    <tr class="row <?php if ($c->isDeleted == 1) echo 'deletedAccount' ?>"> <!-- If $c is a record of a deleted account, apply the CSS class `deletedAccount` to it to gray out the row. -->
                        <td class="content td"><?= $c->userID ?></td>
                        <td class="content td"><?= $c->username ?></td>
                        <td class="content td"><?= $c->phoneNo ?></td>
                        <td class="content td"><?= $c->isDeleted == 1 ? 'Deleted' : $c->memberStatus ?></td> <!-- If this record is a deleted account, show "Deleted". If not, show memberStatus, which is either "Active" or "Blocked". -->
                        <td class="content td">
                            <div class="action">
                                <button class="action-btn-details" data-get="customer_detail.php?userID=<?= $c->userID ?>"><i class="fas fa-eye"></i></button>
                                <?php if ($c->memberStatus=='Active'): ?>
                                <button <?php if ($c->isDeleted == 1) echo 'disabled' ?>onclick="playSound()" class="action-btn-delete" data-post="/pages/admin/blockCustomer.php?userID=<?= $c->userID ?>" data-confirm="Are you sure you want to block this user?"><i class="fas fa-ban"></i></button>
                                <?php endif ?>
                                <?php if ($c->memberStatus=='Blocked'): ?>
                                <button <?php if ($c->isDeleted == 1) echo 'disabled' ?>onclick="playSound()" class="action-btn-unblocked" data-post="/pages/admin/unblockCustomer.php?userID=<?= $c->userID ?>" data-confirm="Are you sure you want to unblock this user?"><i class="fas fa-unlock"></i></button>
                                 

                                <?php endif ?>
                                <audio id="clickSound" src="../../sound/m4.mp3"></audio>
                            </div>
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
    function playSound() {
        const audio = document.getElementById("clickSound");
        audio.currentTime = 0; // 每次点击从头播放
        audio.play();
  }
</script>
<?php
require '../../admin_foot.php';
?>

