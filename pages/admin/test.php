<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Images</title>
    <style>
        .gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .gallery img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 1px solid #ccc;
            padding: 5px;
        }
    </style>
</head>
<body>

<?php 
include_once __DIR__ . "/../../db_connection.php"; 

$pdo = $_db;

// Get the product ID from the URL


if (!$productID) {
    echo "<p>No product ID provided.</p>";
    exit;
}

$sql = "SELECT image_path FROM product_images WHERE productID = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$productID]); 
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Product Images</h2>

<div class="gallery">
    <?php if (!empty($images)): ?>
        <?php foreach ($images as $image): ?>
            <img src="<?php echo "../../File/" . htmlspecialchars($image['image_path']); ?>" alt="Product Image">
        <?php endforeach; ?>
    <?php else: ?>
        <p>No images available for this product.</p>
    <?php endif; ?>
</div>

</body>
</html>
