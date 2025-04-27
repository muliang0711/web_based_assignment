<?php
require '../../_base.php';

require 'selection.php';

$title = 'Add a new admin';
$stylesheetArray = ['/css/admin_management.css',];   // 注意：这边只放特定于此页面的 .css file(s)。所有 admin 页面都会用到的 .css files 应放在 /css/admin.css
include '../../admin_login_guard.php';
require_once  "../admin/main.php";
$scriptArray = ['/js/app.js'];       // 注意：这边只放特定于此页面的 .js file(s)。所有 admin 页面都会用到的 .js files 应放在 /js/admin.js

// Functions to generate random id and password
function random_password()
{
    $n = rand(10, 15);

    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomPassword = '';

    for ($i = 0; $i < $n; $i++) {
        $index = random_int(0, strlen($characters) - 1);
        $randomPassword .= $characters[$index];
    }

    return $randomPassword;
}

function random_id()
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomId = '';

    for ($i = 0; $i < 6; $i++) {
        $index = random_int(0, strlen($characters) - 1);
        $randomId .= $characters[$index];
    }

    return $randomId;
}





$_departments = [
    'SA' => 'Sales Department',
    'IT' => 'IT Support',
    'IN' => 'Inventory Department',
    'CS' => 'Customer Service Department',
    'PD' => 'Procurement Department',
    'TS' => 'Technical Support Department',
    'FI' => 'Finance Department'
];




// Handle POST request
if (is_post()) {
    // handle random id and password generation
    if (isset($_POST['generate'])) {
        // $_SESSION['id'] = random_id();
        // $_SESSION['password'] = random_password();
        $id = random_id();
        $password = random_password();
        // header("Location: " . $_SERVER['PHP_SELF']); // 刷新页面，避免重复提交
        // exit();
    }
    else {

        // $id=req('id'); // no need this, because this won't be submitted by the form. `$id = $_SESSION['id']` already store the id value.
        $name = req('name');
        // $password=req('password'); // no need this, because this won't be submitted by the form. `$password = $_SESSION['password']` already store the password value.
        $level = req('level');
        $department = req('department');
        $id = req('id');
        $password = req('password');

        // Validate id
        if ($id == '' || $id == 'click to generate') {
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
    
        // Validate name
        if ($name == '') {
            $_errors['name'] = 'Required';
        } else if (strlen($name) > 20) {
            $_errors['name'] = 'Maximum length 20';
        }
        if ($department == '') {
            $_errors['department'] = 'Required';
        } else if (strlen($department) > 2) {
            $_errors['department'] = 'Error';
        }
    
        // Validate password
        if ($password == '' || $password == 'click to generate') {
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
                                (id, name, department, passwordHash, adminLevel)
                                VALUES(?, ?, ?, ?, ?)');
            $stm->execute([$id, $name, $department, $hashed_password, $level]);
    
            // Destory id and password SESSION variables
            // unset($_SESSION['id']);
            // unset($_SESSION['password']);
    
            temp('info', 'User added successfully');
            redirect("admin_Management.php");
        }
    }

}

$id ??= 'click to generate';
$password ??= 'click to generate';


?>

<div class="main-content" style="  margin-left: var(--sidebar-width);
  margin-top: 50px;
  padding: 1rem;">

    <form method="post" class="insert_form add_container">
        <label for="name">Name</label>
        <?= input_text('name', 'maxlength="20"') ?>
        <?= error('name') ?>

        <br><br>
        <label for="department">Department</label>
    <?= html_select('department', $_departments) ?>
    <?= error('department') ?>

        <br><br>
        <label>Level</label>
        <?= input_radios('level', $_level) ?>
        <!-- <span>Hello</span> -->
        <?= error('level') ?>

        <!--  htmlspecialchars to prevent attack -->
        <!-- <p>User ID: <?php echo htmlspecialchars($id); ?><?= error('id') ?></p> -->
        <p>
            User ID: <input type="hidden" name="id" value="<?= $id ?>"><?php echo htmlspecialchars($id); ?></input>
            <?= error('id') ?>
        </p>

        <p>Password: <input type="hidden" name="password" value="<?= $password ?>"><?php echo htmlspecialchars($password); ?></input><?= error('password') ?></p>

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