<?php 
date_default_timezone_set('Asia/Kuala_Lumpur');
session_start();
function req($key, $value=null){
    $value=$_REQUEST[$key]??$value;
    return is_array($value)?array_map('trim',$value):trim($value);

}

function isGet() {
    return $_SERVER['REQUEST_METHOD'] == 'GET';
}


function isPost() {
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

$_invalid=[];

function invalid($key){
    global $_invalid;
    if($_invalid[$key]??false){
        echo "<span class='invalid'>$_invalid[key]</span>";

    }
    else{
        echo '<span></span>';
    }



}





?>