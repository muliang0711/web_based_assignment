<?php 
require '../../_base.php';

/********* You can change these to suit the specific needs of your page *********/
$title = 'Profile';
$stylesheetArray = ['profile.css','address.css']; // Put CSS files that are specific to this page here. If you want to change the styling of the header and the footer, go to /css/app.cs
$scriptArray = [];      // Put JS files that are specific to this page here. If you want to change the JavaScript for the header and the footer, go to /js/app.js

include '../../_login_guard.php';
extract((array)$_user);
$userID = $_user->userID;
$states = [
    "Kuala Lumpur",
    "Putrajaya",
    "Selangor",
    "Johor",
    "Kedah",
    "Kelantan",
    "Melaka",
    "Negeri Sembilan",
    "Pahang",
    "Perak",
    "Perlis",
    "Penang",
    "Sabah",
    "Sarawak",
    "Terengganu",
    "Labuan" 
];


if(is_get()){

    if(isset($_GET["edit"])){
        $indexToEdit = $_GET["edit"];
        //check if index belongs to user
        try{
            $stm = $_db->prepare("SELECT addressIndex from savedaddress WHERE userID = ?");
            $stm->execute([$userID]);
            $indexArr = $stm->fetchAll(PDO::FETCH_COLUMN);
        }catch(PDOException){
            redirect("address.php");
        }
        
    
        if(!in_array($indexToEdit, $indexArr)){
            redirect("address.php");
        }

        //fetch the card information from db
        $stm = $_db->prepare("SELECT * from savedaddress WHERE userID = ? AND addressIndex = ?");
        $stm->execute([$userID, $indexToEdit]);
        $info = $stm->fetchAll();

        $name = $info[0]->name;
        $address = $info[0]->address;
        $number = $info[0]->phoneNo;
        $default = $info[0]->defaultAdd;


        $address = explode(",",$address);
        $building = $address[0];
        $street = trim($address[1]);
        $state = trim($address[3]);
        $postcode = trim($address[2]);

    }
    
}


if(is_post()){
    $indexToEdit = $_GET["edit"];

    $name = $_POST["name"];
    $number = $_POST["number"];
    $unit = trim($_POST["building"]);
    $street = trim($_POST["street"]);
    $state = trim($_POST["states"]);
    $postcode = trim($_POST["postcode"]);
    $address = $unit . ", " . $street . ", " . $postcode . ", " . $state;
    $default = isset($_POST["default"]) ? $_POST["default"] : 0;

    //update the address in database and go back to saved address page



    if(isset($_POST["default"])){
        $_db->query("UPDATE savedaddress set defaultAdd = 0 WHERE userID = $userID");
    }

    $stm = $_db->prepare("UPDATE savedaddress SET address = ? , phoneNo = ? , name = ?, defaultAdd = ? WHERE userID = ? AND addressIndex = ?");
    $stm->execute([$address, $number, $name, $default ,$userID, $indexToEdit]);

    redirect("address.php");
}


include '../../_head.php';

include 'profile_dynamic_navbar.php';
?>

<div class="main">

<section class="info-boxes">
        <div role="alert" class="info-box success"><?= temp('info') ?></div>
        <div role="alert" class="info-box error"><?= temp('error') ?></div>
</section>
<h1 class="heading"><?= $current_title ?></h1>


<div class="section-container">
        <section class="left-col">
                <form method="post" id="addressForm">
                    <div class="form-group">
                        <label>Name</label><br>
                        <?= input_text('name', "placeholder='example: Alex Marc'") ?>
                    </div>

                    <div class="form-group">
                        <label>Phone Number</label><br>
                        <?= input_text('number', "placeholder='example: 60126289399'") ?>
                        <span id="errmsg2" style="color: red; font-size: 15px;" hidden>⚠️ Incorrect Format!</span>
                    </div>

                    <div class="form-group">
                        <label>Unit Number and Building Name</label><br>
                        <?= input_text('building', "placeholder='example: 12 Taman Tarumt'") ?>
                    </div>

                    <div class="form-group">
                        <label>Street Address</label><br>
                        <?= input_text('street',"placeholder='example: Jalan Langkawi'") ?>
                    </div>

                    

                    <div class="form-group">
                        <label>Country</label><br>
                        <input type="text" value="Malaysia" readonly style="width:85px; pointer-events:none">
                    </div>

                    <div class="form-group">
                        <label>State</label><br>
                        <select name="states" id="states" style="width: 160px;">
                                <?php foreach($states as $s): ?>
                                <option value="<?= $s ?>" <?= (isset($state) &&  $s == $state) ? "selected" : "" ?>><?= $s ?></option>
                                <?php endforeach ?>
                        </select>
                        
                    </div>

                    <div class="form-group">
                        <label">Postcode</label><br>
                        <input id="postcode" name="postcode" type="text"style="width:80px;" maxlength="5" value="<?= isset($postcode)?$postcode:"" ?>">
                        <span id="errmsg" style="color: red; font-size: 15px;" hidden>⚠️ Incorrect Postcode!</span>
                    </div>
                    <button class="btn-simple btn-green" id="cancel" style="background-color:rgb(255, 136, 25)">Discard changes</button>                    
                    <button 
                        type="button"
                        id="submit2"
                        class="btn-simple btn-green"
                    >Save changes</button>
                    <input type="checkbox" name="default" value="1" <?= (isset($default) && $default == 1)? "checked":"" ?>><span style="font-size: 13px;">Save as default?</span>
                </form>
        </section>
    </div>


</div>


<script>

    $("button#cancel").on('click', function(e){
        e.preventDefault();
        location = "address.php";
        
    })

    const name = document.getElementById("name");
    const number = document.getElementById("number");
    const street = document.getElementById("street");
    const building = document.getElementById("building");
    const postcode = document.getElementById("postcode");
    const button = document.getElementById("submit2");
    const states = document.getElementById("states");
    const errmsg = document.getElementById("errmsg");
    const errmsg2 = document.getElementById("errmsg2");
    var error = false;
    var error2 = false;
    const postcodes = {
    "Kuala Lumpur": [50000, 60999],
    "Putrajaya": [62000, 62999],
    "Selangor": [40000, 49999],
    "Johor": [79000, 86999],
    "Kedah": [5000, 9810],
    "Kelantan": [15000, 18500],
    "Melaka": [75000, 78300],
    "Negeri Sembilan": [70000, 73500],
    "Pahang": [25000, 28800],
    "Perak": [30000, 36810],
    "Perlis": [1000, 2800],
    "Penang": [10000, 14400],
    "Sabah": [88000, 91309],
    "Sarawak": [93000, 98859],
    "Terengganu": [20000, 24300],
    "Labuan": [87000, 87033]
    };

    name.addEventListener("keypress", function(e){
        if(name.value.length == 30){
            e.preventDefault();
        }

    });


    number.addEventListener("keypress", function(event) {
        if (!/[0-9]/.test(event.key) || (this.value[3]!=1 && this.value.length == 11) || (this.value[3]==1 && this.value.length == 12)) {
            event.preventDefault(); // Stop non-numeric input
        }
    });

    number.addEventListener("input", function(){
        if(this.value.length == 0){
            errmsg2.setAttribute("hidden","true");
            error2 = false;
            return
        }


        if(this.value[0] != 6){
            errmsg2.removeAttribute("hidden");
            error2 = true;
            // errmsg2.setAttribute("hidden","true");
        }
        else{
            if(this.value.length > 1 && this.value[1] != 0){
            errmsg2.removeAttribute("hidden");
            error2 = true;
            }else{

                if(this.value.length > 2 && this.value[2] != 1){
                errmsg2.removeAttribute("hidden");
                error2 = true;
                }else{
                    errmsg2.setAttribute("hidden","true");
                    error2 = false;
                }
                
            }
           
        }
    })

    street.addEventListener("keypress", function(event){
        if (event.key === ",") {
            event.preventDefault(); // Stop non-numeric input
        }
    });

    building.addEventListener("keypress", function(event){
        if (event.key === ",") {
            event.preventDefault(); // Stop non-numeric input
        }
    });
    
    postcode.addEventListener("input", function(){
        let input = this.value;
        let validRange = postcodes[states.value];
        //when user done entering 
        if(input.length==5 || input.length==4){
            verifyPostcode(input,validRange);
        }
        else if(input.length<4){
            errmsg.setAttribute("hidden","true");
        }
        
    });

    postcode.addEventListener("keypress", function(event) {
        if (!/[0-9]/.test(event.key)) {
            event.preventDefault(); // Stop non-numeric input
        }
    });
    
    states.addEventListener("change", function(){
        verifyPostcode(postcode.value, postcodes[this.value]);
    });

    function verifyPostcode(input, validRange){
            if(input<validRange[0] || input>validRange[1]){
                errmsg.removeAttribute("hidden");
                error = true;
            }else{
                errmsg.setAttribute("hidden","true");
                error = false;
            }
    }

    button.addEventListener('click', function(e){
        if(!error && !error2){

            if(name.value.length>0 && street.value.length>0 && building.value.length>0 && postcode.value.length>0 && number.value.length>=11){
                document.getElementById("addressForm").submit();
            }else{
                if(!name.value.length>0){
                    name.style.outline = "2px solid red";
                }else{
                    name.style.outline = "";
                }
                if(!street.value.length>0){
                    street.style.outline = "2px solid red";
                }else{
                    street.style.outline = "";
                }
                if(!building.value.length>0){
                    building.style.outline = "2px solid red";
                }else{
                    building.style.outline = "";
                }
                if(!postcode.value.length>0){
                    postcode.style.outline = "2px solid red";
                }else{
                    postcode.style.outline = "";
                }
                if(number.value.length<11){
                    number.style.outline = "2px solid red";
                }else{
                    number.style.outline = "";
                }
            }
        }
    })
</script>



<?php
include '../../_foot.php';