<!DOCTYPE html>
<html lang="en">
</html>
<link rel="stylesheet" href="./product/productlist.php">
<?php
$stylesheetArray = ['product.css'];

function link_stylesheet($stylesheetArray) {
  if (!$stylesheetArray) {
      return;
  }
}
  $time = time(); 
  
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

<div class="container">.
  <body>
    <div class="menu">
      <nav>
        <!-- TopSide Menu -->
        <div class="top-sideMenu">
        <ul>
          <!-- store logo -->
          <div class="logo">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/aa/Logo-Yonex.svg/2560px-Logo-Yonex.svg.png" width="125px">
            </div>
            <li><a onclick ="onClick()" href="../product/product.php"><strong>Home</strong></a></li>
          <li><a onclick ="onClick()" href="../product/productlist.php"><strong>Products</strong></a></li>
        </ul>
      </div>
      </nav>
    </div>
 

<?php 
if(isset($_GET['racket'])){
  $productID = $_GET['racket'];
}
$_db = new PDO('mysql:dbname=web_based_assignment','root', '',[
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
]);

if($productID == "R0001"){
    $_racket = $_db->query('SELECT * FROM product WHERE productID="R0001"')
           ->fetchAll(); 
  } else if($productID == "R0002"){
    $_racket = $_db->query('SELECT * FROM product WHERE productID="R0002"')
            ->fetchAll();
  } else if($productID == "R0003"){
    $_racket = $_db->query('SELECT * FROM product WHERE productID="R0003"')
            ->fetchAll();
  } else{
    echo "Error: Undefined racket";
    redirect('/');
  }

$statement = $_db->prepare("SELECT * FROM product WHERE productID = ?");
$statement->execute([$productID]); // make sure your $productID variable is declared - I don’t see it in the screenshot
$productObject = $statement->fetch();
// If $productID is “R0001”, now your $productObject will be {productID: “R0001”, productName: “Yonex Arcsaber 11 Pro”, price: 849.00, seriesID: “ARC”}

$racketName = $productObject->productName; // Get the productName attribute of the product object
$price = $productObject->price; // Get the price attribute of the product object
?>

<div class="detail">
<div class="product"><img src = "https://www.yonex.com/media/catalog/product/a/r/arc11-p.png?quality=80&fit=bounds&height=819&width=600&canvas=600:819"></div>
<div class="racketName"><?php echo $racketName ?></div>
<div class="price"><?php echo "Price:RM "?><?php echo $price?><?php echo ".00" ?><br>
<?php echo "Grip Size: 3UG5/4UG5" ?> <br> <?php echo "Made in Japan" ?> <br>  <?php echo "Item code" ?>  <?php echo $productID ?>
</div>
</div>
<div class="introduction">
<?php if($productID == "R0001"){
  echo "The Arcsaber 11 Pro adopts the unique feel of impact and offers enhanced playability with an emphasis on shuttle pocketing for a controlled attack. Taking control of the court can take many forms, and for the Arcsaber it comes from the extra milliseconds of shuttle contact time.";
}
if($productID == "R0002"){
  echo "The new NANOFLARE 1000 is being used on court now in the hands of Rio Olympic gold medalist, Carolina Marin (ESP), 2022 All England silver medalist, Lakshya Sen (IND), and 2022 French Open champion, He Bing Jiao (CHN). The racquets are scheduled for a global launch on June 16th, 2023, in four different models, Z, TOUR, GAME and PLAY – each developed with the same performance concept but with variations in materials used.";
}
if($productID == "R0003"){
  echo "This brand new Astrox 88D Pro is designed for aggressive doubles players who are always ready to dominate from the back of the court. The POWER-ASSIST BUMPER has been newly added to the top of the frame, providing even more advancement for the Rotational Generator System.";
}
?>
  </div>
</div>
<div class="addtoCart"><button>Add to Cart<span class="shadow"></span></button></div>
<hr>

<div class="playerPhoto"> 
  <div class= "HeadingIntro"> 
<?php echo "The player who is using this racket" ?></div><br>
<?php if($productID == "R0001"){
  echo "Aaron Chia Teng Fong is a Malaysian badminton player.A world champion and a double bronze medalist at the Olympic Games, he and his partner Soh Wooi Yik became the first ever world badminton champions from Malaysia after winning the men's doubles title at the 2022 World Championships.Together, they also won a gold medal at the 2019 SEA Games, a silver medal at the 2022 Asian Championships,as well as bronze medals at the 2020 Summer Olympics,2022 Commonwealth Games,2023 World Championships,2022 Asian Games,2024 Asian Championships,and 2024 Summer Olympics.They are also the first Malaysian men’s doubles pair to win consecutive medals at the Olympic Games.";
  echo "<img src='https://www.yonex.com/media/wysiwyg/Athletes/Badminton/810x540_aaron-chia.jpg' alt='Yonex Arcsaber 11 Pro Player' width='300'>";
}
?>
<?php if($productID == "R0002"){
  echo "Chen Tang Jie is a Malaysian badminton player. He was part of the Malaysian 2016 Asian Junior Championships and 2016 BWF World Junior Championships team, and helped Malaysia to clinch a silver medal in the World Junior mixed team before being defeated by China.";
  echo "<img src='https://www.badmintonplanet.com/wp-content/uploads/2023/06/06-25-2023-badminton-news-chen-tang-jie-toh-ee-wei-taipei-open.jpg'>";
}
?>
<?php if($productID == "R0003"){
  echo "Kunlavut Vitidsarn is a Thai badminton player. He is the current men's singles World Champion as he won the gold medal at the 2023 World Championships, and a silver medalist at the 2024 Olympic Games. He was also three-times World Junior champion, winning in 2017, 2018 and 2019. He is nicknamed the 'Three-Game God' because his playing style requires him to play three games long and always win in the end.";
  echo "<img src='https://www.pattayamail.com/wp-content/uploads/2024/08/t-09-Kunlavut-Vitidsarn-makes-history-as-first-Thai-shuttler-to-reach-Olympic-badminton-final.jpg' alt='Yonex Arcsaber 11 Pro Player' width='300'>";
}
?>
</div>
</body>
