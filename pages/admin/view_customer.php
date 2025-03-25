<?php
require '../../_base.php';

$title = 'View Customer';
$stylesheetArray = ['/css/admin_product.css', '/css/admin_customer.css'];   // 注意：这边只放特定于此页面的 .css file(s)。所有 admin 页面都会用到的 .css files 应放在 /css/admin.css
$scriptArray = ['/js/app.js'];       // 注意：这边只放特定于此页面的 .js file(s)。所有 admin 页面都会用到的 .js files 应放在 /js/admin.js

require_once  "../admin/main.php";
?>
<?php
$arr = $_db->query('SELECT * FROM user')->fetchAll();
?>
<div class="searchBar">
    <a href="" class="add">Add Admin</a>
</div>

<div class="main-content" style="  margin-left: var(--sidebar-width);
margin-top: 50px;
padding: 1rem;">
    <div class="container-table">


        <div class="tb-title">
            <h5 style="margin: 0;"><i class="fas fa-table"></i> Customer </h5>
        </div>

        <div style="padding: 1rem;">
            <table class="tb">
                <tr>
                    <th class="th">Customer ID</th>
                    <th class="th">Name</th>
                    <th class="th">Contact Number</th>
                    <th class="th">Member Status</th>
                    <th class="th">Action</th>
                </tr>
                <?php foreach ($arr as $c): ?>
                    <tr class="row">
                        <td class="content td"><?= $c->userID ?></td>
                        <td class="content td"><?= $c->username ?></td>
                        <td class="content td"><?= $c->phoneNo ?></td>
                        <td class="content td"><?= $c->memberStatus ?></td>
                        <td class="content td">
                            <div class="action">
                                <button class="btn btn-detail" data-get="customer_detail.php?userID=<?= $c->userID ?>"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-delete" data-get="customer_detail.php?userID=<?= $c->userID ?>">Block</button>
                            </div>
                        </td>

                    </tr>
                <?php endforeach ?>
            </table>
        </div>
    </div>

</div>


<?php
require '../../admin_foot.php';
?>