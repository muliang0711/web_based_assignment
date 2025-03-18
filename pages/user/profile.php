<?php
require '../../_base.php';

/********* You can change these to suit the specific needs of your page *********/
$title = 'Profile';
$stylesheetArray = ['profile.css']; // Put CSS files that are specific to this page here. If you want to change the styling of the header and the footer, go to /css/app.cs
$scriptArray = [];      // Put JS files that are specific to this page here. If you want to change the JavaScript for the header and the footer, go to /js/app.js

include '../../_login_guard.php';

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