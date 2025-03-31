<?php
require '../../_base.php';

/********* You can change these to suit the specific needs of your page *********/
$title = 'Profile';
$stylesheetArray = ['profile.css']; // Put CSS files that are specific to this page here. If you want to change the styling of the header and the footer, go to /css/app.cs
$scriptArray = [];      // Put JS files that are specific to this page here. If you want to change the JavaScript for the header and the footer, go to /js/app.js

include '../../_login_guard.php';

include '../../_head.php';

include 'profile_dynamic_navbar.php';

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


if(is_post()){
    $unit = $_POST["building"];
    $street = $_POST["street"];
    $state = $_POST["states"];
    $userID;

    //add to database
    $stm = $_db->prepare("");
}

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
                        <label>Unit Number and Building Name</label>
                        <?= input_text('building', "placeholder='example: 12, Taman Tarumt'") ?>
                    </div>

                    <div class="form-group">
                        <label>Street Address</label>
                        <?= input_text('street',"placeholder='example: Jalan Langkawi'") ?>
                    </div>

                    

                    <div class="form-group">
                        <label>Country</label>
                        <input type="text" value="Malaysia" readonly style="width:82px; pointer-events:none">
                    </div>

                    <div class="form-group">
                        <label>State</label>
                        <select name="states" id="states" style="width: 160px;">
                                <?php foreach($states as $s): ?>
                                <option value="<?= $s ?>"><?= $s ?></option>
                                <?php endforeach ?>
                        </select>
                        
                    </div>

                    <div class="form-group">
                        <label">Postcode</label><br>
                        <input id="postcode" type="text"style="width:80px;" maxlength="5">
                        <span id="errmsg" style="color: red; font-size: 15px;" hidden>⚠️ Incorrect Postcode!</span>
                    </div>

                    <button 
                        id="submit"
                        type="submit" 
                        class="btn-simple btn-green"
                    >Save address</button>
                </form>
        </section>
    </div>
</div>


<script>
    const street = document.getElementById("street");
    const building = document.getElementById("building");
    const postcode = document.getElementById("postcode");
    const form =document.getElementById("addressForm");
    const button = document.getElementById("submit");
    const states = document.getElementById("states");
    const errmsg = document.getElementById("errmsg");
    var error = false;
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
        e.preventDefault();
        e.stopPropagation();
        if(!error){
            if(street.value.length>0 && building.value.length>0 && postcode.value.length>0){
                form.submit();
            }else{
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
            }
        }
    })
</script>

<?php
include '../../_foot.php';