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
  $time = time();
  
  if (is_array($stylesheetArray)) {
      foreach ($stylesheetArray as $stylesheet) {
          echo "<link rel='stylesheet' href='$stylesheet?v=$time' />";
      }
  } 
?>

<body>
    <form method="get">
    <input type="text" id="search" name="search" maxlength="30">
    <button>submit</button>
    </form>
    <?php
        function is_get() {
        return $_SERVER['REQUEST_METHOD'] == 'GET';
        }
        $search = $_REQUEST['search'];
        if(!$search){
            echo "Invalid input!";
            redirect("../product/productlist.php");
        }
        $_db = new PDO('mysql:dbname=web_based_assignment','root', '',[
                   PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        ]);
            $statement = $_db->prepare("SELECT * FROM product WHERE productName LIKE ?");
            $statement->execute(["%$search%"]); 
            $productObjectArray = $statement->fetchAll();
    ?>
    <div class="userInput">
        <h>Input result " <?php echo $search ?> "</h>
    </div>
    <?php if($productObjectArray):?>
        <div class="list" id="productList">
    <?php     
      foreach($productObjectArray as $productObject):?>
         <div class="item">
          <a onclick = "onclick()" href = "../product/productDetail.php?racket=<?php echo $productObject->productID ?>">
          <img src="<?php echo $productObject->productImg ?>">
          <p><?php echo $productObject->productName ?></p>
          </a>
         </div>
      <?php endforeach ?>
      </div>
      <?php else: ?>
        <p>No result founded!</p>
    <?php endif ?>
</body> 