<?php
require '../../_base.php';

$title = 'Sign up';
$stylesheetArray = ['user.css']; // Put CSS files that are specific to this page here. If you want to change the styling of the header and the footer, go to /css/app.cs
$scriptArray = ['user.js'];      // Put JS files that are specific to this page here. If you want to change the JavaScript for the header and the footer, go to /js/app.js


if (is_post()) {
    $username = post('username');
    $email = post('email');
    $password = post('password');
    $cfm_password = post('cfm_password');

    if (!$username) {
        $_errors['username'] = 'Required';
    }
    if (exists_in_db($username, 'user', 'username')) {
        $_errors['username'] = 'Sorry! Username is taken.';
    }

    if (!$email) {
        $_errors['email'] = 'Required';
    }

    if (!$password) {
        $_errors['password'] = 'Required';
    }

    if (!$cfm_password) {
        $_errors['cfm_password'] = 'Please confirm your password';
    }
    else if ($cfm_password != $password) {
        $_errors['cfm_password'] = 'Confirmed password must match with password';
    }

    // THIS IS A JOKE. I REPEAT, THIS IS A JOKE.
    // REMOVE THIS BEFORE TURNING IN THE ASSIGNMENT.
    if (exists_in_db($password, 'user', 'password')) {
        $stm = $_db->prepare('SELECT username FROM user WHERE password = :password');
        $stm->execute([':password' => $password]);
        $u = $stm->fetchColumn();
        $_errors['password'] = "This password has been chosen by $u";
    }

    if (!$_errors) {
        $stm = $_db->prepare('INSERT INTO user (username, email, password, memberStatus) VALUES(:username, :email, :password, :memberStatus)');
        $stm->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $password,
            ':memberStatus' => 'Inactive',
        ]);

        redirect('./user-login.php');
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
            <?php input_text('username') ?>
            <?php error("username"); ?>
        </div>

        <div class="form-item">
            <label for="email">Email Address</label>
            <br>
            <?php input_text('email') ?>
            <?php error("email"); ?>
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

        <div class="form-item">
            <label for="cfm_password">Confirm password</label>
            <br>
            <?php input_password('cfm_password') ?>
            <!-- <input type="password" name="cfm-password" id="cfm-password" value="<?= $cfm_password ?? '' ?>" /> -->
            <?php error("cfm_password"); ?>
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

