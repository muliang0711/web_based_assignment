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
            DELETE FROM token WHERE userID = :userID;

            INSERT INTO token (id, type, expire, userID)
            VALUES (:tokenID, "reset-password", ADDTIME(NOW(), "00:05"), :userID);
        ');
        $stm->execute([
            'userID' => $u->userID,
            'tokenID' => $id,
        ]);
        // $stm->execute([$u->id, $id, $u->id]);

        // (4) Generate token url
        $reset_pw_url = base("pages/user/settings/change-password.php?id=$id");
        $home_url = base('/');

        // (5) Send email
        $m = get_mail();
        $m->addAddress($u->email, $u->username);
        $m->addEmbeddedImage("../../assets/img/logo.jpg", 'logo');
        $m->isHTML(true);
        $m->Subject = 'Reset Password';
        $m->Body = "
            <body style='background-color: #fff; font-family: sans-serif; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; width: 100%; box-sizing: border-box;'>
  <div class='container' style='display: block; margin: 0 auto !important; max-width: 580px; padding: 50px; width: 100%; box-sizing: border-box;'>
    
    <header style='margin-bottom: 30px; box-sizing: border-box;'>
      <a href='$home_url' style='box-sizing: border-box;'>
        <img class='logo' alt='The Shuttle Store' src='cid:logo' style='border: none; width: 100%; max-width: 100px; box-sizing: border-box;'>
      </a>
    </header>

    <main style='box-sizing: border-box;'>
      <p style='color: initial; font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px; box-sizing: border-box;'>
        Hello, $u->username
      </p>

      <p style='color: initial; font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px; box-sizing: border-box;'>
        You requested to reset the password for your account with the e-mail address 
        <a href='mailto:$u->email' style='color: rgb(47, 96, 255); text-decoration: underline; box-sizing: border-box;'>$u->email</a>.
      </p>

      <p style='color: initial; font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px; box-sizing: border-box;'>
        Please click the link below to reset your password.
      </p>

      <p style='color: initial; font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px; box-sizing: border-box;'>
        Note that this link will <b>expire in 5 minutes.</b>
      </p>

      <p style='color: initial; font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px; box-sizing: border-box;'>
        <a class='btn-rounded' href='$reset_pw_url' style='display: inline-block; border: 0; border-radius: 20px; background-color: rgb(47, 96, 255) !important; opacity: 1; color: white; text-decoration: none; cursor: pointer; padding: 10px 20px; transition: all 0.3s; box-sizing: border-box;'>
          Reset password
        </a>
      </p>

      <p style='color: initial; font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px; box-sizing: border-box;'>
        Best regards,<br>The Shuttle Store
      </p>
    </main>

    <footer style='margin-top: 30px; box-sizing: border-box;'>
      <small style='opacity: 0.5; box-sizing: border-box;'>
        If you did not request a password request, please feel free to ignore this message.
      </small>
    </footer>

  </div>
</body>

        ";
        $m->send();

        temp('info', 'Email sent. Please check your inbox (and spam).');
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