<?php
require '../../_base.php';

/********* You can change these to suit the specific needs of your page *********/
$title = 'Profile';
$stylesheetArray = []; // Put CSS files that are specific to this page here. If you want to change the styling of the header and the footer, go to /css/app.cs
$scriptArray = [];      // Put JS files that are specific to this page here. If you want to change the JavaScript for the header and the footer, go to /js/app.js



include '../../_head.php';
?>

<?php if (is_logged_in()): ?>

<h1>Profile page</h1>
<p>Username: <?= $_user->username ?></p>

<?php else: ?>

<h1>You're not logged in!</h1>

<?php endif ?>


<?php
include '../../_foot.php';