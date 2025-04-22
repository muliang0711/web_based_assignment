<?php
require '../../_base.php';

if (is_post()) {
    
    $id = post('id');
    $password = post('password');
    
    var_dump($password);

    if (!$id) {
        $_errors['id'] = 'Required';
    }

    if (!$password) {
        $_errors['password'] = 'Required';
    }

    $stm = $_db->prepare('SELECT * FROM `admin` WHERE id = :id');
    $stm->execute([
        ':id' => $id,
    ]);
    $u = $stm->fetch();

    // If inputs are valid, authenticate user
    if (!$_errors) {
        $stm = $_db->prepare('SELECT * FROM `admin` WHERE id = :id');
        $stm->execute([
            ':id' => $id,
        ]);
        $u = $stm->fetch();

        // If id exists, and password is correct
        if ($u && pwMatch($password, $u->passwordHash)) {
            if (is_blocked("admin", $u->id)) {
                redirect("adminRequestUnblock.php?id={$u->id}"); // TODO
            }

            
            
            login($u->id, "admin");
            
            temp('info', "Logged in as $u->id");
            redirect('admin_home.php');
        }

        $_errors['id'] = ' '; // This serves no functional purpose other than to force autofocus to focus on id (bc it selects the first input that is a sibling of .error). The value has to be ' ' (a space), not '' (empty string), because an empty string evaluates to false, so the error() function always executed the else block, which prints a <span> without a class. Somehow an empty string produces a <span> with no class. 
        $_errors['password'] = 'Wrong id or password';
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
        <!-- <?= link_stylesheet($stylesheetArray ?? ''); ?> -->
    <title>Admin Login</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>


<body>
    <div class="container">
    <h2 class="store-name">Admin Login</h2>
    <h1 class="welcome">Welcome</h1>
    <div class="instruction">Please login to your account</div>

    <form class="form" method="post">
        <div class="form-item">
            <label for="id">Admin ID</label>
            <br>
            <?php input_text('id') ?>
            <?php error("id"); ?>
        </div>

        <div class="form-item">
            <label for="password">Password</label>
            <br>
            <div class="password-input-box">
                <?php input_password('password') ?>
                <img class="visibility-toggle-icon" src="../../assets/img/visibility-off.svg" alt="Visibility toggle icon"/>
            </div>
            <?php error("password"); ?>
        </div>
        <!-- <a href="#" class="forgot-pw">Forgot password?</a> -->
        <button class="button" type="submit">Login</button>            
    </form>


</div>




</body>
<script src="../user/user.js"></script>
</html>







