<?php
require '../../_base.php';

/********* You can change these to suit the specific needs of your page *********/
$title = 'Profile';
$stylesheetArray = ['profile.css']; // Put CSS files that are specific to this page here. If you want to change the styling of the header and the footer, go to /css/app.cs
$scriptArray = [];      // Put JS files that are specific to this page here. If you want to change the JavaScript for the header and the footer, go to /js/app.js

include '../../_login_guard.php';

extract((array)$_user);
echo $bio;

$_genders = [
    'F' => 'Female',
    'M' => 'Male',
    'R' => 'Rather not say',
];

// TODO
// - handle request to update profile
if (is_post()) {
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
    $username = post('username');
    $email = post('email');
    $bio = post('bio');
    $gender = post('gender');
    $userID = $_user->userID;

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

    temp('info', 'Profile updated');
    redirect();

}

include '../../_head.php';

include 'profile_dynamic_navbar.php';
?>

<div class="main">
    <section class="info-boxes">
        <div role="alert" class="info-box success"><?= temp('info') ?></div>
        <div role="alert" class="info-box error"><?= temp('error') ?></div>
    </section>

    <h1 class="heading">Public profile</h1>
    <div class="section-container">
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
include '../../_foot.php';