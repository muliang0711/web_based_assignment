<?php
require '../../_base.php';

/********* You can change these to suit the specific needs of your page *********/
$title = 'Template';
$stylesheetArray = ['example.css']; // Put CSS files that are specific to this page here. If you want to change the styling of the header and the footer, go to /css/app.cs
$scriptArray = ['example.js'];      // Put JS files that are specific to this page here. If you want to change the JavaScript for the header and the footer, go to /js/app.js


// temp('info', 'Something went right.');
// temp('error', 'Something went wrong.');
temp('warn', 'You are not logged in. <a href="/pages/user/user-login.php">Log in</a>');

include '../../_head.php';


echo get_domain();
?>


<!-- main content of the page -->


<?php
include '../../_foot.php';