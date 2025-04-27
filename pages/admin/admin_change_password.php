<?php
require '../../_base.php';

$title = 'Change Password';
$stylesheetArray = ['/css/admin_home.css', '/css/password.css', 'admin_change_password.css' ];   // 注意：这边只放特定于此页面的 .css file(s)。所有 admin 页面都会用到的 .css files 应放在 /css/admin.css
$scriptArray = ['/js/password.js'];       // 注意：这边只放特定于此页面的 .js file(s)。所有 admin 页面都会用到的 .js files 应放在 /js/admin.js

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
            $stm = $_db->prepare('SELECT passwordHash FROM `admin` WHERE id = :id');
            $stm->execute(['id' => $_admin->id]);
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
            $passwordHash = pwHash($newPassword);
    
            $stm = $_db->prepare("UPDATE `admin` SET passwordHash = :passwordHash WHERE id = :adminID");
            $stm->execute([
                ':passwordHash' => $passwordHash,
                ':adminID' => $_admin->id,
            ]);
    
            temp('info', 'Password successfully changed.');
            redirect();

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
}


include '../../admin_login_guard.php';
require_once  "../admin/main.php";

?>

<div class="main-content" style="  margin-left: var(--sidebar-width);
  margin-top: var(--topbar-height);
  padding: 1rem;">
    <div class="title">Change password</div>

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
    



</div>

<?php
include '../../admin_foot.php';
?>