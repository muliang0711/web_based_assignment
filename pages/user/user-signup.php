<?php
require '../../_base.php';

$title = 'Sign up';
$stylesheetArray = ['user.css']; // Put CSS files that are specific to this page here. If you want to change the styling of the header and the footer, go to /css/app.cs
$scriptArray = ['user.js'];      // Put JS files that are specific to this page here. If you want to change the JavaScript for the header and the footer, go to /js/app.js


if (is_post()) {
    $username = post('username');
    $email = post('email');
    $password = post('password');
    $cfmPassword = post('cfm-password');

    if (!$username) {
        $_errors['username'] = 'Required';
    }

    if (!$email) {
        $_errors['email'] = 'Required';
    }

    if (!$password) {
        $_errors['password'] = 'Required';
    }

    if (!$cfmPassword) {
        $_errors['cfmPassword'] = 'Please confirm your password';
    }
    else if ($cfmPassword != $password) {
        $_errors['cfmPassword'] = 'Confirmed password must match with password';
    }

    if (!$_errors) {
        $stm = $_db->prepare('INSERT INTO user (username, email, password, memberStatus) VALUES(:username, :email, :password, :memberStatus)');
        $stm->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $password,
            ':memberStatus' => 'Inactive',
        ]);

        redirect('/');
    }


}

include '../../_head.php';
?>


<div class="container">
    <h2 class="store-name">
        The Shuttle Store
        <img src="../../assets/img/shuttlecock.svg" style="height:1em;transform:rotate(45deg);color:inherit;"/>
    </h2>
    <h1 class="welcome">Sign up</h1>
    <div class="instruction">You are minutes away from badminton awesomeness</div>
    <a class="to-signin" href="/pages/user/user-login.php">Already have an account? Sign in</a>

    <!-- <p>Under construction...</p> -->

    <form class="form" method="post">
        <div class="form-item">
            <label for="username">Username</label>
            <br>
            <input type="text" name="username" id="username" value="<?= $username ?? '' ?>" />
            <?php error("username"); ?>
        </div>

        <div class="form-item">
            <label for="email">Email Address</label>
            <br>
            <input type="text" name="email" id="email" value="<?= $email ?? '' ?>" />
            <?php error("email"); ?>
        </div>
        
        <div class="form-item">
            <label for="password">Password</label>
            <br>
            <div class="password-input-box">
                <input type="password" name="password" id="password" value="<?= $password ?? '' ?>" />
                <img class="visibility-toggle-icon" src="../../assets/img/visibility-off.svg" alt="Visibility toggle icon"/>
            </div>
            <?php error("password"); ?>
        </div>

        <div class="form-item">
            <label for="cfm-password">Confirm password</label>
            <br>
            <input type="password" name="cfm-password" id="cfm-password" value="<?= $cfmPassword ?? '' ?>" />
            <?php error("cfmPassword"); ?>
        </div>

        <!-- <div class="form-item">
            <input type="checkbox" id="remember-me"/>
            <label for="remember-me">Remember me</label>
        </div> -->

        <button class="submit-btn" type="submit">Sign up</button>            
    </form>
</div>


<?php
include '../../_foot.php';






    // <div class="popup">
    //     <div class="close-btn">x</div>
    // </div>

