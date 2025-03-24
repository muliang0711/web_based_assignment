<?php
$stylesheetArray = ['product.css'];
$title = 'Product List';
require '../../_base.php';
include '../../_head.php';
$search = $_REQUEST['search'];
$seriesStatement = $_db->prepare("SELECT * FROM series");
$seriesStatement->execute([]);
$seriesArray = $seriesStatement->fetchAll();
?>

<body>

<div class="sidebar">
    <div class="sidebarFont">
        <ul>
            <h>Series</h>
            <hr>
            <?php foreach ($seriesArray as $s): ?>
                <a onclick="onclick()" href ="../product/searchResult.php?search=<?php echo $s->seriesName ?>" >
                <li><p><?php echo "$s->seriesName" ?></p></li>
                </a>
            <?php endforeach ?>
            <hr>
            <h>Price Sorting</h>
            <hr>
            <form method="get" action="../product/searchResult.php?price=LowToHigh">
            <p>Low  ->  High</p>
            </form>
            <form method="get" action="../product/searchResult.php?price=HighToLow">
            <p>High ->  Low</p>
            </form>
            <hr>
        </ul>
    </div>
</div>

    <form method="get" action="../product/searchResult.php?search=?">
        <div class="searchContainer">
            <input type="text" id="search" name="search" maxlength="30" class="input" placeholder="<?php echo $search ?>">
        </div>
        <div class="searchButton">
            <button><img src="illustration-magnifying-glass-icon.png"></button>
        </div>
    </form>
    <?php
    if (!$search) {
        echo "Invalid input!";
    }
    $_db = new PDO('mysql:dbname=web_based_assignment', 'root', '', [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    ]);
    $statement = $_db->prepare("SELECT * FROM product WHERE productName LIKE ?");
    $statement->execute(["%$search%"]);
    $productObjectArray = $statement->fetchAll();
    ?>
    <div class="userInput">
        <p>Input result " <?php echo $search ?> "</p>
    </div>
    <?php if ($productObjectArray): ?>
        <div class="list" id="productList">
            <?php
            foreach ($productObjectArray as $productObject): ?>
                <div class="item">
                    <a onclick="onclick()" href="../product/productDetail.php?racket=<?php echo $productObject->productID ?>">
                        <img src="<?php echo $productObject->productImg ?>">
                        <p><?php echo $productObject->productName ?></p>
                    </a>
                </div>
            <?php endforeach ?>
        </div>
    <?php else: ?>
        <div class="noResult">
            <p>No result founded!</p>
            <hr>
            <div class="list" id="productList">
                <?php
                $statement = $_db->prepare("SELECT * FROM product");
                $statement->execute([]);
                $productObjectArray = $statement->fetchAll();
                foreach ($productObjectArray as $productObject): ?>
                    <div class="item">
                        <a onclick="onclick()" href="../product/productDetail.php?racket=<?php echo $productObject->productID ?>">

                            <img src="<?php echo $productObject->productImg ?>">
                            <p><?php echo $productObject->productName ?></p>
                        </a>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    <?php endif ?>
</body>
<?php
include '../../_foot.php';
