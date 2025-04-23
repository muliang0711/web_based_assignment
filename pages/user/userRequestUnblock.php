<?php
require '../../_base.php';
$userID=req('userID');
if (!(is_blocked("user", $userID))) {
    redirect("user-login.php"); 
}
if (is_post()) {
  
    $appealReason = req('appealReason');

    if ($appealReason == '') {
        $_errors['appealReason'] = 'Required';
    } else if (strlen($appealReason) > 30) {
        $_errors['appealReason'] = 'Maximum length 30';
    }



    if (!$_errors) {
        $userID=req('userID');
        $stm = $_db->prepare('UPDATE blockeduser 
        SET status="request",appealReason=:appealReason
        WHERE blockedUserID = :userID
    ');

$stm->execute([
    'userID' => $userID,
    'appealReason'=>$appealReason
]);
temp('info','You have request unblock to the admin');
redirect('/pages/user/user-login.php');
}

    
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
      
    <title>Request Unblock</title>
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
            <label for="appealReason"></label>
            <br>
            <?php input_text('appealReason') ?>
            <?php error("appealReason"); ?>
        </div>

        
        <!-- <a href="#" class="forgot-pw">Forgot password?</a> -->
        <button class="button" type="submit">Submit</button>            
    </form>


</div>




</body>
<script src="../user/user.js"></script>
</html>







