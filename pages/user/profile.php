<?php
require '../../_base.php';

/********* You can change these to suit the specific needs of your page *********/
$title = 'Profile';
$stylesheetArray = ['profile.css']; // Put CSS files that are specific to this page here. If you want to change the styling of the header and the footer, go to /css/app.cs
$scriptArray = [];      // Put JS files that are specific to this page here. If you want to change the JavaScript for the header and the footer, go to /js/app.js

if (!is_logged_in()) {
    temp('info', 'You must log in first.');
    temp('fromPage', $_SERVER['REQUEST_URI']); // this ensures that after user logs in, they'll be redirected back to this page. 
    redirect('/pages/user/user-login.php');
}

include '../../_head.php';
?>

<div class="side-nav">
    <ul>
        <li>Profile</li>
    </ul>
</div>
<div class="main"></div>




<?php
include '../../_foot.php';