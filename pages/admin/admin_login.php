<?php
require '../../_base.php';

if (is_post()) {

  $id = post('id');
  $password = post('password');

  // var_dump($password);

  if (!$id) {
    $_errors['id'] = 'Required';
  }

  if (!$password) {
    $_errors['password'] = 'Required';
  }

  $stm = $_db->prepare('SELECT * FROM `admin` WHERE id = :id');
  $stm->execute([
    ':id' => $id,
  ]);
  $u = $stm->fetch();

  // If inputs are valid, authenticate user
  if (!$_errors) {
    $stm = $_db->prepare('SELECT * FROM `admin` WHERE id = :id');
    $stm->execute([
      ':id' => $id,
    ]);
    $u = $stm->fetch();

    // If id exists, and password is correct
    if ($u && pwMatch($password, $u->passwordHash)) {
      if (is_blocked("admin", $u->id)) {
        redirect("adminRequestUnblock.php?id={$u->id}"); // TODO
      }



      login($u->id, "admin");

      temp('info', "Logged in as $u->id");
      redirect('admin_home.php');
    }

    $_errors['id'] = ' '; // This serves no functional purpose other than to force autofocus to focus on id (bc it selects the first input that is a sibling of .error). The value has to be ' ' (a space), not '' (empty string), because an empty string evaluates to false, so the error() function always executed the else block, which prints a <span> without a class. Somehow an empty string produces a <span> with no class. 
    $_errors['password'] = 'Wrong id or password';
  }
}
?>
<?php
$stylesheetArray = ['../user/user.css', '/css/admin_login.css', '/css/password.css'];   // 注意：这边只放特定于此页面的 .css file(s)。所有 admin 页面都会用到的 .css files 应放在 /css/admin.css
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/svg+xml" href="/assets/img/shuttlecock.svg">
  <?= link_stylesheet($stylesheetArray ?? ''); ?>
  <!-- <?= link_stylesheet($stylesheetArray ?? ''); ?> -->
  <title>Admin Login</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <style>
    /* Center the loader */
    #loader {
      position: absolute;
      left: 50%;
      top: 50%;
      z-index: 1;
      width: 120px;
      height: 120px;
      margin: 100px 0 0 -76px;
      border: 16px solid #f3f3f3;
      border-radius: 50%;
      border-top: 16px solid hsl(206 100% 25%);
      ;
      -webkit-animation: spin 2s linear infinite;
      animation: spin 2s linear infinite;
    }

    @-webkit-keyframes spin {
      0% {
        -webkit-transform: rotate(0deg);
      }

      100% {
        -webkit-transform: rotate(360deg);
      }
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    /* Add animation to "page content" */
    .animate-bottom {
      position: relative;
      -webkit-animation-name: animatebottom;
      -webkit-animation-duration: 1s;
      animation-name: animatebottom;
      animation-duration: 1s
    }

    @-webkit-keyframes animatebottom {
      from {
        bottom: -100px;
        opacity: 0
      }

      to {
        bottom: 0px;
        opacity: 1
      }
    }

    @keyframes animatebottom {
      from {
        bottom: -100px;
        opacity: 0
      }

      to {
        bottom: 0;
        opacity: 1
      }
    }

    #myDiv {
      display: none;
      text-align: center;
    }
  </style>
</head>


<body onload="myFunction()" style="margin:0;">

  <div id="loader"></div>

  <div style="display:none;" id="myDiv" class="animate-bottom">
    <div id="info">
      <div id="progress-bar"></div>
      <span id="info-text"><?= temp('info') ?></span>
    </div>

    <div class="container" style="text-align:left;">
      <h2 class="store-name">Admin Login</h2>
      <h1 class="welcome">Welcome</h1>
      <div class="instruction">Please login to your account</div>

      <form class="form" method="post">
        <div class="form-item">
          <label for="id">Admin ID</label>
          <br>
          <?php input_text('id') ?>
          <?php error("id"); ?>
        </div>

        <div class="form-item">
          <label for="password">Password</label>
          <br>
          <div class="password-input-box">
            <?php input_password('password') ?>
            <img class="visibility-toggle-icon" src="../../assets/img/visibility-off.svg" alt="Visibility toggle icon" />
          </div>
          <?php error("password"); ?>
        </div>
        <!-- <a href="#" class="forgot-pw">Forgot password?</a> -->
        <button class="button" type="submit">Login</button>
      </form>


    </div>

  </div>



</body>
<script src="../user/user.js"></script>
<script src="/js/password.js"></script>

<script>
  var myVar;

  function myFunction() {
    myVar = setTimeout(showPage, 1000);
  }

  function showPage() {
    document.getElementById("loader").style.display = "none";
    document.getElementById("myDiv").style.display = "block";
  }
</script>

</html>