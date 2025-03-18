<?php
require '../../_base.php';

$title = 'Login';
$stylesheetArray = ['user.css']; // Put CSS files that are specific to this page here. If you want to change the styling of the header and the footer, go to /css/app.cs
$scriptArray = ['user.js'];      // Put JS files that are specific to this page here. If you want to change the JavaScript for the header and the footer, go to /js/app.js

$usernameRegex = '/^[a-zA-Z0-9](?!.*\.\.)[\w._]{1,28}[a-zA-Z0-9]$/';
$emailRegex = '/^[\w._]+@[a-zA-Z\d.-]+\.[a-zA-Z]{2,}$/';
// Some regex notes:
// 1. `.` is usually a wildcard, meaning "any character except newline",
//    but inside a character class ([...]), `.` loses that special meaning
//    and instead just means a literal dot.
// 2. (?!.*\.\.) is a negative lookahead. The syntax is (?!<pattern>). 
//    Here it makes sure that the username does not contain any consecutive dots (e.g. .., ...)
//    because those might break URL paths.

if (is_post()) {
    var_dump($_errors);

    $username = post('username');
    $password = post('password');

    if (!$username) {
        $_errors['username'] = 'Required';
    } 
    else if (!preg_match($usernameRegex, $username)) {
        $_errors['username'] = 'Invalid format!';
        if (strlen($username) < 3 || strlen($username) > 30) {
            $_errors['username'] .= "<br> - Username must be between 3 and 30 characters.";
        }
        if (preg_match('/^[^a-zA-Z0-9]|[^a-zA-Z0-9]$/', $username)) {
            $_errors['username'] .= "<br> - Username must begin and end with letters or digits.";
        }
        if (preg_match('/[^\w_.]/', $username)) {
            $_errors['username'] .= "<br> - Username must only contain letters, digits, dots (.) or underscores (_).";
        }
        if (preg_match('/\.\./', $username)) {
            $_errors['username'] .= "<br> - Consecutive dots (e.g. ..) are not allowed.";
        } 
        // $_errors['username'] = 'Username should only contain letters, digits, dots, and underscores, and not be longer than 30 characters. Leading or trailing dots and underscores are not allowed.';
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
            login($u->userID, "cust");
            
            // temp('info', "Logged in as $u->username");
            
            // If user was redirected here from a "boomerang" page 
            // user will redirected back to that page upon successful login.
            // ('Boomerang page' is a term I made up that means a page that 
            // logs its path in $_SESSION['fromPage'] before redirecting 
            // the user here, e.g. the user profile page, if accessed by an unsigned-in user, 
            // redirects them here, prompting them to sign in, and upon successful login, the user
            // will be redirected back to the user profile page, like a boomerang!),
            if ($fromPage = temp('fromPage')) {
                redirect($fromPage);
            } 
            // Else, just redirect user to product page.
            else {
                redirect('/pages/product/productlist.php');
            }
        }

        $_errors['username'] = ' '; // This serves no functional purpose other than to force autofocus to focus on username (bc it selects the first input that is a sibling of .error). The value has to be ' ' (a space), not '' (empty string), because an empty string evaluates to false, so the error() function always executed the else block, which prints a <span> without a class. Somehow an empty string produces a <span> with no class. 
        $_errors['password'] = 'Wrong username or password';
    }
}

include '../../_head.php';
?>

<div class="notice-box"><?= temp('info'); ?></div>

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

