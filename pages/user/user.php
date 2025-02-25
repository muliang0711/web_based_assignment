<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="user.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <div class="main">
        <h2 class="store-name">
            The Shuttle Store
            <img src="../../assets/img/shuttlecock.svg" style="height:1em;transform:rotate(45deg);color:inherit;"/>
        </h2>
        <h1 class="welcome">Welcome</h1>
        <div class="instruction">Please login to your account</div>

        <form class="login-form">
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
        </form>
    </div>
</body>
<script src="user.js"></script>
</html>