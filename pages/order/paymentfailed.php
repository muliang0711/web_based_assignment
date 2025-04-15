<?php 
   
    require "../../_base.php";
    $title = 'Payment Unsuccessful';
    $time = time();
    $stylesheetArray  = ["success.css?"];



    if(!isset($_SESSION['tempOrder'])){
        redirect("/");
    }

    unset($_SESSION['tempOrder']);
    unset($_SESSION["vcrcode"]);




    include "../../_head.php";
?>


<div class="container" style="height:auto;">
    <div class="circle">
    <svg xmlns="http://www.w3.org/2000/svg" height="70px" viewBox="0 -960 960 960" width="70px" fill="rgb(255,255,255)"><path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/></svg>
    </div>
    <h1>Payment Unsuccessful!</h1>

    <div class="buttoncontainer">
        <button onclick="gohome()">Back to Homepage</button>
    </div>

    
</div>
<script>
    function gohome(){
        location = "/";
    }
</script>



<?php 
include '../../_foot.php';
?>