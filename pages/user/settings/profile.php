<?php
require '../../../_base.php';

/********* You can change these to suit the specific needs of your page *********/
$title = 'Profile';
$stylesheetArray = ['profile.css', '/css/zoomable-img.css']; // Put CSS files that are specific to this page here. If you want to change the styling of the header and the footer, go to /css/app.cs
$scriptArray = ['profilePic.js'];      // Put JS files that are specific to this page here. If you want to change the JavaScript for the header and the footer, go to /js/app.js

auth("user");

// Cast the $_user object to an array, then assign each element of the array to a global variable,
// (e.g. $bio, $username, $profilePic, ...)
// so that the <input> generating functions can get the values of each field.
extract((array)$_user);

$_genders = [
    'F' => 'Female',
    'M' => 'Male',
    'R' => 'Rather not say',
];

$_profilePicDir = '../../../File/user-profile-pics/';

// TODO
// - handle request to update profile
if (is_post()) {
    $action = post('action');

    if ($action == 'removeProfPic') {
        // Delete photo from server
        unlink($_profilePicDir . $profilePic); // $profilePic is obtained from extract((array)$_user)

        $stm = $_db->prepare('
            UPDATE user
            SET profilePic = null
            WHERE userID = :userID
        ');
        $stm->execute([
            'userID' => $_user->userID,
        ]);

        temp('info', 'Profile picture removed');
        redirect();
    }

    // Reminder: validation of uploaded photo is done in profilePic.js!

    if ($action == "changeProfPic") {
        // Delete old photo (only if the user had a profile photo prior to this upload)
        if ($profilePic) {
            unlink($_profilePicDir . $profilePic); // $profilePic is obtained from extract((array)$_user)
        }

        // Save new photo
        $f = get_file('profilePic');
        $photo = save_photo($f, $_profilePicDir);

        // Update DB
        $stm = $_db->prepare('
            UPDATE user
            SET profilePic = :profilePicPath
            WHERE userID = :userID
        ');
        $stm->execute([
            'profilePicPath' => $photo,
            'userID' => $_user->userID,
        ]);

        // Set flash message and redirect
        temp('info', 'Profile picture updated');
        redirect();
    }
    // $fields = ['username', 'email', 'bio', 'gender'];

    
    // Check which fields have been changed
    // foreach ($fields as $field) {
        //     $posted_value = post($field);
        //     $current_value = $$field;
        
        //     if ($current_value != $posted_value) {
            //         $changed[$field] = ['old' => $current_value, 'new' => $posted_value];
            //         $$field = $posted_value;
            //     }
            // }
            
    // TODO: need to use JS to check which fields have changed, then insert data-confirm into the Update profile button dynamically.
    
    // TODO: Beautify the display of field error messages.
    // TODO: Red-highlight fields with error and autofocus. Refer to the JS used in user-login.php
    if ($action == "editProfile") {
        $username = post('username');
        $email = post('email');
        $bio = post('bio');
        $gender = post('gender');
        $userID = $_user->userID;

        // Validate username
        $tempErrorMsg = ''; // temporary variable for storing the error message (cannot directly pass $_errors['username'] as reference because it doesn't exist yet)
        if (!$username) {
            $_errors['username'] = 'Ha, nice try, but nope &mdash; you can\'t empty out your username!';
        }
        else if (!is_valid_username($username, $tempErrorMsg)) {
            $_errors['username'] = $tempErrorMsg;
        }
        else if (!is_unique_excl_del($username, 'username') && $username != $_user->username) {
            $_errors['username'] = 'Sorry! Username is taken.';
        }

        // Validate email
        if (!$email) {
            $_errors['email'] = 'Required';
        } 
        else if (!is_email($email)) {
            $_errors['email'] = "Sorry, invalid email format";
        } 
        else if (!is_unique_excl_del($email, 'email') && $email != $_user->email) {
            $_errors['email'] = "Duplicate email found! Another account has been created with this email.";
        }

        // Validate bio
        if (strlen($bio) > 1000) {
            $_errors['bio'] = "Sorry, that's too long! We do appreciate your eagerness though 🫶";
        }

        if (!$_errors) {
            // Update db
            $stm = $_db->prepare('
                UPDATE user 
                SET username = :username, email = :email, bio = :bio, gender = :gender 
                WHERE userID = :userID
            ');
            $stm->execute([
                'username' => $username,
                'email' => $email,
                'bio' => $bio,
                'gender' => $gender,
                'userID' => $userID,
            ]);
        
            // Set flash message then redirect
            temp('info', 'Profile updated');
            redirect();
        }
    

    }

}

include '../../../_head.php';

include 'profile_dynamic_navbar.php';
?>

<!-- Modal Zoom Viewer -->
<div id="imageModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="zoomedImage">
</div>

<!-- Main content -->
<div class="main">
    <!-- <section class="info-boxes">
        <div role="alert" class="info-box success"><?= temp('info') ?></div>
        <div role="alert" class="info-box error"><?= temp('error') ?></div>
    </section> -->


    <?php if (!is_email_verified()): ?>
    <!-- Verify Email Banner -->
    <section class="info-banner">
        <h2 class="info-banner-heading">Verify your email</h2>
        <div>We'll send a <b>verification link</b> straight to your mailbox, and all you have to do is click on the link. Simple as that.</div>
        <form id="verifyEmailForm" action="verify-email.php" method="post">
            <button class="btn-simple submit-btn">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <rect x="2" y="4" width="20" height="16" rx="2" />
                    <path d="M22 7L12 14L2 7" />
                </svg>
                Verify now
            </button>
        </form>
    </section>

    <script>
        $('#verifyEmailForm').on('submit', e => {
            e.preventDefault();

            $(e.target).children('.submit-btn').addClass('disabled').html('Sending email...');
            e.target.submit();
        });
    </script>
    <?php endif ?>

    <h1 class="heading"><?= $current_title ?></h1>
    <div class="section-container">
        <section class="left-col">
            <!-- <div role="alert" class="info-box warning">You have unsaved changes!</div> -->
            <form method="post" class="no-autofocus-first">
                <div class="form-group">
                    <label class="label">Username</label>
                    <?= input_text('username') ?>
                    <br/>
                    <?= error('username'); ?>
                </div>

                <div class="form-group">
                    <label class="label">Email</label>
                    <?= input_text('email') ?>
                    <br/>
                    <?= error('email'); ?>
                </div>

                <div class="form-group">
                    <label class="label">Bio</label>
                    <div class="bio-container">
                        <?= html_textarea('bio', 'placeholder="Tell us something interesting about yourself"') ?>
                        <div id="charCount" style="text-align:right;padding:5px 10px;color:#888;"><span>0</span> / <span>0</span></div>
                    </div>
                    <br/>
                    <?= error('bio'); ?>
                </div>

                <!-- JS for calculating and showing character count and limit for bio -->
                <script>
                    $('textarea#bio ~ #charCount').css('display', 'none');

                    // Update charsLeft and maxChars on input
                    $('textarea#bio').on('input', e => {
                        $('textarea#bio ~ #charCount').css('display', 'block');
                        const length = e.target.value.length;
                        const maxChars = 1000;
                        const charsLeft = maxChars - length;

                        const spanCharsLeft = $(e.target).siblings('#charCount').children('span')[0];
                        const spanMaxChars = $(e.target).siblings('#charCount').children('span')[1];
                        
                        spanCharsLeft.innerHTML = charsLeft;
                        spanMaxChars.innerHTML = maxChars;

                        if (charsLeft < 20) {
                            spanCharsLeft.style.color = '#ca1f1f';
                        }
                    });
                </script>

                <div class="form-group gender">
                    <label class="label">Gender</label>
                    <?= input_radios('gender', $_genders) ?>
                </div>

                <input type="hidden" name="action" value="editProfile"/>
                <button 
                    type="submit" 
                    class="btn-simple btn-green"
                    data-confirm="Confirm update?"
                >Update profile</button>
            </form>
        </section>

        <section class="right-col">
            <div class="form-group profile-pic dropdown">
                <div class="label">Profile picture</div>
                <div class="errorMsg" style="color: var(--color-error-text);margin-bottom:5px;"></div>
                <div class="profile-pic-button dropdown-label" id="profile-pic-button">
                    <img id="profile-pic-img" src="<?= $_user->profilePic ? "/File/user-profile-pics/{$_user->profilePic}" : '/assets/img/profile-default-icon-light.svg' ?>" alt="Profile picture">
                    <!-- <img src="/assets/img/profile-default-icon-light.svg" alt="Profile picture"> -->
                    <!-- <img src="/assets/img/logo.jpg" alt="Profile picture"> -->
                    <div class="edit-label">Edit</div>
                </div>
                <ul class="profile-pic-dropdown dropdown-content">
                    <li class="dropdown-item" id="viewPhotoBtn">View photo</li>
                    <!-- <li class="dropdown-item">Take photo</li> -->

                    <script>
                        $(document).ready(function () {
                            // Zoom modal logic
                            $("#viewPhotoBtn").on("click", function () {
                                $("#zoomedImage").attr("src", $("#profile-pic-img").attr("src"));
                                $("#imageModal").fadeIn();
                            });

                            $(".close").on("click", function () {
                                $("#imageModal").fadeOut();
                            });

                            $("#imageModal").on("click", function (e) {
                                if (e.target === this) {
                                    $(this).fadeOut();
                                }
                            });
                        });
                    </script>

                    <li>
                        <form method="POST" enctype="multipart/form-data" id="profilePicForm">
                            <input type="hidden" name="action" value="changeProfPic"/>
                            <label class="dropdown-item"> <!-- Applied the .dropdown-item class to <label> instead of the containing <li> because this makes the clickable area bigger. -->
                                <?= html_file('profilePic', 'image/*', 'data-popup-id="crop-profile-popup"'); ?>
                                Upload photo
                            </label>
                        </form>
                    </li>

                    <!-- <li class="dropdown-item">
                        <button 
                            data-real-post="?action=removeProfPic" 
                            data-confirm="Are you sure you want to remove your profile picture?"
                        >Remove photo</button>
                    </li> -->
                    <li class="dropdown-item"
                        data-real-post="?action=removeProfPic" 
                        data-confirm="Are you sure you want to remove your profile picture?"
                    >Remove photo</li>
                </ul>
            </div>

            <div class="crop-profile-popup popup-container" id="crop-profile-popup">
                <div class="crop-profile-main popup-main">

                    <img src="/assets/img/profile-default-icon-light.svg" alt="Profile picture">

                    <button class="btn-simple close-popup" id="cancelBtn">Cancel</button>
                    <!-- This submit button is linked to the form with the id "#profilePicForm" via the [form] attribute. Clicking on this submits that form. -->
                    <button type="submit" form="profilePicForm" class="btn-simple btn-green">Confirm</input>
                </div>
            </div>
            
        </section>
    </div>
</div>




<?php
include '../../../_foot.php';