<?php
include '../../../_base.php';

// ----------------------------------------------------------------------------

if (is_post()) {
    $password = post('password');

    // Validate: password
    if ($password == '') {
        $_errors['password'] = 'Required';
    }
    else {
        // Get password hash from database
        $stm = $_db->prepare('SELECT passwordHash FROM user WHERE userID = :userID');
        $stm->execute(['userID' => $_user->userID]);
        $pwHash = $stm->fetchColumn();

        if (!pwMatch($password, $pwHash)) {
            $_errors['password'] = 'Incorrect password';
        }
    }

    if (!$_errors) {
        // Delete user from DB
        $stm = $_db->prepare('
            -- DELETE FROM user
            -- WHERE userID = :userID

            UPDATE user
            SET isDeleted = 1
            WHERE userID = :userID
        ');
        $stm->execute(['userID' => $_user->userID]);

        // Unset user session variable
        logout('user');

        temp('info', 'Account deleted. It was fun while it lasted 🏸🫡');
        redirect('/');
    }
}

// ----------------------------------------------------------------------------

$title = 'Verify Identity';
$stylesheetArray = ['../user.css', '/css/password.css']; // Put CSS files that are specific to this page here. If you want to change the styling of the header and the footer, go to /css/app.cs
$scriptArray = ['../user.js', '/js/password.js'];      // Put JS files that are specific to this page here. If you want to change the JavaScript for the header and the footer, go to /js/app.js

include '../../../_head.php';
?>

<style>
    /* Hide the header so user cant do weird stuff like jump to login page from change password */
    header {
        display: none;
    }
</style>

<div class="container">
    <a class="back-label" href="account.php">
        <span>🡨</span>
        Back
    </a>
    <h2 class="store-name">
        The Shuttle Store
        <img src="../../../assets/img/shuttlecock.svg" style="height:1em;transform:rotate(45deg);color:inherit;"/>
    </h2>
    <h1 class="welcome">Verify your identity</h1>
    <div class="instruction">We want to be <i>extra</i> sure it's actually you before we poof your account from existence. This is a pretty big deal, after all!</div>

    <form class="form" method="post">
        <div class="form-item">
            <label for="password">Password</label>
            <br>
            <div class="password-input-box">
                <?php input_password('password') ?>
                <img class="visibility-toggle-icon" src="../../../assets/img/visibility-off.svg" alt="Visibility toggle icon"/>
            </div>
            <?php error("password"); ?>
        </div>        

        <button 
            class="submit-btn"
            style="background-color: var(--red);" 
            type="submit"
            data-confirm="Confirm to delete this account?"
        >Delete my account</button>            
    </form>
</div>

<?php
include '../../../_foot.php';