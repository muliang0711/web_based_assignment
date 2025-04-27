<?php 
    require $_SERVER["DOCUMENT_ROOT"] . "/_base.php";
    $adminID = $_SESSION['adminID'] ?? null;
    if($adminID == null){
        echo "error";
        exit;
    }

    if(is_post()){
        $task = $_POST["task"];
        if($task == "1"){
            echo "
                <tr>
                    <td class='td'>
                        <input type='text' id='code' placeholder='Voucher Code' maxlength='15'>
                    </td>

                    <td class='td'>
                        <input type='number' min='0' max='100' step='5' id='amount' placeholder='Eg: 20' style='width: 80px; text-align: left;'>
                    </td>

                    <td class='td' id='adminID'>
                        $adminID
                    </td>

                    <td class='td'>
                        <input type='number' min='0' step='1' value='0' id='redeemLimit'>
                    </td>

                    <td class='td'>
                        0
                    </td>
                </tr>
                ";

            exit;
        }
        else if($task == "2"){
            //add the voucher information to database;
            $vcrCode = $_POST["voucherID"];
            $amount = $_POST["amount"];
            $lim = $_POST["redeemLim"];
            
            $stm = $_db->prepare("Select * from vouchers WHERE voucherCode = ?");
            $stm->execute([$vcrCode]);
            $code = $stm->fetchAll();
            if(count($code)>0){
                echo "error";
                exit;
            }

            try{
                $stm = $_db->prepare("
                INSERT into vouchers(voucherCode, amount, issuedBy, allowedUsage, totalUsage)
                values(?,?,?,?,?);
            ");
                $stm->execute([$vcrCode, $amount, $adminID, $lim, 0]);
                echo "success";
                exit;
            }
            catch(PDOException $e){
                echo $e;
                exit;
            }
            
        }

        else if($task == "3"){
            $code = $_POST["code"];
            $stm = $_db->prepare("Select totalUsage from vouchers where voucherCode = ?");
            $stm->execute([$code]);
            echo $stm->fetchColumn();
            exit;
        }

        else if($task == "4"){
            $code = $_POST["code"];
            $value = $_POST["val"];
            $stm = $_db->prepare("UPDATE vouchers set allowedUsage = ? WHERE voucherCode = ?");
            $stm->execute([$value, $code]);
            echo "success";
            exit;
        }

        else if($task == "5"){
            $code = $_POST["code"];
            try {
                $stm = $_db->prepare("Delete from vouchers WHERE voucherCode = ?");
                $stm->execute([$code]);
                echo "success";
                exit;
            }
            catch(PDOException $e) {
                echo "error";
                exit;
            }
        }
    }
    else{
        echo "error";
        exit;
    }
    
?>