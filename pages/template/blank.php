<?php
require '../../_base.php';

/********* You can change these to suit the specific needs of your page *********/
$title = 'Template';
$stylesheetArray = ['example.css']; // Put CSS files that are specific to this page here. If you want to change the styling of the header and the footer, go to /css/app.cs
$scriptArray = ['example.js'];      // Put JS files that are specific to this page here. If you want to change the JavaScript for the header and the footer, go to /js/app.js


// temp('info', 'Something went right.');
// temp('error', 'Something went wrong.');
// temp('warn', 'You are not logged in. <a href="/pages/user/user-login.php">Log in</a>');

// var_dump($_COOKIE);
// var_dump($_COOKIE['remember_me']);
// var_dump($selector);
// var_dump($validator);

// require '../product/SimplePager.php';
// $page = 1;
// $p = new SimplePager('SELECT * FROM user', [], 1, $page);
// var_dump($p->result);
// echo base("pages/youre/dumb");
// echo $_SERVER['HTTP_HOST'];
// var_dump( is_email_verified());
// if (is_post()) {

//     $remember = post('remember-me');
//     if ($remember) {
//         // Generate a secure selector and validator
//         $selector = bin2hex(random_bytes(6)); // public part (for DB lookup)
//         $validator = bin2hex(random_bytes(32)); // secret part
//         $hashedValidator = hash('sha256', $validator);
//         $expire = date('Y-m-d H:i:s', time() + 60 * 60 * 24 * 30); // token expires after 30 days
    
//         // Store `remember-user` token in DB
//         $stmt = $_db->prepare("INSERT INTO token (userID, selector, hashedValidator, expire, `type`)
//                             VALUES (:userID, :selector, :hashedValidator, :expire, 'remember-user')");
//         $stmt->execute([
//             'userID' => $u->userID,
//             'selector' => $selector,
//             'hashedValidator' => $hashedValidator,
//             'expire' => $expire,
//         ]);
    
//         // Set cookie: selector + validator (not hashed)   -> store in browser
//         setcookie(
//             'remember_me',
//             "$selector:$validator",
//             time() + 60 * 60 * 24 * 30,
//             '/',  // allows use of this cookie on the entire domain
//             '',
//             false,  // true is for HTTPS only, but this project uses HTTP
//             true   // HttpOnly: JS can't touch it
//         );
//     }
// }

include '../../_head.php';
?>


<!-- <form>
    <input name="remember-me" type="checkbox">Hello</input>
    <input type="submit"></input>
</form> -->

<?php
include '../../_foot.php';