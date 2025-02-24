<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h2>Product List</h2>

<!-- Add Product Form -->
<form action="http://myproject.local/mvc_demo/controller/product_controller.php?action=add" method="POST">
    <input type="text" name="name" placeholder="Product Name" required>
    <input type="text" name="description" placeholder="Description" required>
    <input type="number" name="price" placeholder="Price" required>
    <input type="text" name="image" placeholder="Image Name (e.g., nike.jpg)" required>
    <input type="number" name="stock" placeholder="Stock" required>
    <button type="submit">Add Product</button>
</form>

<ul>
    <?php foreach ($products as $product): ?>
        <?php for ($i = 0; $i < $product['stock']; $i++): ?>
            <li>
                <strong><?php echo htmlspecialchars($product['name']); ?></strong>
                - $<?php echo $product['price']; ?>
                <form action="http://myproject.local/mvc_demo/controller/product_controller.php?action=delete" method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                    <button type="submit">Delete</button>
                </form>
            </li>
        <?php endfor; ?>
    <?php endforeach; ?>
</ul>
</body>
</html>

