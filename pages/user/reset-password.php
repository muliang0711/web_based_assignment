<?php
include '../../../_base.php';

// ----------------------------------------------------------------------------

// (1) Delete expired tokens
$_db->query('DELETE FROM token WHERE expire < NOW()');

$id = req('id');


// (2) Is token id valid? 
if (!exists_in_db($id, 'token', 'id')) {
    temp('error', 'Invalid or expired token. Please try again</a>.');
    redirect('/');
}

// Get token object from DB
$stm = $_db->prepare('SELECT * FROM token WHERE id = :tokenID');
$stm->execute(['tokenID' => $id]);
$tokenObj = $stm->fetch();

if (is_post()) {
    $password = post('password');
    $newPassword = post('newPassword');
    $confirmNew  = post('confirmNew');

    // Validate: password
    if ($password == '') {
        $_errors['password'] = 'Required';
    }
    else {
        // Get password hash from database
        $stm = $_db->prepare('SELECT passwordHash FROM user WHERE userID = :userID');
        $stm->execute(['userID' => $tokenObj->userID]);
        $pwHash = $stm->fetchColumn();

        if (!pwMatch($password, $pwHash)) {
            $_errors['password'] = 'Incorrect password';
        }
    }

    // Validate: new password
    if ($newPassword == '') {
        $_errors['newPassword'] = 'Required';
    }
    else if (!is_strong_password($newPassword)) {
        $_errors['newPassword'] = 'Password not strong enough';
    }
    else if (strlen($newPassword) < 5 || strlen($newPassword) > 100) {
        $_errors['newPassword'] = 'Between 5-100 characters';
    }

    // Validate: confirm new password
    if ($confirmNew == '') {
        $_errors['confirmNew'] = 'Required';
    }
    else if ($confirmNew != $newPassword) {
        $_errors['confirmNew'] = 'Does not match with new password';
    }

    // DB operation
    if (!$_errors) {
        // TODO: Update user (password) based on token id + delete token
        $stm = $_db->prepare('
            UPDATE user
            SET passwordHash = :passwordHash
            WHERE userID = (SELECT userID FROM token WHERE id = :tokenID);

            DELETE FROM token WHERE id = :tokenID;
        ');
        $stm->execute([
            'passwordHash' => pwHash($newPassword),
            'tokenID' => $id,
        ]);

        temp('info', 'Password successfully changed.');
        redirect('../user-login.php');
    }
}

// ----------------------------------------------------------------------------

$_title = 'Change Password';
$stylesheetArray = ['../user.css']; // Put CSS files that are specific to this page here. If you want to change the styling of the header and the footer, go to /css/app.cs
$scriptArray = ['../user.js'];      // Put JS files that are specific to this page here. If you want to change the JavaScript for the header and the footer, go to /js/app.js

include '../../../_head.php';
?>

<style>
    /* Hide the header so user cant do weird stuff like jump to login page from change password */
    header {
        display: none;
    }
</style>

<div class="container">
    <h2 class="store-name">
        The Shuttle Store
        <img src="../../../assets/img/shuttlecock.svg" style="height:1em;transform:rotate(45deg);color:inherit;"/>
    </h2>
    <h1 class="welcome">Change password</h1>
    <div class="instruction"></div>

    <form class="form" method="post">
        <!-- The user got here because they forgot their password, so don't ask them for their current password! -->
        <!-- <div class="form-item">
            <label for="password">Current password</label>
            <br>
            <div class="password-input-box">
                <?php //input_password('password') ?>
                <img class="visibility-toggle-icon" src="../../../assets/img/visibility-off.svg" alt="Visibility toggle icon"/>
            </div>
            <?php //error("password"); ?>
        </div> -->

        <div class="form-item">
            <label for="newPassword">New password</label>
            <br>
            <div class="password-input-box">
                <?php input_password('newPassword', 'class="strength-testable"') ?>
                <img class="visibility-toggle-icon" src="../../../assets/img/visibility-off.svg" alt="Visibility toggle icon"/>
            </div>
            <?php error("newPassword"); ?>
            <div class="password-strength-tester">
                <p class="checks" id="charCount">At least 8 characters</p>
                <p class="checks" id="bothCase">Contains uppercase and lowercase letters</p>
                <p class="checks" id="specialSymbols">Contains special symbol(s)</p>
            </div>
        </div>

        <div class="form-item">
            <label for="confirmNew">Confirm new password</label>
            <br>
            <?php input_password('confirmNew') ?>
            <?php error("confirmNew"); ?>
        </div>

        <button class="submit-btn" type="submit">Change password</button>            
    </form>
</div>

<?php
include '../../../_foot.php';