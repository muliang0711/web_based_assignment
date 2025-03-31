<?php
if (!is_logged_in("user")) {
    temp('warn', 'You must log in first.');
    temp('fromPage', $_SERVER['REQUEST_URI']); // this ensures that after user logs in, they'll be redirected back to this page. 
    redirect('/pages/user/user-login.php');
}