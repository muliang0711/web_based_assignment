<?php
require_once "../../../_base.php";   
$stylesheetArray = ['../../../css/main.css'];
link_stylesheet($stylesheetArray);



$searchText = isset($_GET['search']) ? urldecode($_GET['search']) : '';
$searchResultJson = isset($_GET['result']) ? $_GET['result'] : '';

$searchResult = json_decode(urldecode($searchResultJson));
var_dump($searchResult);

if (empty($searchResult)) {
    echo "<p>No search results found for: <strong>" . htmlspecialchars($searchText) . "</strong></p>";
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<body>

    <div class="main-content">
        
        <div class="container-table">

            <div class="tb-title">
                <h5 style="margin: 0;"><i class="fas fa-table"></i> Product </h5>
            </div>


            <div style="padding: 1rem;">
                <table class="tb">

                <thead>
                        <tr style="background-color: #f9f9f9;">
                        <th class="th">product ID  </th>
                        <th class="th">series ID</th>
                        <th class="th">sizeID</th>
                        <th class="th">price</th>
                        <th class="th">stock</th>
                        <th class="th">Actions</th>
                        </tr>
                </thead>

                <tbody>
                        <?php foreach ($searchResult as $index => $product): ?>

                        <!-- Product Info -->
                        <tr>
                            <td class="td"><?php echo htmlspecialchars($product->productID); ?></td>
                            <td class="td"><?php echo htmlspecialchars($product->seriesID); ?></td>
                            <td class="td"><?php echo htmlspecialchars($product->sizeID); ?></td>
                            <td class="td">RM<?php echo number_format($product->price, 2); ?></td>
                            <td class="td"><?php echo htmlspecialchars($product->total_stock); ?></td>
                            <td class="td">
                                <!-- View Details -->
                                <a href="productDetails.php?productID=<?php echo $product->productID; ?>&sizeID=<?php echo $product->sizeID; ?>" class="action-btn-details">
                                    <i class="fas fa-eye"></i>
                                </a>


                                <!-- Edit -->
                                <a href="editProduct.php?productID=<?php echo $product->productID; ?> &sizeID=<?php echo $product->sizeID; ?>" class="action-btn-edit" title="Edit Product">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <form method="POST" action="/controller/productController.php" class="delete-form" style="display:inline;">
                                    <input type="hidden" name="action" value="deleteProduct">  
                                    <input type="hidden" name="productId" value="<?php echo $product->productID; ?>">
                                    <input type="hidden" name="sizeId" value="<?php echo $product->sizeID; ?>">
                                    <button type="submit" class="action-btn-delete" data-productid="<?php echo $product->productID; ?>" data-sizeid="<?php echo $product->sizeID; ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <?php endforeach; ?>

                    </tbody>
                </table>

            </div>

        </div>

    </div>
</body>
</html>