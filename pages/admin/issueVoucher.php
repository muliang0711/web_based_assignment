<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php

require '../../_base.php';
$title='Issue Voucher';



$scriptArray = ['/js/admin_voucher.js'];    

include '../../admin_login_guard.php';
require  "main.php";
//get all the voucher details
$stm = $_db->prepare("Select * from vouchers");
$stm->execute();
$vouchers = $stm->fetchAll();


?>
<style>
    td{
        text-align: center;
    }

    .addVoucher{
        display: block;
        cursor: pointer;
        margin-top: 20px;
        float:right;
        width: 60px;
        height: 30px;
        color: rgb(255, 255, 255);
        background: rgba(0, 132, 255, 0.38);
        border: 2px solid rgb(0, 132, 255);
        border-radius: 8px;
        transition: transform 0.2s ease;
    }

    .addVoucher:hover, .cancel:hover, .save:hover{
        transform: scale(1.05);
    }

    .CancelSave {
        display: none;
        margin-top: 20px;
        float:right;
    }
    .cancel{
        padding: 10px;
        cursor: pointer;
        border-radius: 8px;
        font-weight: 600;
        color: white;
        background: rgba(112, 112, 112, 0.38);
        border: 2px solid rgb(66, 66, 66);
        transition: transform 0.2s ease;
    }

    .save{
        padding: 10px;
        cursor: pointer;
        margin-left: 10px;
        border-radius: 8px;
        font-weight: 600;
        color: white;
        background: rgba(0, 132, 255, 0.38);
        border: 2px solid rgb(0, 132, 255);
        transition: transform 0.2s ease;

    }

    td > input{
        width: 100px;
        height: 30px;
        border: 2px solid grey;
        border-radius: 7px;
        text-align:center;
    }

    tr > td:first-child{
        font-weight: bold;
    }

    .fa-trash{
        border: 1px solid currentColor;
        color: rgb(255, 0, 85);
        width: 30px;
        height: 30px;
        padding: 5px;
        cursor: pointer;
    }
</style>

<div class="main-content">

<table class="tb">
        <div class="tb-title">
                <h5 style="margin: 0;"><i class="fas fa-table"></i> Vouchers </h5>
        </div>

        <thead>
            <tr>
            <th class="th discount">Voucher Code</th>
            <th class="th discount">Amount (%)</th>
            <th class="th discount">Issued By</th>
            <th class="th discount">Redemption Limit</th>
            <th class="th discount">Total Redeemed</th>
            <th class="th discount">Action</th>
            </tr>
            
        </thead>
        
        <tbody>
            
            <?php foreach($vouchers as $vc): ?>
                <tr>
                    <td class="td"><?= $vc->voucherCode ?></td>
                    <td class="td"><?= $vc->amount ?></td>
                    <td class="td"><?= $vc->issuedBy ?></td>
                    <td class="td">
                        <input type="number" min="<?= $vc->totalUsage ?>" step="1" value="<?= $vc->allowedUsage ?>" data-id="<?= $vc->voucherCode ?>">
                    </td>
                    <td class="td"><?= $vc->totalUsage ?></td>
                    <td class="td"><i class="fas fa-trash" data-code="<?= $vc->voucherCode ?>"></i></td>
                </tr>
            <?php endforeach ?>
            
        </tbody>
        


</table>

<button class="addVoucher"><i class="fas fa-plus"></i></button>
<div class="CancelSave">
    <button class="cancel">Cancel</button>
    <button class="save">Save</button>
</div>




</div>


<?php
require '../../admin_foot.php';
?>