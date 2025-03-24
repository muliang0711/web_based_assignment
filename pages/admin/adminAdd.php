<?php
require __DIR__ . "/../admin/main.php";
include '../../admin_head.php';
require '../../_base.php';
require 'selection.php';
$title='Add a new admin';
$stylesheetArray = ['/css/admin_management.css'];   // 注意：这边只放特定于此页面的 .css file(s)。所有 admin 页面都会用到的 .css files 应放在 /css/admin.css
$scriptArray = ['/js/app.js'];       // 注意：这边只放特定于此页面的 .js file(s)。所有 admin 页面都会用到的 .js files 应放在 /js/admin.js

// Functions to generate random id and password
function random_password() {
    $n = rand(10,15);

    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomPassword = '';

    for ($i = 0; $i < $n; $i++) {
        $index = random_int(0, strlen($characters) - 1);
        $randomPassword .= $characters[$index];
    }

    return $randomPassword;
}

function random_id() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomId = '';

    for ($i = 0; $i < 6; $i++) {
        $index = random_int(0, strlen($characters) - 1);
        $randomId .= $characters[$index];
    }

    return $randomId;
}

// handle random id and password generation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate'])) {
    $_SESSION['id'] = random_id();
    $_SESSION['password'] = random_password();
    header("Location: " . $_SERVER['PHP_SELF']); // 刷新页面，避免重复提交
    exit();
}

$id = $_SESSION['id'] ?? 'click to generate';
$password = $_SESSION['password'] ?? 'click to generate';


// Handle POST request
if(is_post()){
    // $id=req('id'); // no need this, because this won't be submitted by the form. `$id = $_SESSION['id']` already store the id value.
    $position=req('position');
    // $password=req('password'); // no need this, because this won't be submitted by the form. `$password = $_SESSION['password']` already store the password value.
    $level=req('level');

    // Validate id
    if ($id == ''||$id=='click to generate') {
        $_errors['id'] = 'Required';
    }

    // NOTE BY COOKIE: no need for this else block; it does the same thing as the else if block.
    // else { 

    //     $stm = $_db->prepare("SELECT COUNT(*) FROM admin WHERE id = ?");
    //     $stm->execute([$id]);

    //     if($stm->fetchColumn() > 0)
    //     {
    //         $_errors['id'] = 'Duplicated';
    //     }
    // }  

    // Validate position
    if ($position == '') {
        $_errors['position'] = 'Required';
    }
    else if (strlen($position) > 20) {
        $_errors['position'] = 'Maximum length 20';
    }

      // Validate password
      if ($password == ''||$password=='click to generate') {
        $_errors['password'] = 'Required';
    }


 
    // Validate level
    if ($level == '') {
        $_errors['level'] = 'Required';
    }
    // var_dump($_errors);
    // var_dump($_POST);

    // If no error, insert data into db and reload page
    if (!$_errors) {
        // echo "helloooo\n";
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stm = $_db->prepare('INSERT INTO admin
                            (id, position, password, adminLevel)
                            VALUES(?, ?, ?, ?)');
        $stm->execute([$id, $position, $password, $level]);
        
        // Destory id and password SESSION variables
        unset($_SESSION['id']);
        unset($_SESSION['password']);

        temp('info', 'User added successfully');
        redirect("admin_Management.php");
    }
}

?>

<div class="main-content">

    <form method="post" class="insert_form add_container">
    <label for="position">Position</label>
    <?= input_text('position', 'maxlength="20"') ?>
    <?=error('position') ?>
   
    <br><br>
    <label>Level</label>
    <?= input_radios('level', $_level) ?>
    <!-- <span>Hello</span> -->
    <?= error('level') ?>

    <!--  htmlspecialchars to prevent attack -->
    <p>User ID: <?php echo htmlspecialchars($id); ?><?= error('id') ?></p>   
    
    <p>Password: <?php echo htmlspecialchars($password); ?><?= error('password') ?></p>
    
    <br>
    <form method="POST">
        <button class="subbutton" type="submit" name="generate">Generate ID and Password</button>
        <button class="subbutton" data-confirm="Are you sure you want to add a new admin?">Submit</button>            
    </form>

    <section>

    </section>
    </form>
</div>
<!-- <div class="back">
<a href="admin_Mnagement.php">Back</a>

</div> -->
<?php
require '../../admin_foot.php';
?>