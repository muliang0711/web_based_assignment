<?php
require '../../_base.php';

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
    <h1 class="welcome">Welcome</h1>
    <div class="instruction">Please login to your account</div>
    <a class="to-signup" href="/pages/user/user-signup.php">Don't have an account? Sign up</a>

    <form class="form">
        <div class="form-item">
            <label for="email">Email Address</label>
            <br>
            <input type="text" name="username" id="email" required/>
        </div>
        
        <div class="form-item">
            <label for="password">Password</label>
            <br>
            <div class="password-input-box">
                <input type="password" name="password" id="password" required/>
                <img class="visibility-toggle-icon" src="../../assets/img/visibility-off.svg" alt="Visibility toggle icon"/>
            </div>
        </div>

        <div class="form-item">
            <input type="checkbox" name="remember-me" value="yes" id="remember-me" />
            <label for="remember-me">Remember me</label>
        </div>

        <a href="#" class="forgot-pw">Forgot password?</a>
        <button class="submit-btn" type="submit">Login</button>            
    </form>
</div>


<?php
include '../../_foot.php';






    // <div class="popup">
    //     <div class="close-btn">x</div>
    // </div>

