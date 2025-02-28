<?php
require '../../_base.php';

/********* You can change these to suit the specific needs of your page *********/
$title = 'Login';
$stylesheetArray = ['user.css']; // Put CSS files that are specific to this page here. If you want to change the styling of the header and the footer, go to /css/app.cs
$scriptArray = ['user.js'];      // Put JS files that are specific to this page here. If you want to change the JavaScript for the header and the footer, go to /js/app.js


/********* You can add other PHP code here (e.g. handle POST or GET requests) *********/

// other php code

/**************************************************************************************/

include '../../_head.php';
?>


<div class="container">
    <h2 class="store-name">
        The Shuttle Store
        <img src="../../assets/img/shuttlecock.svg" style="height:1em;transform:rotate(45deg);color:inherit;"/>
    </h2>
    <h1 class="welcome">Sign up</h1>
    <div class="instruction">You are minutes away from badminton awesomeness</div>

    <p>Under construction...</p>

    <!-- <form class="login-form">
        <div class="form-item">
            <label for="email">Email Address</label>
            <br>
            <input type="text" id="email"/>
        </div>
        
        <div class="form-item">
            <label for="password">Password</label>
            <br>
            <div class="password-input-box">
                <input type="password" id="password"/>
                <img class="visibility-toggle-icon" src="../../assets/img/visibility-off.svg" alt="Visibility toggle icon"/>
            </div>
        </div>

        <div class="form-item">
            <input type="checkbox" id="remember-me"/>
            <label for="remember-me">Remember me</label>
        </div>

        <a href="#" class="forgot-pw">Forgot password?</a>
        <input class="login-btn" type="submit" value="Login"/>            
    </form> -->
</div>


<?php
include '../../_foot.php';






    // <div class="popup">
    //     <div class="close-btn">x</div>
    // </div>

