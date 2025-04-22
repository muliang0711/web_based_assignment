<?php
require '../../_base.php';
if (is_post()) {
  
    $requestReason = req('requestReason');

    if ($requestReason == '') {
        $_errors['requestReason'] = 'Required';
    } else if (strlen($requestReason) > 20) {
        $_errors['requestReason'] = 'Maximum length 20';
    }



    if (!$_errors) {
        $userID=req('userID');
        $stm = $_db->prepare('UPDATE blockeduser 
        SET status="request" 
        WHERE blockedUserID = :userID
    ');

$stm->execute([
    'userID' => $userID,
    
]);
temp('info','You have request unblock to the admin');
}
redirect('/pages/user/user-login.php');
    
}

?>
<?php
$stylesheetArray = ['../user/user.css','/css/admin_login.css'];   // 注意：这边只放特定于此页面的 .css file(s)。所有 admin 页面都会用到的 .css files 应放在 /css/admin.css
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= link_stylesheet($stylesheetArray ?? ''); ?>
      
    <title>Admin Login</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>


<body>
    <div class="container">
    <h2 class="store-name">Request Unblock</h2>
    <h1 class="welcome">Sorry</h1>
    <div class="instruction">You have been blocked by admin.</div>

    <form class="form" method="post">
        <p>Your User ID : <?= $userID ?></p>
        <div class="form-item">
            <label for="requestReason"></label>
            <br>
            <?php input_text('requestReason') ?>
            <?php error("requestReason"); ?>
        </div>

        
        <!-- <a href="#" class="forgot-pw">Forgot password?</a> -->
        <button class="button" type="submit">Submit</button>            
    </form>


</div>




</body>
<script src="../user/user.js"></script>
</html>







