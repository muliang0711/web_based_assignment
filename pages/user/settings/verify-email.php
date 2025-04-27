<?php
require '../../../_base.php';

if (is_post()) {
    // It's a POST request, which means:
    // User came from the "Verify now" button in user settings page, NOT from verification link
    // Because clicking on the verification link sends a GET request.
    // Only clicking on the "Verify now" button sends a POST request to this file.

    // ...So, SEND USER THE EMAIL with verification link

    // No need to retrieve user data from db too, because we have access to $_user, since the user must be logged in to be able to click on the "Verify now" button.
    // (1) Select user
    // $stm = $_db->prepare('SELECT * FROM user WHERE email = ?');
    // $stm->execute([$email]);
    // $u = $stm->fetch();

    // (2) Generate token id
    $id = sha1(uniqid() . rand()); // question: why need both uniqid() and rand() ah? is it to increase randomness?

    // (3) Delete old and insert new token
    // Only delete tokens with the type "verify-email". Tokens for resetting password ain't our business here.
    $stm = $_db->prepare('
        DELETE FROM token WHERE userID = :userID AND type = "verify-email"; 

        INSERT INTO token (id, type, expire, userID)
        VALUES (:tokenID, "verify-email", ADDTIME(NOW(), "00:05"), :userID);
    ');
    $stm->execute([
        'userID' => $_user->userID,
        'tokenID' => $id,
    ]);

    // (4) Generate token url
    $verify_email_url = base("pages/user/settings/verify-email.php?id=$id");
    $home_url = base('/');

    $m = get_mail();
    $m->addAddress($_user->email, $_user->username);
    $m->addEmbeddedImage("../../../assets/img/logo.jpg", 'logo');
    $m->isHTML(true);
    $m->Subject = 'Verify Email';
    $m->Body = get_verify_email_body($_user->username, $_user->email, $home_url, $verify_email_url);
    $m->send();

    temp('info', 'Email sent. Please check your inbox (and spam too).');
    redirect('/');  

}

// If reach this point, that means it was a GET request, not a POST one. (User gets redirected inside the if block for POST requests)
// which also means this is from clicking the verification link!

// (1) Delete expired tokens
$_db->query('DELETE FROM token WHERE expire < NOW()'); // let's do some cleanin' up

$id = req('id'); // token id
if (!isset($id)) {
    redirect('/'); // there's also the possibility of a user accessing this page through a URL without an id parameter at all, in which case we yeet them back to home
}

// (2) Is token id valid? 
if (!exists_in_db($id, 'token', 'id')) {
    temp('error', 'Invalid or expired token. Please try again</a>.'); // invalid token! back to home you go
    redirect('/');
}

// Set `emailVerified` of the user to 1 (TRUE) in DB, then delete the token
$stm = $_db->prepare('
    UPDATE user u
    JOIN token t ON u.userID = t.userID
    SET u.emailVerified = 1
    WHERE t.id = :tokenID;

    DELETE FROM token WHERE id = :tokenID;
');
$stm->execute(['tokenID' => $id]);

temp('info', "Successfully verified email! Stay awesome.");
redirect('/');