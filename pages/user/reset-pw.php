<?php
include '../../_base.php';

// ----------------------------------------------------------------------------

if (is_post()) {
    $email = req('email');

    // Validate: email
    if ($email == '') {
        $_errors['email'] = 'Required';
    }
    else if (!is_email($email)) {
        $_errors['email'] = 'Invalid email format';
    }
    else if (!exists_in_db($email, 'user', 'email')) {
        $_errors['email'] = 'This email isn\'t signed up to any account. <a href="user-signup.php" style="color:#306c80">Sign up?</a>';
    }

    // Send reset token (if valid)
    if (!$_errors) {
        // (1) Select user
        $stm = $_db->prepare('SELECT * FROM user WHERE email = ?');
        $stm->execute([$email]);
        $u = $stm->fetch();

        // (2) Generate token id
        $id = sha1(uniqid() . rand()); // question: why need both uniqid() and rand() ah? is it to increase randomness?

        // (3) Delete old and insert new token
        $stm = $_db->prepare('
            DELETE FROM token WHERE user_id = ?;

            INSERT INTO token (id, expire, user_id)
            VALUES (?, ADDTIME(NOW(), "00:05"), ?);
        ');
        $stm->execute([$u->id, $id, $u->id]);

        // (4) Generate token url
        $url = base("user/token.php?id=$id");

        // (5) Send email
        $m = get_mail();
        $m->addAddress($u->email, $u->name);
        $m->addEmbeddedImage("../photos/$u->photo", 'photo');
        $m->isHTML(true);
        $m->Subject = 'Reset Password';
        $m->Body = "
            <style>
                * {
                box-sizing: border-box;
                }

                img {
                border: none;
                max-width: 100%; 
                }

                header {
                margin-bottom: 30px;
                }

                body {
                background-color: #fff;
                font-family: sans-serif;
                font-size: 14px;
                line-height: 1.4;
                margin: 0;
                padding: 0;
                width: 100%;
                }
                
                footer {
                margin-top: 30px;
                }

                /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
                .container {
                display: block;
                margin: 0 auto !important;
                /* makes it centered */
                max-width: 580px;
                padding: 50px;
                width: 100%; 
                }

                h1 {
                margin-bottom: 15px;
                }

                p {
                color: initial;
                font-family: sans-serif;
                font-size: 14px;
                font-weight: normal;
                margin: 0;
                margin-bottom: 15px; 
                }

                small {
                opacity: 0.5;
                }

                a {
                color: rgb(47, 96, 255);
                text-decoration: underline; 
                }

                button {
                border: 0;
                border-radius: 20px;
                background-color: rgb(47, 96, 255);
                opacity: 1;
                color: white;
                text-decoration: none;
                cursor: pointer;
                padding: 10px 20px;
                transition: all 0.3s;
                }

                button:hover {
                background-color: #ddd;
                color: rgb(47, 96, 255);
                }		
            </style>
            
            <body>
                <div class='container'>
                    <header>
                        <a href='<!-- generate dynamic url of homepage here -->'>
                        <img class='logo' alt='The Shuttle Store' src='<!--logo image path-->'>
                        </a>
                    </header>

                    <main>
                        <p>Hello, [username]</p>
                        <p>
                        You requested to reset the password for your account with the e-mail address 
                        <a href='mailto:<!--email-->'>[email]</a>. 
                        </p>
                        <p>Please click the link below to reset your password.</p>
                        <p><a href='https://www.google.com'><button>Reset password</button></a></p>
                        
                        <p>Best regards,<br>The Shuttle Team</p>
                    </main>

                    <footer>
                        <small>If you did not request a password request, please feel free to ignore this message.</small>
                    </footer>
                </div>
            </body>
        ";
        $m->send();

        temp('info', 'Email sent');
        redirect('/');
    }
}

// ----------------------------------------------------------------------------

$title = 'Reset Password';
$stylesheetArray = ['user.css']; // Put CSS files that are specific to this page here. If you want to change the styling of the header and the footer, go to /css/app.cs
$scriptArray = ['user.js'];      // Put JS files that are specific to this page here. If you want to change the JavaScript for the header and the footer, go to /js/app.js

include '../../_head.php';
?>

<div class="container">
    <h2 class="store-name">
        The Shuttle Store
        <img src="../../assets/img/shuttlecock.svg" style="height:1em;transform:rotate(45deg);color:inherit;"/>
    </h2>
    <h1 class="welcome">Reset password</h1>
    <div class="instruction">Please enter your email so we can help you reset your password.</div>

    <form class="form" method="post">
        <div class="form-item">
            <label for="email">Email</label>
            <br>
            <?php input_text('email') ?>
            <?php error("email"); ?>
        </div>

        <button class="submit-btn" type="submit">Request password reset</button>            
    </form>
</div>

<?php
include '../../_foot.php';