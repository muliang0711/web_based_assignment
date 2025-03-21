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
function logout() {
    // Destroy the session completely
    session_destroy();
}

// Is logged in?
function is_logged_in($role) {
    validateRole($role);
    
    return $role === "user" ? isset($_SESSION['userID']) : isset($_SESSION['adminID']);
}

//password hashing
function pwHash($pw){
    return password_hash($pw, PASSWORD_DEFAULT);
}


//password matching
function pwMatch($pw, $hashedpw){
    return password_verify($pw, $hashedpw);
}

// global user object
$_user;

// global admin object
$_admin;

// If is logged in, fetch user object to a global variable
if (is_logged_in("user")) {
    global $_db;
    global $_user;
    $_user = $_db->query("SELECT * FROM user WHERE userID = {$_SESSION['userID']}")->fetch();
}

// If is logged in, fetch admin object to a global variable
if (is_logged_in("admin")) {
    global $_db;
    global $_admin;
    $_admin = $_db->query("SELECT * FROM `admin` WHERE id = {$_SESSION['adminID']}")->fetch();
}

// TODO
// Generate login prompt using temp()
function prompt_login($customPrompt = null) {
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