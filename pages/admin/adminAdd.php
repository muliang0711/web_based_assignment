<?php
require '../../_base.php';
require 'selection.php';
$title='Add a new admin';
$stylesheetArray = ['/css/admin_management.css'];   // 注意：这边只放特定于此页面的 .css file(s)。所有 admin 页面都会用到的 .css files 应放在 /css/admin.css
$scriptArray = ['/js/app.js'];       // 注意：这边只放特定于此页面的 .js file(s)。所有 admin 页面都会用到的 .js files 应放在 /js/admin.js

include '../../admin_head.php';
?>
<?php
//  未完成
if(is_post()){
    $id=req('id');
    $position=req('position');
    $password=req('password');
    $level=req('level');

    // Validate id
     if ($id == '') {
        $_err['id'] = 'Required';
    }
    else if (!is_unique($id, 'admin', 'id')) {
        $_err['id'] = 'Duplicated';
    }
    else {

        $stm = $_db->prepare("SELECT COUNT(*) FROM admin WHERE id = ?");
        $stm->execute([$id]);

        if($stm->fetchColumn() > 0)
        {
            $_err['id'] = 'Duplicated';
        }
    }  

      // Validate position
      if ($position == '') {
        $_err['position'] = 'Required';
    }
    else if (strlen($position) > 20) {
        $_err['position'] = 'Maximum length 20';
    }

    //   // Validate password
    //   if ($id == '') {
    //     $_err['id'] = 'Required';
    // }
 
        // Validate level
        if ($level == '') {
            $_err['level'] = 'Required';
        }

// Output
if (!$_err) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stm = $_db->prepare('INSERT INTO admin
                          (id, position, password, level)
                          VALUES(?, ?, ?, ?)');
    $stm->execute([$id, $position, $password, $level]);
    
    temp('info', 'Record inserted');
    redirect('/');
}


}

?>


<?php
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
//echo random_password();
function random_id() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomId = '';

    for ($i = 0; $i < 6; $i++) {
        $index = random_int(0, strlen($characters) - 1);
        $randomId .= $characters[$index];
    }

    return $randomId;
}

?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate'])) {
    $_SESSION['id'] = random_id();
    $_SESSION['password'] = random_password();
    header("Location: " . $_SERVER['PHP_SELF']); // 刷新页面，避免重复提交
    exit();
}

$id = $_SESSION['id'] ?? 'click to generate';
$password = $_SESSION['password'] ?? 'click to generate';
?>





<form method="post" class="insert_form">
    <label for="position">Position</label>
    <?= input_text('position', 'maxlength="20"') ?>
    <?=error('position') ?>
   
    <br><br>
    <label>Level</label>
    <?= input_radios('level', $_level) ?>
    <?= error('level') ?>

    <!--  htmlspecialchars to prevent attact -->
    <p>User ID： <?php echo htmlspecialchars($id); ?></p>   
    <p>Password:<?php echo htmlspecialchars($password); ?></p>
    <form method="POST">
            <button type="submit" name="generate">Generate ID and Password</button>
        <button>Submit</button>            
        </form>

        <section>

    </section>
</form>



<?php
require '../../admin_foot.php';
?>