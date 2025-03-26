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
                <?php
        $fields = [
            'userID' => 'Customer ID',
            'username' => 'Name',
            'phoneNo' => 'Contact Number',
            'memberStatus' => 'Member Status'
        ];
        sorting($fields, $_GET['sort'] ?? '', $_GET['dir'] ?? '');
        ?>
        <th>Action</th> 
                </tr>
                <?php foreach ($arr as $c): ?>
                    <tr class="row">
                        <td class="content td"><?= $c->userID ?></td>
                        <td class="content td"><?= $c->username ?></td>
                        <td class="content td"><?= $c->phoneNo ?></td>
                        <td class="content td"><?= $c->memberStatus ?></td>
                        <td class="content td">
                            <div class="action">
                                <button class="action-btn-details" data-get="customer_detail.php?userID=<?= $c->userID ?>"><i class="fas fa-eye"></i></button>
                                <?php if ($c->memberStatus=='Inactive'||$c->memberStatus=='Active'): ?>
                                <button class="action-btn-delete" data-post="/pages/admin/blockCustomer.php?userID=<?= $c->userID ?>" data-confirm="Are you sure you want to block this user?"><i class="fas fa-ban"></i></button>
                                <?php endif ?>
                                <?php if ($c->memberStatus=='Blocked'): ?>
                                <button class="action-btn-unblocked" data-post="/pages/admin/unblockCustomer.php?userID=<?= $c->userID ?>" data-confirm="Are you sure you want to unblock this user?"><i class="fas fa-unlock"></i></button>
                                <?php endif ?>
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

