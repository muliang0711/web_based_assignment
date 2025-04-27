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
        $oldEmail = $email; // $email holds the old email extracted from $_user at the start of this file

        $username = post('username');
        $email = post('email');
        $bio = post('bio');
        $gender = post('gender');
        $userID = $_user->userID;

        // Validate username
        $tempErrorMsg = ''; // temporary variable for storing the error message (cannot directly pass $_errors['username'] as reference because it doesn't exist yet)
        if (!$username) {
            $_errors['username'] = 'Ha, nice try, but nope &mdash; you can\'t empty out your username!';
        } else if (!is_valid_username($username, $tempErrorMsg)) {
            $_errors['username'] = $tempErrorMsg;
        } else if (!is_unique_excl_del($username, 'username') && $username != $_user->username) {
            $_errors['username'] = 'Sorry! Username is taken.';
        }

        // Validate email
        if (!$email) {
            $_errors['email'] = 'Required';
        } else if (!is_email($email)) {
            $_errors['email'] = "Sorry, invalid email format";
        } else if (!is_unique_excl_del($email, 'email') && $email != $_user->email) {
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

            // If email has changed, set emailVerified to 0 (false)
            if ($email != $oldEmail) {
                $stm = $_db->prepare('
                    UPDATE user 
                    SET emailVerified = 0 
                    WHERE userID = :userID
                ');
                $stm->execute([
                    'userID' => $userID,
                ]);
            }

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
                    <br />
                    <?= error('username'); ?>
                </div>

                <div class="form-group">
                    <label class="label">Email</label>
                    <?= input_text('email') ?>
                    <br />
                    <?= error('email'); ?>
                </div>

                <div class="form-group">
                    <label class="label">Bio</label>
                    <div class="bio-container">
                        <?= html_textarea('bio', 'placeholder="Tell us something interesting about yourself"') ?>
                        <div id="charCount" style="text-align:right;padding:5px 10px;color:#888;"><span>0</span> / <span>0</span></div>
                    </div>
                    <br />
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

                <input type="hidden" name="action" value="editProfile" />
                <button
                    type="submit"
                    class="btn-simple btn-green"
                    data-confirm="Confirm update?">Update profile</button>
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
                    <?php if ($_user->emailVerified == 1): ?>
                        <svg class="verified-user-badge" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <title>Email-verified user</title>
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M11.5283 1.5999C11.7686 1.29437 12.2314 1.29437 12.4717 1.5999L14.2805 3.90051C14.4309 4.09173 14.6818 4.17325 14.9158 4.10693L17.7314 3.3089C18.1054 3.20292 18.4799 3.475 18.4946 3.86338L18.6057 6.78783C18.615 7.03089 18.77 7.24433 18.9984 7.32823L21.7453 8.33761C22.1101 8.47166 22.2532 8.91189 22.0368 9.23478L20.4078 11.666C20.2724 11.8681 20.2724 12.1319 20.4078 12.334L22.0368 14.7652C22.2532 15.0881 22.1101 15.5283 21.7453 15.6624L18.9984 16.6718C18.77 16.7557 18.615 16.9691 18.6057 17.2122L18.4946 20.1366C18.4799 20.525 18.1054 20.7971 17.7314 20.6911L14.9158 19.8931C14.6818 19.8267 14.4309 19.9083 14.2805 20.0995L12.4717 22.4001C12.2314 22.7056 11.7686 22.7056 11.5283 22.4001L9.71949 20.0995C9.56915 19.9083 9.31823 19.8267 9.08421 19.8931L6.26856 20.6911C5.89463 20.7971 5.52014 20.525 5.50539 20.1366L5.39427 17.2122C5.38503 16.9691 5.22996 16.7557 5.00164 16.6718L2.25467 15.6624C1.88986 15.5283 1.74682 15.0881 1.96317 14.7652L3.59221 12.334C3.72761 12.1319 3.72761 11.8681 3.59221 11.666L1.96317 9.23478C1.74682 8.91189 1.88986 8.47166 2.25467 8.33761L5.00165 7.32823C5.22996 7.24433 5.38503 7.03089 5.39427 6.78783L5.50539 3.86338C5.52014 3.475 5.89463 3.20292 6.26857 3.3089L9.08421 4.10693C9.31823 4.17325 9.56915 4.09173 9.71949 3.90051L11.5283 1.5999Z"
                                    fill="#4CAF50"
                                    stroke="#388E3C"
                                    stroke-width="1.5" />
                                <path
                                    d="M9 12L11 14L15 10"
                                    stroke="#FFFFFF"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </g>
                        </svg>
                    <?php endif ?>
                </div>
                <div class="profile-pic-dropdown dropdown-content">
                    <?php if ($_user->profilePic): ?>
                    <li class="dropdown-item" id="viewPhotoBtn">View photo</li>
                    <?php endif ?>
                    <!-- <li class="dropdown-item">Take photo</li> -->

                    <script>
                        $(document).ready(function() {
                            // Zoom modal logic
                            $("#viewPhotoBtn").on("click", function() {
                                $("#zoomedImage").attr("src", $("#profile-pic-img").attr("src"));
                                $("#imageModal").fadeIn();
                            });

                            $(".close").on("click", function() {
                                $("#imageModal").fadeOut();
                            });

                            $("#imageModal").on("click", function(e) {
                                if (e.target === this) {
                                    $(this).fadeOut();
                                }
                            });
                        });
                    </script>

                    <li>
                        <form method="POST" enctype="multipart/form-data" id="profilePicForm">
                            <input type="hidden" name="action" value="changeProfPic" />
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
                    <?php if ($_user->profilePic): ?>
                    <li class="dropdown-item"
                        data-real-post="?action=removeProfPic"
                        data-confirm="Are you sure you want to remove your profile picture?"
                    >Remove photo</li>
                    <?php endif ?>
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
