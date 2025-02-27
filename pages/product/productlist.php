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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['series'])) {
        $selected_series = $_POST['series'];
        echo "You selected: " . htmlspecialchars($selected_series);
    } else {
        echo "No series selected.";
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['series' == 'Arc'])) {
        echo "<img src='" . htmlspecialchars($imageSrc) . "' width='300' alt='Product Image'>";
    }
}?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Products List</title>
  </head>

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
        <img src="https://www.yonex.com/media/scandiweb/slider/n/a/nanoflare1000pc.png" alt="Nanoflare 700 RISING">
    </div>
<hr>
<div class="list">
  <div class="item">
    <img src="https://www.yonex.com/media/catalog/product/a/r/arc11-p.png?quality=80&fit=bounds&height=819&width=600&canvas=600:819" alt="Yonex Arcsaber 11 Pro">
    <p>Yonex Arcsaber 11 Pro</p>
  </div>
  
  <div class="item">
    <img src="https://www.yonex.com/media/catalog/product/n/a/nanoflare_1000_z.png?quality=80&fit=bounds&height=819&width=600&canvas=600:819" alt="Yonex Nanoflare 1000z">
    <p>Yonex Nanoflare 1000z</p>
  </div>
  
  <div class="item">
    <img src="https://www.yonex.com/media/catalog/product/3/a/3ax88d-p_076-1_02.png?quality=80&fit=bounds&height=819&width=600&canvas=600:819" alt="Yonex Astrox 88D Pro">
    <p>Yonex Astrox 88D Pro</p>
  </div>
</div> 


</body>