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

// If is logged in, fetch user object to a global variable
if (is_logged_in("user")) {
    global $_db;
    global $_user;
    // Reminder: userID is a NUMBER, therefore does not require single quotes
    $_user = $_db->query("SELECT * FROM user WHERE userID = {$_SESSION['userID']}")->fetch();
}

// If is logged in, fetch admin object to a global variable
if (is_logged_in("admin")) {
    global $_db;
    global $_admin;
    // Reminder: admin's id column is a VARCHAR, therefore requires single quotes
    $_admin = $_db->query("SELECT * FROM `admin` WHERE id = '{$_SESSION['adminID']}'")->fetch();
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
        redirect('/pages/user/blocked.php');
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
function html_search($key, $attr = '') {
    $value = encode($GLOBALS[$key] ?? '');
    echo "<input type='search' id='$key' name='$key' value='$value' $attr>";
}

// Generate <select>
function html_select($key, $items, $default = '- Select One -', $attr = '') {
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