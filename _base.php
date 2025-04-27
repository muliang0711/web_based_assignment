<?php


// ============================================================================
// PHP setup
// ============================================================================

date_default_timezone_set('Asia/Kuala_Lumpur');
session_start();

$time = time(); //get current time to append to file address

// Dynamically add stylesheet links to a page
function link_stylesheet($stylesheetArray) {
    global $time;
    
    if (!$stylesheetArray) {
        return;
    }

    if (is_array($stylesheetArray)) {
        foreach ($stylesheetArray as $stylesheet) {
            
            echo "<link rel='stylesheet' href='$stylesheet?v=$time' />";
        }
    } 
}

// Dynamically embed scripts into a page
function link_script($scriptArray) {
    global $time;
    if (!$scriptArray) {
        return;
    }
    
    if (is_array($scriptArray)) {
        foreach ($scriptArray as $script) {
            echo "<script src='$script?v=$time'></script>";
        }
    }
}


// ============================================================================
// General Page Functions
// ============================================================================

// Is GET request?
function is_get() {
    return $_SERVER['REQUEST_METHOD'] == 'GET';
}

// Is POST request?
function is_post() {
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

// Obtain GET parameter
function get($key, $value = null) {
    $value = $_GET[$key] ?? $value;
    return is_array($value) ? array_map('trim', $value) : trim($value);
}

// Obtain POST parameter
function post($key, $value = null) {
    $value = $_POST[$key] ?? $value;
    return is_array($value) ? array_map('trim', $value) : trim($value);
}

// Obtain REQUEST (GET and POST) parameters
//      Note: POST parameters will override GET parameters with the same name.
function req($key, $value=null){
    $value = $_REQUEST[$key] ?? $value;
    return is_array($value) ? array_map('trim',$value) : trim($value);
}

// Redirect to URL
function redirect($url = null) {
    $url ??= $_SERVER['REQUEST_URI'];
    header("Location: $url");
    exit();
}

// Obtain uploaded file --> cast to object
function get_file($key) {
    $f = $_FILES[$key] ?? null;
    
    if ($f && $f['error'] == 0) {
        return (object)$f;
    }

    return null;
}

// // Crop, resize and save photo
function save_photo($f, $folder, $width = 200, $height = 200) {
    $photo = uniqid() . '.jpg';
    
    require_once 'lib/SimpleImage.php';
    $img = new SimpleImage();
    $img->fromFile($f->tmp_name)
        ->thumbnail($width, $height)
        ->toFile("$folder/$photo", 'image/jpeg');

    return $photo;
}

// Is email?
function is_email($value) {
    return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
}

// Is username valid?
function is_valid_username($username, &$errorStr) {
    $usernameRegex = '/^[a-zA-Z0-9](?!.*\.\.)[\w._]{1,28}[a-zA-Z0-9]$/';
    
    if (!preg_match($usernameRegex, $username)) {
        $errorStr = 'Invalid format!';
        if (strlen($username) < 3 || strlen($username) > 30) {
            $errorStr .= "<br> - Username must be between 3 and 30 characters.";
        }
        if (preg_match('/^[^a-zA-Z0-9]|[^a-zA-Z0-9]$/', $username)) {
            $errorStr .= "<br> - Username must begin and end with letters or digits.";
        }
        if (preg_match('/[^\w_.]/', $username)) {
            $errorStr .= "<br> - Username must only contain letters, digits, dots (.) or underscores (_).";
        }
        if (preg_match('/\.\./', $username)) {
            $errorStr .= "<br> - Consecutive dots (e.g. ..) are not allowed.";
        } 
        return false;
    }
    
    return true;
}

// Is password strong enough?
function is_strong_password($password) {
    $hasLength = strlen($password) >= 8;
    $hasUpper = preg_match('/[A-Z]/', $password);
    $hasLower = preg_match('/[a-z]/', $password);
    $hasSpecial = preg_match('/[\W_]/', $password); // non-word characters (includes _)

    return $hasLength && $hasUpper && $hasLower && $hasSpecial;
}

// Return local root path
function root($path = '') {
    return "$_SERVER[DOCUMENT_ROOT]/$path";
}

// Return base url (host + port) e.g. "http://localhost:8001/" + $path
function base($path = '') {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
                || $_SERVER['SERVER_PORT'] == 443) ? "https" : "http";

    return "$protocol://$_SERVER[HTTP_HOST]/$path";
}

// ============================================================================
// HTML Helpers
// ============================================================================

// Encode HTML special characters
function encode($value) {
    return htmlentities($value);
}

// Generate <input type='text'>
function input_text($key, $attr = '') {
    $value = encode($GLOBALS[$key] ?? '');
    echo "<input type='text' id='$key' name='$key' value='$value' $attr>";
}

// Generate <textarea type='text'>
function html_textarea($key, $attr = '') {
    $value = encode($GLOBALS[$key] ?? '');
    echo "<textarea id='$key' name='$key' value='$value' $attr>$value</textarea>";
}

// Generate <input type='password'>
function input_password($key, $attr = '') {
    $value = encode($GLOBALS[$key] ?? '');
    echo "<input type='password' id='$key' name='$key' value='$value' $attr>";
}

// Generate <input type='radio'> list
function input_radios($key, $items, $br = false) {
    $value = encode($GLOBALS[$key] ?? '');
    echo '<span>';
    foreach ($items as $id => $text) {
        $state = $id == $value ? 'checked' : '';
        echo "<label><input type='radio' id='{$key}_$id' name='$key' value='$id' $state>$text</label>";
        if ($br) {
            echo '<br>';
        }
    }
    echo '</span>';
}

// Generate <select>
function input_select($key, $items, $default = '- Select One -', $attr = '') {
    $value = encode($GLOBALS[$key] ?? '');
    echo "<select id='$key' name='$key' $attr>";
    if ($default !== null) {
        echo "<option value=''>$default</option>";
    }
    foreach ($items as $id => $text) {
        $state = $id == $value ? 'selected' : '';
        echo "<option value='$id' $state>$text</option>";
    }
    echo '</select>';
}

// Generate <input type='file'>
function html_file($key, $accept = '', $attr = '') {
    echo "<input type='file' id='$key' name='$key' accept='$accept' $attr>";
}



// ============================================================================
// Error handling
// ============================================================================

// global associative array that stores error text for form fields with invalid input
$_errors = []; 

// Generate <span class='error'>
function error($key){
    global $_errors;
    if ($_errors[$key] ?? false) { // if $_errors[$key] is null, jump to else block. The "?? false" part prevents PHP from throwing a warning.
        echo "<span class='error'>$_errors[$key]</span>";
    }
    else {
        echo '<span></span>';
    }
}

function temp($key, $value = null) {
    if ($value !== null) {
        $_SESSION["temp_$key"] = $value;
       
    }
    else {
        $value = $_SESSION["temp_$key"] ?? null;
        unset($_SESSION["temp_$key"]);
        return $value;
    }
}

// ============================================================================
// Email Functions
// ============================================================================

// Demo Accounts:
// --------------
// AACS3173@gmail.com                   npsg gzfd pnio aylm
// BAIT2173.email@gmail.com             ytwo bbon lrvw wclr
// liaw.casual@gmail.com                wtpa kjxr dfcb xkhg
// liawcv1@gmail.com                    obyj shnv prpa kzvj

// Account used for sending password reset emails:
// -----------------------------------------------
// limlh-wm24@student.tarc.edu.my       rtau dhsb orbk ybmm 

// Initialize and return mail object
function get_mail() {
    require_once 'lib/PHPMailer.php';
    require_once 'lib/SMTP.php';

    $m = new PHPMailer(true);
    $m->isSMTP();
    $m->SMTPAuth = true;
    $m->Host = 'smtp.gmail.com';
    $m->Port = 587;
    $m->Username = 'limlh-wm24@student.tarc.edu.my';
    $m->Password = 'rtau dhsb orbk ybmm';
    $m->CharSet = 'utf-8';
    $m->setFrom($m->Username, 'The Shuttle Store');

    return $m;
}


function get_notify_order_body($username, $url, $oid, $cid){
    return "
    <body class='body' style='background-color:#fff;margin:0;padding:0;-webkit-text-size-adjust:none;text-size-adjust:none'>
  <table class='nl-container' width='100%' border='0' cellpadding='0' cellspacing='0' role='presentation' style='mso-table-lspace:0;mso-table-rspace:0;background-color:#fff'>
    <tbody>
      <tr>
        <td>
          <table class='row row-1' align='center' width='100%' border='0' cellpadding='0' cellspacing='0' role='presentation' style='mso-table-lspace:0;mso-table-rspace:0'>
            <tbody>
              <tr>
                <td>
                  <table class='row-content stack' align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='mso-table-lspace:0;mso-table-rspace:0;border-radius:0;color:#000;width:900px;margin:0 auto' width='900'>
                    <tbody>
                      <tr>
                        <td class='column column-1' width='16.666666666666668%' style='mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;vertical-align:top'>
                          <div class='spacer_block block-1 mobile_hide' style='height:25px;line-height:25px;font-size:1px'>&#8202;</div>
                        </td>
                        <td class='column column-2' width='83.33333333333333%' style='mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;vertical-align:top'>
                          <table class='image_block block-1' width='100%' border='0' cellpadding='0' cellspacing='0' role='presentation' style='mso-table-lspace:0;mso-table-rspace:0'>
                            <tr>
                              <td class='pad' style='width:100%'>
                                <div class='alignment' align='left'>
                                  <div style='max-width:180px'>
                                    <img src='cid:$cid' style='display:block;height:auto;border:0' width='180' height='auto'>
                                  </div>
                                </div>
                              </td>
                            </tr>
                          </table>
                          <table class='text_block block-2' width='100%' border='0' cellpadding='0' cellspacing='0' role='presentation' style='mso-table-lspace:0;mso-table-rspace:0;word-break:break-word'>
                            <tr>
                              <td class='pad' style='padding-top:40px'>
                                <div style='font-family:sans-serif'>
                                  <div style='font-size:14px;font-family:Roboto,Tahoma,Verdana,Segoe,sans-serif;mso-line-height-alt:16.8px;color:#0068a5;line-height:1.2'>
                                    <p style='margin:0;font-size:14px;mso-line-height-alt:16.8px'>
                                      <strong><span style='word-break: break-word; font-size: 26px;'>Order #$oid</span></strong>
                                    </p>
                                  </div>
                                </div>
                              </td>
                            </tr>
                          </table>
                          <table class='divider_block block-3' width='100%' border='0' cellpadding='0' cellspacing='0' role='presentation' style='mso-table-lspace:0;mso-table-rspace:0'>
                            <tr>
                              <td class='pad' style='padding-bottom:45px;padding-top:45px'>
                                <div class='alignment' align='left'>
                                  <table border='0' cellpadding='0' cellspacing='0' role='presentation' width='85%' style='mso-table-lspace:0;mso-table-rspace:0'>
                                    <tr>
                                      <td class='divider_inner' style='font-size:1px;line-height:1px;border-top:2px solid #0068a5'>
                                        <span style='word-break: break-word;'>&#8202;</span>
                                      </td>
                                    </tr>
                                  </table>
                                </div>
                              </td>
                            </tr>
                          </table>
                          <table class='text_block block-4' width='100%' border='0' cellpadding='0' cellspacing='0' role='presentation' style='mso-table-lspace:0;mso-table-rspace:0;word-break:break-word'>
                            <tr>
                              <td class='pad'>
                                <div style='font-family:sans-serif'>
                                  <div style='font-size:14px;font-family:Roboto,Tahoma,Verdana,Segoe,sans-serif;mso-line-height-alt:16.8px;color:#0068a5;line-height:1.2'>
                                    <p style='margin:0;font-size:14px;mso-line-height-alt:16.8px'>
                                      <strong><span style='word-break: break-word; font-size: 26px;'>$username,</span></strong>
                                    </p>
                                  </div>
                                </div>
                              </td>
                            </tr>
                          </table>
                          <table class='text_block block-5' width='100%' border='0' cellpadding='0' cellspacing='0' role='presentation' style='mso-table-lspace:0;mso-table-rspace:0;word-break:break-word'>
                            <tr>
                              <td class='pad' style='padding-bottom:10px;padding-top:10px'>
                                <div style='font-family:sans-serif'>
                                  <div style='font-size:14px;font-family:Roboto,Tahoma,Verdana,Segoe,sans-serif;mso-line-height-alt:16.8px;color:#0068a5;line-height:1.2'>
                                    <p style='margin:0;font-size:14px;mso-line-height-alt:16.8px'>
                                      <span style='word-break: break-word; font-size: 16px;'>We're glad to announce that your order is a step closer to you! 🥳</span>
                                    </p>
                                  </div>
                                </div>
                              </td>
                            </tr>
                          </table>
                          <table class='button_block block-6' width='100%' border='0' cellpadding='0' cellspacing='0' role='presentation' style='mso-table-lspace:0;mso-table-rspace:0'>
                            <tr>
                              <td class='pad' style='padding-bottom:30px;padding-top:30px;text-align:left'>
                                <div class='alignment' align='left'>
                                  <a href='$url' target='_blank' style='color:#ffffff;text-decoration:none;'>
                                    <span class='button' style='background-color: #0084ff; border-bottom: 0px solid transparent; border-left: 0px solid transparent; border-radius: 4px; border-right: 0px solid transparent; border-top: 0px solid transparent; color: #ffffff; display: inline-block; font-family: Roboto, Tahoma, Verdana, Segoe, sans-serif; font-size: 16px; font-weight: 400; mso-border-alt: none; padding-bottom: 10px; padding-top: 10px; padding-left: 55px; padding-right: 55px; text-align: center; width: auto; word-break: keep-all; letter-spacing: normal;'>
                                      <span style='word-break: break-word; line-height: 32px;'>View Order</span>
                                    </span>
                                  </a>
                                </div>
                              </td>
                            </tr>
                          </table>
                          <table class='divider_block block-7' width='100%' border='0' cellpadding='0' cellspacing='0' role='presentation' style='mso-table-lspace:0;mso-table-rspace:0'>
                            <tr>
                              <td class='pad' style='padding-bottom:45px;padding-top:45px'>
                                <div class='alignment' align='left'>
                                  <table border='0' cellpadding='0' cellspacing='0' role='presentation' width='85%' style='mso-table-lspace:0;mso-table-rspace:0'>
                                    <tr>
                                      <td class='divider_inner' style='font-size:1px;line-height:1px;border-top:2px solid #0068a5'>
                                        <span style='word-break: break-word;'>&#8202;</span>
                                      </td>
                                    </tr>
                                  </table>
                                </div>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
</body>
";
}


function get_reset_pw_email_body($username, $email, $home_url, $reset_pw_url) {
    return "
            <body style='background-color: #fff; font-family: sans-serif; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; width: 100%; box-sizing: border-box;'>
  <div class='container' style='display: block; margin: 0 auto !important; max-width: 580px; padding: 50px; width: 100%; box-sizing: border-box;'>
    
    <header style='margin-bottom: 30px; box-sizing: border-box;'>
      <a href='$home_url' style='box-sizing: border-box;'>
        <img class='logo' alt='The Shuttle Store' src='cid:logo' style='border: none; width: 100%; max-width: 100px; box-sizing: border-box;'>
      </a>
    </header>

    <main style='box-sizing: border-box;'>
      <p style='color: initial; font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px; box-sizing: border-box;'>
        Hello, <b>$username</b>!
      </p>

      <p style='color: initial; font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px; box-sizing: border-box;'>
        You requested to reset the password for your account with the e-mail address 
        <a href='mailto:$email' style='color: rgb(47, 96, 255); text-decoration: underline; box-sizing: border-box;'>$email</a>.
      </p>

      <p style='color: initial; font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px; box-sizing: border-box;'>
        Please click the link below to reset your password.
      </p>

      <p style='color: initial; font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px; box-sizing: border-box;'>
        Note that this link will <b>expire in 5 minutes.</b>
      </p>

      <p style='color: initial; font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px; box-sizing: border-box;'>
        <a class='btn-rounded' href='$reset_pw_url' style='display: inline-block; border: 0; border-radius: 20px; background-color: rgb(47, 96, 255) !important; opacity: 1; color: white; text-decoration: none; cursor: pointer; padding: 10px 20px; transition: all 0.3s; box-sizing: border-box;'>
          Reset password
        </a>
      </p>

      <p style='color: initial; font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px; box-sizing: border-box;'>
        Best regards,<br>The Shuttle Store
      </p>
    </main>

    <footer style='margin-top: 30px; box-sizing: border-box;'>
      <small style='opacity: 0.5; box-sizing: border-box;'>
        If you did not request a password reset, please feel free to ignore this message.
      </small>
    </footer>

  </div>
</body>

        ";
}

function get_verify_email_body($username, $email, $home_url, $verify_email_url) {
    return "
            <body style='background-color: #fff; font-family: sans-serif; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; width: 100%; box-sizing: border-box;'>
  <div class='container' style='display: block; margin: 0 auto !important; max-width: 580px; padding: 50px; width: 100%; box-sizing: border-box;'>
    
    <header style='margin-bottom: 30px; box-sizing: border-box;'>
      <a href='$home_url' style='box-sizing: border-box;'>
        <img class='logo' alt='The Shuttle Store' src='cid:logo' style='border: none; width: 100%; max-width: 100px; box-sizing: border-box;'>
      </a>
    </header>

    <main style='box-sizing: border-box;'>
      <p style='color: initial; font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px; box-sizing: border-box;'>
        Hello, <b>$username</b>!
      </p>

      <p style='color: initial; font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px; box-sizing: border-box;'>
        Click on the link below to verify your email (
        <a href='mailto:$email' style='color: rgb(47, 96, 255); text-decoration: underline; box-sizing: border-box;'>$email</a>).
      </p>

      <p style='color: initial; font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px; box-sizing: border-box;'>
        Note that this link will <b>expire in 5 minutes.</b>
      </p>

      <p style='color: initial; font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px; box-sizing: border-box;'>
        <a class='btn-rounded' href='$verify_email_url' style='display: inline-block; border: 0; border-radius: 20px; background-color: rgb(47, 96, 255) !important; opacity: 1; color: white; text-decoration: none; cursor: pointer; padding: 10px 20px; transition: all 0.3s; box-sizing: border-box;'>
          Verify email
        </a>
      </p>

      <p style='color: initial; font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px; box-sizing: border-box;'>
        Best regards,<br>The Shuttle Store
      </p>
    </main>

    <footer style='margin-top: 30px; box-sizing: border-box;'>
      <small style='opacity: 0.5; box-sizing: border-box;'>
        If you did not request a password reset, please feel free to ignore this message.
      </small>
    </footer>

  </div>
</body>

        ";
}

// ============================================================================
// Database Setups and Functions
// ============================================================================

// Initialize database connection
try {
    // Global PDO object
    $_db = new PDO('mysql:dbname=web_based_assignment;host=localhost;port=3306', 'root', '', [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, // Fetch records as objects by default
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  // Enable error reporting
    ]);
} 
catch (PDOException $e) {
    // Handle connection error
    die("Database error: " . $e->getMessage());  
}

// Is unique?
function is_unique($value, $table, $field) {
    global $_db;
    $stm = $_db->prepare("SELECT COUNT(*) FROM $table WHERE $field = :value");
    $stm->execute([':value' => $value]);
    return $stm->fetchColumn() == 0;
}

// Does it already exist in database?
function exists_in_db($value, $table, $field) {
    global $_db;
    $select_stm = $_db->prepare("SELECT COUNT(*) FROM $table WHERE $field = :value");
    $select_stm->execute([':value' => $value]);
    return $select_stm->fetchColumn() > 0;
}

/** Like is_unique() but specifically for `user` fields, and it *excludes deleted accounts* (`user` records with `isDeleted` = 1) from the uniqueness check.
 */ 
function is_unique_excl_del($value, $field) {
    global $_db;
    $select_stm = $_db->prepare("SELECT COUNT(*) FROM user WHERE $field = :value AND isDeleted = 0");
    $select_stm->execute(['value' => $value]);
    return $select_stm->fetchColumn() == 0;
}

// ============================================================================
// Authentication functions
// ============================================================================

/**
 * Ensures that $role is either "user" or "admin". Throws an error if not.
 * @param mixed $role Can only be "user" or "admin"
 * @throws \InvalidArgumentException
 * @return void
 */
function validateRole($role): void {
    if ($role !== "admin" && $role !== "user") {
        throw new InvalidArgumentException("Invalid role: $role. Allowed values: 'admin' or 'user'.");
    }
}

/**
 * Log in with a user/admin id retrieved from database
 * @param mixed $userOrAdminID A user id or an admin id retrieved from database
 * @param string $role This value can only be "user" or "admin".
 * @return void
 */
function login($userOrAdminID, $role) {
    validateRole($role);

    // Create a session variable to store all user/admin data
    $role === "user" ? $_SESSION['userID'] = $userOrAdminID : $_SESSION['adminID'] = $userOrAdminID;
}

// Log out 
function logout($role) {
    validateRole($role);

    if ($role == 'user') {
        // Delete `remember_me` cookie (if it doesn't exist, this line does nothing)
        setcookie('remember_me', '', time() - 3600, '/');

        // Delete all `remember-user`-type tokens for the user from DB
        global $_db;
        $stmt = $_db->prepare("DELETE FROM token WHERE type = 'remember-user' AND userID = :userID");
        $stmt->execute(['userID' => $_SESSION['userID']]);

        unset($_SESSION['userID']);
    }
    else if ($role == 'admin') {
        unset($_SESSION['adminID']);
    }

    // Destroy the session completely (CANNOT do this because we dont want to log out the admin too when a user logs out, or vice versa)
    // session_destroy();
}

// global user object
$_user;

// global admin object
$_admin;

// If userID session variable is set OR if there is a valid remember_me cookie, fetch user data to $_user.
if (is_logged_in("user") || verify_remember_me_cookie()) {
    global $_db;
    global $_user;
    // Reminder: userID is a NUMBER, therefore does not require single quotes
    $_user = $_db->query("SELECT * FROM user WHERE userID = {$_SESSION['userID']}")->fetch();
}
// else {
//     // If $_SESSION['userID'] isn't set, check if a `remember_me` cookie is stored on the browser, and verify it.
//     // If the cookie exists and is valid, log user in (setting the userID session variable).
//     verify_remember_me_cookie();
// }

// If is logged in, fetch admin object to a global variable
if (is_logged_in("admin")) {
    global $_db;
    global $_admin;
    // Reminder: admin's id column is a VARCHAR, therefore requires single quotes
    $_admin = $_db->query("SELECT * FROM `admin` WHERE id = '{$_SESSION['adminID']}'")->fetch();
}


/** Verify a user's `remember_me` cookie against the `remember-user`-type `token` saved in DB.
 * <br>If valid, logs user in, and returns `true`.
 * <br>If invalid, clears the `remember_me` cookie, and returns `false`.
 * <br>Only works for customers, not admins
 * IMPORTANT: This is one-time use only. Use once before any output of HTML content.
 */
function verify_remember_me_cookie() {
    if (!isset($_COOKIE['remember_me'])) {
        // No remember_me cookie is set
        return false;
    }

    // Get selector and validator (not hashed) from saved cookie
    list($selector, $validator) = explode(':', $_COOKIE['remember_me']);
    // var_dump($_COOKIE);
    // var_dump($_COOKIE['remember_me']);
    // var_dump($selector);
    // var_dump($validator);

    // Get remember-me token from DB with selector from cookie
    global $_db;
    $stmt = $_db->prepare("SELECT * FROM token WHERE `type` = 'remember-user' AND selector = :selector AND expire >= NOW()");
    $stmt->execute(['selector' => $selector]);
    $token = $stmt->fetch();
    // echo '$token: ';
    // var_dump($token);

    if ($token && hash_equals($token->hashedValidator, hash('sha256', $validator))) {
        // echo "token is valid!";

        // Token is valid: Set userID session variable.
        login($token->userID, 'user');

        // Rotate token (for improved security)
        $new_selector = bin2hex(random_bytes(6));
        $new_validator = bin2hex(random_bytes(32));
        $new_hashed = hash('sha256', $new_validator);
        $new_expires = date('Y-m-d H:i:s', time() + 60 * 60 * 24 * 30);

        // Store new one
        $stmt = $_db->prepare("INSERT INTO token (userID, selector, hashedValidator, expire, `type`)
                                        VALUES (:userID, :selector, :hashedValidator, :expire, 'remember-user')");
        $stmt->execute([
            'userID' => $token->userID,
            'selector' => $new_selector,
            'hashedValidator' => $new_hashed,
            'expire' => $new_expires,
        ]);

        // Delete old one
        $stmt = $_db->prepare("DELETE FROM token WHERE type = 'remember-user' AND selector = :selector");
        $stmt->execute(['selector' => $selector]);

        // var_dump($new_selector);
        // var_dump($new_hashed);

        // Set new cookie
        setcookie(
            'remember_me',
            "$new_selector:$new_validator",
            time() + 60 * 60 * 24 * 30,
            '/',  // allows use of this cookie on the entire domain
            '',
            false,  // true is for HTTPS only, but this project uses HTTP
            true  // HttpOnly: JS can't touch it
        );

        return true;
    } else {
        // echo "cookie invalid somehow :(";
        // Invalid or tampered token. Clear it
        setcookie('remember_me', '', time() - 3600, '/');
        
        return false;
    }
}

/**
 * Check if a user(customer) / admin is logged in. 
 * <br>If $role = "user", $adminLevel is ignored and this function returns true if a user (customer) is logged in.
 * <br>If $role = "admin", $adminLevel = null, this function returns true if an admin (of any level) is logged in.
 * <br>If $role = "admin", $adminLevel != null, this function returns true if an admin of the specified level is logged in. Throws an error if the specified $adminLevel is invalid.
 * @param string $role This value can only be "user" or "admin".
 * @param string $adminLevel If $role is "user", this parameter is ignored. If $role is "admin", this parameter can only be "main" or "staff".
 * @return bool
 * @throws \InvalidArgumentException
 */
function is_logged_in($role, $adminLevel = null): bool {
    validateRole($role);

    // Is logged in as customer?
    if ($role == "user" ) {
        // if (isset($_COOKIE['remember_me'])) {
        //     return verify_remember_me_cookie(); // If user has a valid `remember_me` cookie, this function will log user in, and return true. Else, this function clears the invalid cookie and returns false.
        // }
        return isset($_SESSION['userID']);
    }
    // Is logged in as admin?
    else if ($role == "admin") {
        // No adminID session variable set? Not logged in as an admin.
        if (!isset($_SESSION['adminID'])) {
            return false;
        }

        // If no adminLevel is specified, just return true as an admin (of any type) must be logged in at this point
        if (!$adminLevel) {
            return true;
        }
    
        // Is the currently logged in admin a $adminLevel admin?
        // 1. Get the enum set of `admin`.`adminLevel` as an array.
        global $_db;
        $levelsEnum = $_db->query('
            SELECT COLUMN_TYPE 
            FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_NAME = "admin" 
            AND COLUMN_NAME = "adminLevel";
        ')->fetchColumn();
        
        $levelsArr = [];
        if ($levelsEnum) {
            // Find strings that match the pattern, and store matched text in $matches.
            //   $matches[0] contains text that matched the full pattern, and $matches[1] contains text that matched the first captured parenthesized subpattern, and so on.
            //   In this case, $matches[1] will contain text inside the parentheses of "enum( ... )", e.g. "'main', 'staff'".
            preg_match("/^enum\((.*)\)$/", $levelsEnum, $matches);
            // var_dump($matches);
    
            if (isset($matches[1])) {
                // Convert the string ("'item1', 'item2'") into an array (['item1', 'item2']);
                $levelsArr = str_getcsv($matches[1], ",", "'");
            }
            // var_dump($levels);
        }
    
        // 2. Throw error if specified $adminLevel is not a valid adminLevel value.
        global $_admin;
        if (!in_array($adminLevel, $levelsArr)) {
            throw new InvalidArgumentException("Invalid adminLevel value passed in the function `is_logged_in(\"admin\", \"$adminLevel\")`. According to the database, valid values are: " . json_encode($levelsArr) . ".");
        }
        
        // 3. Is the currently logged in admin a $adminLevel admin?
        return $_admin->adminLevel == $adminLevel;
    }
    // The specified $role is not user nor admin. Just return false. 
    else {
        return false;
    }
}

/** Check if a user has verified their email
 *
 */ 
function is_email_verified() {
    if (!is_logged_in('user')) return;

    global $_user;
    global $_db;

    $stm = $_db->query("SELECT emailVerified FROM user WHERE userID = {$_user->userID}");
    $is_email_verified = $stm->fetchColumn();
    return $is_email_verified == 1;
}

// Testing the is_logged_in() function
// var_dump(is_logged_in("user", "main"));

/** Checks if a user(customer) / admin is blocked given their ID.
 * <br>Example usage:
 * <br>- `is_blocked("admin", $_admin->id)` checks if the currently logged in admin has been blocked.
 * <br>- `is_blocked("admin", $someID)` checks if the admin with `id = $someID` has been blocked.
 */
function is_blocked($role, $userOrAdminID): bool {
    validateRole($role);

    global $_db;
    if ($role == 'user') {
        $stm = $_db->prepare("SELECT memberStatus FROM user WHERE userID = :userID");
        $stm->execute(['userID' => $userOrAdminID]);
    }
    else if ($role == 'admin') {
        $stm = $_db->prepare("SELECT `status` FROM `admin` WHERE id = :id");
        $stm->execute(['id' => $userOrAdminID]);
    }
    $status = $stm->fetchColumn();
    return $status == 'Blocked';
}

/** Log out and redirect to a page for request unblock if currently logged in user has been blocked
 *
 */
function logout_and_redirect_if_blocked() {
    global $_user;
    if (!$_user) {
        return;
    }
    if (is_blocked("user", $_user->userID)) {
        logout("user");
        temp('warn', 'You have been blocked.');
        redirect("/pages/user/userRequestUnblock.php?userID={$_user->userID}");
    }
}
function admin_if_blocked() {
    global $_admin;
    if (!$_admin) {
        return;
    }
    if (is_blocked("admin", $_admin->id)) {
        logout("admin");
        redirect('/pages/admin/adminRequestUnblock.php');
    }
}
//password hashing
function pwHash($pw){
    return password_hash($pw, PASSWORD_DEFAULT);
}


//password matching
function pwMatch($pw, $hashedpw){
    return password_verify($pw, $hashedpw);
}

// Authenticate user / admin
// If auth("user"), redirect to user login page if not logged in as user.
// If auth("admin"), redirect to admin login page if not logged in as admin.
// If auth("admin", "main"), redirect to admin HOME page if not logged in as a main admin (even if logged in as staff admin).
function auth($role, $adminLevel = null) {
    // If authenticating user, redirect to user login page if not logged in as user.
    if ($role == "user" && !is_logged_in("user")) {
        temp('warn', 'You must log in first!');
        temp('fromPage', $_SERVER['REQUEST_URI']); // this ensures that after user logs in, they'll be redirected back to the page where they came from. 
        redirect('/pages/user/user-login.php');
    }

    if ($role == "admin") {
        // If authenticating admin, redirect to admin login page if not logged in as admin.
        if (!is_logged_in("admin")) {
            temp('info', "You must log in first!");
            redirect('/pages/admin/admin_login.php');
        }

        // Okay, an admin is logged in. 
        // If $adminLevel is specified and the logged in admin is NOT that specified level, redirect to admin HOME page. Otherwise, do nothing.
        if ($adminLevel && !is_logged_in("admin", $adminLevel)) {
            temp('info', "This page is only restricted to $adminLevel admins.");
            redirect('/pages/admin/admin_home.php');
        }
    }

    // Do nothing if $role is neither user nor admin.
}


function adminMain($adminLevel = "main") {


}

function admin_is_level($adminLevel) {
    global $_admin;
    // Return void if $_admin is undefined (which means no admin is logged in)
    if (!$_admin) {
        return;
    }
    // If an admin is logged in, return true if the currently logged in admin is of the specified adminLevel; otherwise return false.
    return $_admin->adminLevel == $adminLevel;
}



// TODO (low-priority, might as well just leave this as is)
// Generate login prompt with a link to user login page
function prompt_user_login($customPrompt = null) {
    $customPrompt ??= 'You are not logged in.';
    $customPrompt .= ' <a href="/pages/user/user-login.php?fromPage=' . urlencode($_SERVER['REQUEST_URI']) . '">Log in</a>';
    temp('warn', $customPrompt);
}


// Generate <input type='search'>
function html_search($key, $placeholder = 'Search...', $style = '') {
    $value = htmlentities($_GET[$key] ?? '', ENT_QUOTES, 'UTF-8');
    return "<input 
                type='text' 
                name='$key' 
                value='$value' 
                placeholder='$placeholder' 
                style='$style'>";
}


// Generate <select>
function html_select($key, $items, $default = '- Select One -', $attr = '') {
    $value = encode(is_array($GLOBALS[$key] ?? '') ? ($GLOBALS[$key][0] ?? '') : ($GLOBALS[$key] ?? ''));

    echo "<select id='$key' name='$key' $attr>";
    if ($default !== null) {
        echo "<option value=''>$default</option>";
    }
    foreach ($items as $id => $text) {
        $state = $id == $value ? 'selected' : '';
        echo "<option value='$id' $state>$text</option>";
    }
    echo '</select>';
}

function sorting($fields, $sort, $dir, $href = '') {
    foreach ($fields as $k => $v) {
        $d = 'asc'; 
        $c = '';    // default no css

        if ($k == $sort) {
            $d = ($dir == 'asc') ? 'desc' : 'asc'; 
            $c = $dir; }
        // 生成排序url，保留原 URL parameter
        $queryString = http_build_query(array_merge($_GET, ['sort' => $k, 'dir' => $d]));

        echo "<th><a href='?$queryString' class='$c'>$v</a></th>";
    }
}