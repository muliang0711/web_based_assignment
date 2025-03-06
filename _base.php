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

// Generate <input type='password'>
function input_password($key, $attr = '') {
    $value = encode($GLOBALS[$key] ?? '');
    echo "<input type='password' id='$key' name='$key' value='$value' $attr>";
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
