<?php
require '../../_base.php';

/********* You can change these to suit the specific needs of your page *********/
$title = 'Profile';
$stylesheetArray = ['profile.css']; // Put CSS files that are specific to this page here. If you want to change the styling of the header and the footer, go to /css/app.cs
$scriptArray = [];      // Put JS files that are specific to this page here. If you want to change the JavaScript for the header and the footer, go to /js/app.js

include '../../_login_guard.php';

extract((array)$_user);

$_genders = [
    'F' => 'Female',
    'M' => 'Male',
    'R' => 'Rather not say',
];

// TODO
// - handle request to update profile

include '../../_head.php';
?>

<!-- TODO: dynamic nav -->
<nav class="side-nav">
    <ul>
        <li><a href="profile.php" class="isActive">Public profile</a></li>
        <li><a href="personal.php">Personal details</a></li>
        <li><a href="account.php" >Account</a></li>
        <li><a href="privacy.php">Privacy</a></li>
    </ul>
</nav>

<div class="main">
    <section class="info-boxes">
        <div role="alert" class="info-box success"><?= temp('info') ?></div>
        <div role="alert" class="info-box error"><?= temp('error') ?></div>
    </section>

    <h1 class="heading">Public profile</h1>
    <div class="section-container">
        <section class="left-col">
            <!-- <div role="alert" class="info-box warning">You have unsaved changes!</div> -->
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

                <button type="submit" class="btn-simple btn-green">Update profile</button>
            </form>
        </section>

        <section class="right-col">
            <div class="form-group profile-pic">
                <label>Profile picture</label>
                <label class="profile-pic-button">
                    <?= html_file('photo', 'image/*', 'hidden'); ?>
                    <img src="/assets/img/profile-default-icon-light.svg" alt="Profile picture">
                    <!-- <img src="/assets/img/logo.jpg" alt="Profile picture"> -->
                    <div class="edit-label">Edit</div>
                </l>
            </div>
            
        </section>
    </div>
</div>




<?php
include '../../_foot.php';