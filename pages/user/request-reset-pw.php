<?php
include '../../_base.php';

// ----------------------------------------------------------------------------

if (is_post()) {
    $email = post('email');

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
            DELETE FROM token WHERE userID = :userID AND type = "change-password";

            INSERT INTO token (id, type, expire, userID)
            VALUES (:tokenID, "change-password", ADDTIME(NOW(), "00:05"), :userID);
        ');
        $stm->execute([
            'userID' => $u->userID,
            'tokenID' => $id,
        ]);
        // $stm->execute([$u->id, $id, $u->id]);

        // These URLs will be used in the email
        $reset_pw_url = base("pages/user/reset-password.php?id=$id"); // link for resetting password with token id as parameter
        $home_url = base('/'); // link to homepage for the logo image in the email 

        // (5) Send email
        $m = get_mail();
        $m->addAddress($u->email, $u->username);
        $m->addEmbeddedImage("../../assets/img/logo.jpg", 'logo'); // add store logo image in email
        $m->isHTML(true); 
        $m->Subject = 'Reset Password';
        $m->Body = get_reset_pw_email_body($u->username, $u->email, $home_url, $reset_pw_url);
        $m->send();

        temp('info', 'Email sent. Please check your inbox (and spam too).');
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
    <div class="instruction">We'll send you an email with a limited-time link to change your password.</div>

    <form class="form" method="post">
        <div class="form-item">
            <label for="email">Email</label>
            <br>
            <?php input_text('email') ?>
            <?php error("email"); ?>
        </div>

        <button class="submit-btn" type="submit">Request password reset</button>            
    </form>
    <script>
        $('form').on('submit', e => {
            e.preventDefault();

            $(e.target).children('.submit-btn').addClass('disabled').html('Sending email...');
            e.target.submit();
        });
    </script>
</div>

<?php
include '../../_foot.php';