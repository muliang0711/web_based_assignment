<?php
require '../../_base.php';

if (is_post()) {

    // If logout button is clicked
    if (isset($_POST['logout'])) {

        // Destory user object session variable
        logout();

        temp('info', 'Successfully logged out');
        // Reload page
        redirect();
    }
}

$title = 'Login test';
include '../../_head.php';
?>

<?php if (is_logged_in("cust")): ?>

<h1>Welcome, <?= $_user->username ?>!</h1>
<form method="post">
    <input type="hidden" name="logout" />
    <button>Logout</button>
</form>

<?php else: ?>

<h1>You're logged out!</h1>
<form action="user-login.php">
    <button>Sign in</button>
</form>

<?php endif; ?>

<?php
include '../../_foot.php';