<?php
require '../../../_base.php';

// When a user is blocked, they are LOGGED OUT before being redirected here.
// So if a user is still logged in when accessing this page, they have NOT been blocked, so redirect them back to home page.
if (is_logged_in("user")) {
    redirect('/');
}

$title = 'Blocked';
include '../../../_head.php';
?>

<h1>You are blocked!!!</h1>
<p>This is a temporary redirect page. Will change the redirect path when SL completes the request unblock page</p>

<?php
include '../../../_foot.php';