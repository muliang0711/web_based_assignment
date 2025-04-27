<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php

require '../../_base.php';
$title='Chats';
$stylesheetArray = ['/css/admin_chat.css'];
$scriptArray = ['/js/admin_chat.js']; 


$adminID = $_SESSION['adminID'];
$defaultPic = "/assets/img/profile-default-icon-dark.svg";

$stm = $_db->query("Select m.senderID as id, m.content as content, u.username as name, u.profilePic as img from messages m
JOIN user u ON (m.senderID = u.userID) WHERE m.sent_at = (
    SELECT MAX(m2.sent_at) 
    FROM messages m2 
    WHERE m2.senderID = m.senderID
)");
$chats = $stm->fetchAll();

include '../../admin_login_guard.php';
require  "main.php";
?>

<div class="main-content">

<div class="chatContainer">
    <div class="chatSideBar">
        <?php foreach($chats as $chat):?>
        <div class="chat" data-id="<?= $chat->id ?>">
            <img src="<?= $chat->img == null ? $defaultPic : "/File/user-profile-pics/".$chat->img ?>">
            <div>
                <span><?= $chat->name ?></span>
                <span><?= $chat->content ?></span>
            </div>
        </div>
        <?php endforeach ?>
    </div>
    <div class="chatBody"></div>
    <div class="chatInput">
        <textarea id="textarealol" type="text" maxlength="200" placeholder="Enter a message"></textarea>
        <button type="button" id="emojiBtn"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="rgb(54, 54, 54)"><path d="M620-520q25 0 42.5-17.5T680-580q0-25-17.5-42.5T620-640q-25 0-42.5 17.5T560-580q0 25 17.5 42.5T620-520Zm-280 0q25 0 42.5-17.5T400-580q0-25-17.5-42.5T340-640q-25 0-42.5 17.5T280-580q0 25 17.5 42.5T340-520Zm140 260q68 0 123.5-38.5T684-400H276q25 63 80.5 101.5T480-260Zm0 180q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-400Zm0 320q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Z"/></svg></button>
        <div id="emojiPicker" class="emoji-picker">
        <span>😁</span> <span>😂</span> <span>🤣</span> <span>😍</span> <span>🥰</span> <span>😎</span> <span>🤔</span> <span>😢</span> <span>🙌</span> <span>🎉</span>
        </div>
        <button class="send"><svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="rgb(78, 118, 250)"><path d="M120-160v-640l760 320-760 320Zm80-120 474-200-474-200v140l240 60-240 60v140Zm0 0v-400 400Z"/></svg></button>
    </div>
</div>




</div>







<?php
require '../../admin_foot.php';
?>