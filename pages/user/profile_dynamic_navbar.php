<?php
$paths = [
    'profile.php' => 'Public profile',
    'personal.php' => 'Personal details',
    'account.php' => 'Account settings',
    'privacy.php' => 'Privacy settings',
    'address.php' => 'Saved address'
];
$current_path = basename($_SERVER['PHP_SELF']);
$current_title = $paths[$current_path];
?>

<nav class="side-nav">
    <ul>
        <?php foreach ($paths as $path => $title): ?>
        <li><a href="<?= $path ?>" <?php echo ($path == $current_path ? 'class="isActive"' : '') ?>><?= $title ?></a></li>
        <?php endforeach ?>
    </ul>
</nav>