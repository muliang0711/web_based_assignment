<!DOCTYPE html>
<html lang="en">
</html>

<?php
$stylesheetArray = ['product.css'];

function link_stylesheet($stylesheetArray) {
  if (!$stylesheetArray) {
      return;
  }
}
  $time = time(); // Force browser to reload css instead of loading old css from cache
  
  if (is_array($stylesheetArray)) {
      foreach ($stylesheetArray as $stylesheet) {
          echo "<link rel='stylesheet' href='$stylesheet?v=$time' />";
      }
  } 
?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Products Home Page</title>
  </head>

<div class="container">
  <body>
    <div class="menu">
      <nav>
        <div class="top-sideMenu">
        <ul>
          <div class="logo">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/aa/Logo-Yonex.svg/2560px-Logo-Yonex.svg.png" width="125px">
            </div>
            <li><a onlick ="onClick()" href="../product/product.php"><strong>Home</strong></a></li>
          <li><a onlick ="onClick()" href="../product/productlist.php"><strong>Products</strong></a></li>
          <li><a onlick ="onClick()" href="../about/about.php"><strong>About</strong></a></li>
          <li><a href=""><strong>Contact</strong></a></li>
          <li><a href=""><strong>Account</strong></a></li>
        </ul>
      </div>
      </nav>
    </div>
    <div class="image-box">
      <img src="https://www.yonex.com/media/scandiweb/slider/y/o/yonex.com_top_english_2880x1120.png" alt="Nanoflare 700 RISING">
  </div>
<hr>
    <div class="row">
      <div class="col-2"><div id="blueheading"><h1 style="font-size:300%;">Viktor Axelsen</h1></div> <h1 style="font-size:300%;">Built to win.</h1>
      <p>Bring the world together by deepening people's connection to sport and to each other.</p>
      </div>
    <div class="col-2"> 
    </div>
    <div class="col-2"><img src="https://ih1.redbubble.net/image.1156440417.8811/flat,750x,075,f-pad,750x1000,f8f8f8.jpg" ></div>
   </div>

   
   <div class="product">

   </div>
  </body>