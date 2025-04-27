<?php
require '../../../_base.php';

/********* You can change these to suit the specific needs of your page *********/
$title = 'Profile';
$stylesheetArray = ['profile.css','address.css']; // Put CSS files that are specific to this page here. If you want to change the styling of the header and the footer, go to /css/app.cs
$scriptArray = [];      // Put JS files that are specific to this page here. If you want to change the JavaScript for the header and the footer, go to /js/app.js

include '../../../_login_guard.php';
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


if(is_post()){

    $name = $_POST["name"];
    $number = $_POST["number"];
    $unit = trim($_POST["building"]);
    $street = trim($_POST["street"]);
    $state = trim($_POST["states"]);
    $postcode = trim($_POST["postcode"]);
    $address = $unit . ", " . $street . ", " . $postcode . ", " . $state;
    $default = isset($_POST["default"]) ? $_POST["default"] : 0;

    if(isset($_POST["default"])){
        $_db->query("UPDATE savedaddress set defaultAdd = 0 WHERE userID = $userID");
    }
    //add to database
    $stm = $_db->prepare("INSERT into savedaddress(userID,address,phoneNo,name,defaultAdd) VALUES(?,?,?,?,?)")
    ->execute([$userID, $address, $number, $name, $default]);
    temp('info', "Address added!");
    header("Location: " . $_SERVER['REQUEST_URI']); //prevcnt form resubmission
    exit;
}

//get list of saved addrsses
$stm2 = $_db->query("SELECT * FROM savedaddress WHERE userID = $userID order by defaultAdd desc")->fetchAll();




include '../../../_head.php';

include 'profile_dynamic_navbar.php';

?>

<div class="main">
    
    <?php if (!is_email_verified()): ?>
    <!-- Verify Email Banner -->
    <section class="info-banner">
        <h2 class="info-banner-heading">Verify your email</h2>
        <div>We'll send a <b>verification link</b> straight to your mailbox, and all you have to do is click on the link. Simple as that.</div>
        <form id="verifyEmailForm" action="verify-email.php" method="post">
            <button class="btn-simple submit-btn">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <rect x="2" y="4" width="20" height="16" rx="2" />
                    <path d="M22 7L12 14L2 7" />
                </svg>
                Verify now
            </button>
        </form>
    </section>

    <script>
        $('#verifyEmailForm').on('submit', e => {
            e.preventDefault();

            $(e.target).children('.submit-btn').addClass('disabled').html('Sending email...');
            e.target.submit();
        });
    </script>
    <?php endif ?>

    <h1 class="heading"><?= $current_title ?></h1>
    <div class="container">
        <?php foreach($stm2 as $a): ?>
        <div class="card">
            <?php
            if($a->defaultAdd == 1){
                echo "<i>Default</i>";
            }
            ?>
            <h3><?= $a->name ?></h3>
            <span><?= $a->phoneNo ?></span>
            <span><?= $a->address ?></span>
            <div class="btncontainer">
                <button class="edit" data-card="<?= $a->addressIndex ?>"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="rgb(29, 20, 20)"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg></button>
                <button class="delete" data-card="<?= $a->addressIndex ?>"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="rgb(252, 101, 31)"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg></button>
            </div>
            
        </div>
        <?php endforeach ?>

        <div><button onclick="addAddress()"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="rgb(39, 39, 39)"><path d="M440-280h80v-160h160v-80H520v-160h-80v160H280v80h160v160Zm40 200q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg></button>
        <span>Add Address</span></div>
    </div>

    
    <div class="section-container">
        <section class="left-col">
                <form method="post" id="addressForm" hidden>
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
                                <option value="<?= $s ?>"><?= $s ?></option>
                                <?php endforeach ?>
                        </select>
                        
                    </div>

                    <div class="form-group">
                        <label">Postcode</label><br>
                        <input id="postcode" name="postcode" type="text"style="width:80px;" maxlength="5">
                        <span id="errmsg" style="color: red; font-size: 15px;" hidden>⚠️ Incorrect Postcode!</span><br>
                        <input type="checkbox" name="default" value="1"><span style="font-size: 13px;">Save as default?</span>
                    </div>
                     
                    
                    <button class="btn-simple btn-green" id="cancel" style="background-color:rgb(255, 136, 25)">Cancel</button>
                    <button 
                        type="button"
                        id="submitbutton"
                        class="btn-simple btn-green"
                    >Save address</button>
                    
                </form>
        </section>
    </div>
</div>


<script>
    function addAddress(){
        let container = document.getElementsByClassName("container")[0];
        let form = document.getElementById("addressForm");
        //if clicked we hide container and show form;
        container.style.display = "none";
        // clear all the value before we show the form;
        name.value = "";
        number.value = "";
        street.value = "";
        building.value = "";
        postcode.value = "";
        form.removeAttribute("hidden");
    }



    const name = document.getElementById("name");
    const number = document.getElementById("number");
    const street = document.getElementById("street");
    const building = document.getElementById("building");
    const postcode = document.getElementById("postcode");
    const button = document.getElementById("submitbutton");
    const states = document.getElementById("states");
    const errmsg = document.getElementById("errmsg");
    const errmsg2 = document.getElementById("errmsg2");
    const form =document.getElementById("addressForm");
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
        else{
            errmsg.removeAttribute("hidden");
            error = true;
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
                try{
                    form.submit();
                }catch (error){
                    console.log(error);
                }
                
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

    $("button#cancel").on('click', function(e){
        e.preventDefault();
        let container = document.getElementsByClassName("container")[0];
        $(form).prop("hidden","true");
        container.style.display = "grid";
        
    })

    $(".edit[data-card]").on("click", function(e){
        let addressIndex = this.dataset.card;
        location = "editaddress.php?edit=" + addressIndex;

    })


    $(".delete[data-card]").on("click", function(e){
        let addressIndex = this.dataset.card;
        let button = $(this);
        $.ajax({
            url: "deleteaddress.php",
            type: "POST",
            data: {
                "indexToDelete" : addressIndex
            },
            success: function(res){
                if(res=="success"){
                    console.log($(this).closest(".card"));
                    button.closest(".card").remove();
                    showError("Address removed!");
                }
            }
        });


        function showError(msg){
            let flashcard = $(".info-container.warn").children("span");
            flashcard.text(msg);
            setTimeout(function(){
                flashcard.text("");
            }, 3000);
        }

        function showSuccess(msg){
            let flashcard = $(".info-container.success").children("span");
            flashcard.text(msg);
            setTimeout(function(){
                flashcard.text("");
            }, 3000);
        }
    })
</script>

<?php
include '../../../_foot.php';