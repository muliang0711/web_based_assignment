<?php
require '../../_base.php';

if (is_post()) {

    // If logout button is clicked
    if (isset($_POST['logout'])) {

        // Destory user object session variable
        unset($_SESSION['user_obj']);

        // Reload page
        redirect();
    }
}

$title = 'Login Success';
include '../../_head.php';
?>

<?php if ($_SESSION['user_obj'] ?? false): ?>

<h1>Welcome, <?= $_SESSION['user_obj']->username ?>!</h1>
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