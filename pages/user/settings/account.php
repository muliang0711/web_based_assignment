<?php
require '../../../_base.php';

/********* You can change these to suit the specific needs of your page *********/
$title = 'Account settings';
$stylesheetArray = ['/css/password.css', 'profile.css']; // Put CSS files that are specific to this page here. If you want to change the styling of the header and the footer, go to /css/app.cs
$scriptArray = ['/js/password.js'];      // Put JS files that are specific to this page here. If you want to change the JavaScript for the header and the footer, go to /js/app.js

include '../../../_login_guard.php';

extract((array)$_user);

$_genders = [
    'F' => 'Female',
    'M' => 'Male',
    'R' => 'Rather not say',
];

if (is_post()) {
    $action = post('action');
    if ($action == 'changePassword') {

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
            $stm->execute(['userID' => $_user->userID]);
            $pwHash = $stm->fetchColumn();

            if (!pwMatch($password, $pwHash)) {
                $_errors['password'] = 'Incorrect password';
            }
        }

        // Validate: new password
        if ($newPassword == '') {
            $_errors['newPassword'] = 'Required';
        }
        else if ($newPassword == $password) {
            $_errors['newPassword'] = 'Same as what you filled in the "Current password" field';
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
    
        if (!$_errors) {
            // try {
            $passwordHash = pwHash($newPassword);
    
            $stm = $_db->prepare("UPDATE user SET passwordHash = :passwordHash WHERE userID = :userID");
            $stm->execute([
                ':passwordHash' => $passwordHash,
                ':userID' => $_user->userID,
            ]);
    
            temp('info', 'Password successfully changed.');
            redirect();

            // } catch (PDOException $e) {
            //     temp('error', 'Sorry, there was a technical issue. Please <a href="/contact.php">contact</a> the admin.');
            //     redirect();
            // }
        }
    
    

        // // Generate token ID
        // $id = sha1(uniqid() . rand()); // question: why need both uniqid() and rand() ah? is it to increase randomness?

        // // Delete old and insert new token
        // $stm = $_db->prepare('
        //     DELETE FROM token WHERE userID = :userID;

        //     INSERT INTO token (id, type, expire, userID)
        //     VALUES (:tokenID, "change-password", ADDTIME(NOW(), "00:05"), :userID);
        // ');
        // $stm->execute([
        //     'userID' => $_user->userID,
        //     'tokenID' => $id,
        // ]);

        // redirect("reset-password.php?id=$id");
    }   
    else if ($action == 'deleteAccount') {
        redirect('verify_identity.php');
    }
}

include '../../../_head.php';

include 'profile_dynamic_navbar.php';
?>

<div class="main">
    <!-- <section class="info-boxes">
        <div role="alert" class="info-box success"><?= temp('info') ?></div>
        <div role="alert" class="info-box error"><?= temp('error') ?></div>
    </section> -->

    <?php if (!is_email_verified()): ?>
    <section class="info-banner">
        <h2 class="info-banner-heading">Verify your email</h2>
        <div>We'll send a <b>verification link</b> straight to your mailbox, and all you have to do is click on the link. Simple as that.</div>
        <button data-real-post="verify-email.php" class="btn-simple" style="background-color:#cb3816;color:white;margin-top:20px;">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <rect x="2" y="4" width="20" height="16" rx="2" />
                <path d="M22 7L12 14L2 7" />
            </svg>
            Verify now
        </button>
    </section>
    <?php endif ?>

    <h1 class="heading"><?= $current_title ?></h1>
    <div class="left-col"> <!-- .left-col is just a regular div as far as this page is concerned. It is originally used as a flex item of a two-column container. -->
        <!-- CHANGE PASSWORD -->
        <section>
            <h2>Change password</h2>
            <form method="post" class="no-autofocus-first">
                <input type="hidden" name="action" value="changePassword"/>

                <div class="form-group">
                    <label class="label">Current password</label>
                    <div class="password-input-box">
                        <?php input_password('password') ?>
                        <img class="visibility-toggle-icon" src="../../../assets/img/visibility-off.svg" alt="Visibility toggle icon"/>
                    </div>
                    <?= error('password'); ?>
                </div>              
               
                <div class="form-group">
                    <label class="label">New password</label>
                    <div class="password-input-box">
                        <?php input_password('newPassword', 'class="strength-testable"') ?>
                        <img class="visibility-toggle-icon" src="/assets/img/visibility-off.svg" alt="Visibility toggle icon"/>
                    </div>
                    <?= error('newPassword'); ?>
                    <div class="password-strength-tester">
                        <p class="checks" id="charCount">At least 8 characters</p>
                        <p class="checks" id="bothCase">Contains uppercase and lowercase letters</p>
                        <p class="checks" id="specialSymbols">Contains special symbol(s)</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="label">Confirm new password</label>
                    <div class="password-input-box">
                        <?php input_password('confirmNew') ?>
                        <!-- <img class="visibility-toggle-icon" src="/assets/img/visibility-off.svg" alt="Visibility toggle icon"/> -->
                    </div>
                    <?= error('confirmNew'); ?>
                </div>

                <button 
                    type="submit" 
                    class="btn-simple btn-green"
                >Change password</button>

            </form>
        </section>

        <!-- DELETE ACCOUNT -->
        <section>
            <h2>Account maintenance</h2>
            <form method="post">
                <input type="hidden" name="action" value="deleteAccount"/>
                <button 
                    type="submit" 
                    class="btn-simple btn-red"
                >Delete account</button>
            </form>
        </section>


        <!-- <section class="left-col">
            <form method="post">
                <div class="form-group">
                    <label>Username</label>
                    <?= input_text('username') ?>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <?= input_text('email') ?>
                </div>

                <div class="form-group">
                    <label>Bio</label>
                    <?= html_textarea('bio', 'placeholder="Tell us something interesting about yourself"') ?>
                </div>

                <div class="form-group">
                    <label>Gender</label>
                    <?= input_radios('gender', $_genders) ?>
                </div>

                <button 
                    type="submit" 
                    class="btn-simple btn-green"
                    data-confirm="Confirm update?"
                >Update profile</button>
            </form>
        </section>

        <section class="right-col">
            <div class="form-group profile-pic">
                <label>Profile picture</label>
                <label class="profile-pic-button">
                    <?= html_file('photo', 'image/*', 'hidden'); ?>
                    <img src="/assets/img/profile-default-icon-light.svg" alt="Profile picture">
                    <div class="edit-label">Edit</div>
                </l>
            </div>
            
        </section> -->
    </div>
</div>




<?php
include '../../../_foot.php';