<?php
require '../../_base.php';

$title = 'Login';
$stylesheetArray = ['user.css']; // Put CSS files that are specific to this page here. If you want to change the styling of the header and the footer, go to /css/app.cs
$scriptArray = ['user.js'];      // Put JS files that are specific to this page here. If you want to change the JavaScript for the header and the footer, go to /js/app.js


if (is_post()) {
    var_dump($_errors);

    $username = post('username');
    $password = post('password');

    if (!$username) {
        $_errors['username'] = 'Required';
    }

    if (!$password) {
        $_errors['password'] = 'Required';
    }

    $stm = $_db->prepare('SELECT * FROM user WHERE username = :username');
    $stm->execute([
        ':username' => $username,
    ]);
    $u = $stm->fetch();

    // If inputs are valid, authenticate user
    if (!$_errors) {
        $stm = $_db->prepare('SELECT * FROM user WHERE username = :username');
        $stm->execute([
            ':username' => $username,
        ]);
        $u = $stm->fetch();

        // If username exists, and password is correct
        if ($u && $password == $u->password) {
            // Create a session variable to store user object
            $_SESSION['userID'] = $u->userID;
            
            temp('info', "Logged in as $u->username");
            redirect('./test.php');
        }

        $_errors['username'] = ' '; // This serves no functional purpose other than to force autofocus to focus on username (bc it selects the first input that is a sibling of .error). The value has to be ' ' (a space), not '' (empty string), because an empty string evaluates to false, so the error() function always executed the else block, which prints a <span> without a class. Somehow an empty string produces a <span> with no class. 
        $_errors['password'] = 'Wrong username or password';
    }
}

include '../../_head.php';
?>


<div class="container">
    <h2 class="store-name">
        The Shuttle Store
        <img src="../../assets/img/shuttlecock.svg" style="height:1em;transform:rotate(45deg);color:inherit;"/>
    </h2>
    <h1 class="welcome">Welcome</h1>
    <div class="instruction">Please login to your account</div>
    <a class="to-signup" href="/pages/user/user-signup.php">Don't have an account? Sign up</a>

    <form class="form" method="post">
        <div class="form-item">
            <label for="username">Username</label>
            <br>
            <?php input_text('username') ?>
            <?php error("username"); ?>
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
            <input type="checkbox" name="remember-me" value="yes" id="remember-me" />
            <label for="remember-me">Remember me</label>
        </div>

        <a href="#" class="forgot-pw">Forgot password?</a>
        <button class="submit-btn" type="submit">Login</button>            
    </form>
</div>


<?php
include '../../_foot.php';






    // <div class="popup">
    //     <div class="close-btn">x</div>
    // </div>

