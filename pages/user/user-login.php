<?php
require '../../_base.php';

$title = 'Login';
$stylesheetArray = ['user.css', '/css/password.css']; // Put CSS files that are specific to this page here. If you want to change the styling of the header and the footer, go to /css/app.cs
$scriptArray = ['user.js', '/js/password.js'];      // Put JS files that are specific to this page here. If you want to change the JavaScript for the header and the footer, go to /js/app.js

if (is_logged_in('user')) {
    redirect('/');
}

// $emailRegex = '/^[\w._]+@[a-zA-Z\d.-]+\.[a-zA-Z]{2,}$/';
// Some regex notes:
// 1. `.` is usually a wildcard, meaning "any character except newline",
//    but inside a character class ([...]), `.` loses that special meaning
//    and instead just means a literal dot.
// 2. (?!.*\.\.) is a negative lookahead. The syntax is (?!<pattern>). 
//    Here it makes sure that the username does not contain any consecutive dots (e.g. .., ...)
//    because those might break URL paths.

if (is_post()) {
    // var_dump($_errors);

    $username = post('username');
    $password = post('password');
    $remember = post('remember-me');

    // Validate username
    if (!$username) {
        $_errors['username'] = 'Required';
    } 

    // Validate email
    // if (!is_email($email)) {
    //     $_errors['email'] = "Sorry, invalid email format";
    // }     

    if (!$password) {
        $_errors['password'] = 'Required';
    }

    // var_dump($password);

    // $stm = $_db->prepare('SELECT * FROM user WHERE username = :username');
    // $stm->execute([
    //     ':username' => $username,
    // ]);
    // $u = $stm->fetch();

    // If inputs are valid, authenticate user
    if (!$_errors) {
        $stm = $_db->prepare('SELECT * FROM user WHERE username = :username AND isDeleted = 0');
        $stm->execute([
            ':username' => $username,
        ]);
        $u = $stm->fetch();
        // var_dump($u);

        // If username exists, and password is correct
        if ($u && pwMatch($password, $u->passwordHash)) {
            // If the user is blocked, redirect them to a page that notifies them as such and allows them to make an appeal
            if (is_blocked("user", $u->userID)) {
                redirect("userRequestUnblock.php?userID={$u->userID}"); // TODO
            }

            // Is "Remember me" checked?
            if ($remember) {
                // echo "remembered";

                // Generate a secure selector and validator
                $selector = bin2hex(random_bytes(6)); // public part (for DB lookup)
                $validator = bin2hex(random_bytes(32)); // secret part
                $hashedValidator = hash('sha256', $validator);
                $expire = date('Y-m-d H:i:s', time() + 60 * 60 * 24 * 30); // token expires after 30 days

                // Store `remember-user` token in DB
                $stmt = $_db->prepare("INSERT INTO token (userID, id, hashedValidator, expire, `type`)
                                    VALUES (:userID, :selector, :hashedValidator, :expire, 'remember-user')");
                $stmt->execute([
                    'userID' => $u->userID,
                    'selector' => $selector,
                    'hashedValidator' => $hashedValidator,
                    'expire' => $expire,
                ]);

                // Set cookie: selector + validator (not hashed)   -> store in browser
                setcookie(
                    'remember_me',
                    "$selector:$validator",
                    time() + 60 * 60 * 24 * 30,
                    '/',  // allows use of this cookie on the entire domain
                    '',
                    false,  // true is for HTTPS only, but this project uses HTTP
                    true   // HttpOnly: JS can't touch it
                );
            }

            // var_dump($_COOKIE);
            // var_dump($_COOKIE['remember_me']);

            login($u->userID, "user");

            // redirect('/pages/template/blank.php');
            
            temp('info', "Logged in as $u->username");
            
            // If user was redirected here from a "boomerang" page 
            // user will redirected back to that page upon successful login.
            // ('Boomerang page' is a term I made up that means a page that 
            // logs its path in $_SESSION['fromPage'] before redirecting 
            // the user here, e.g. the user profile page, if accessed by an unsigned-in user, 
            // redirects them here, prompting them to sign in, and upon successful login, the user
            // will be redirected back to the user profile page, like a boomerang!),
            $fromPage = temp('fromPage') ?? req('fromPage');
            if ($fromPage) {
                redirect($fromPage);
            } 
            // Else, just redirect user to product page.
            else {
                redirect('/pages/product/productlist.php');
            }
        }

        $_errors['username'] = ' '; // This serves no functional purpose other than to force autofocus to focus on username (bc it selects the first input that is a sibling of .error). The value has to be ' ' (a space), not '' (empty string), because an empty string evaluates to false, so the error() function always executes the else block, which prints a <span> without a class. Somehow an empty string produces a <span> with no class. 
        $_errors['password'] = 'Wrong username or password';
    }
}

include '../../_head.php';
?>

<div class="notice-box"><?= temp('info'); ?></div>

<div class="container">
    <h2 class="store-name">
        The<span>Shuttle</span>Store
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
            <input type="checkbox" name="remember-me" id="remember-me" />
            <label for="remember-me">Remember me</label>
        </div>

        <a href="request-reset-pw.php" class="forgot-pw">Forgot password?</a>
        <button class="submit-btn" type="submit">Login</button>            
    </form>
</div>


<?php
include '../../_foot.php';






    // <div class="popup">
    //     <div class="close-btn">x</div>
    // </div>

