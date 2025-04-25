<?php
require_once __DIR__ . "/../_base.php";
require_once __DIR__ . "/../db_connection.php";
require_once __DIR__ . "/../db/productDb.php";
require_once __DIR__ . "/../pages/admin/product/generate_qr.php";
class ProductController
{
    private $productDb;

    public function __construct($_pdo)
    {
        $this->productDb = new productDb($_pdo);
    }

    public function handleAction()
    {
        $action = $_POST['action'] ?? $_GET['action'] ?? null;
        if (!$action) {
            $this->addErrorAndRedirect('No action specified.');
        }

        $allowedActions = [
            'addProduct'    => 'addProduct',
            'updateProduct' => 'updateProduct',
            'deleteProduct' => 'deleteProduct',
            'filter'        => 'filterProducts',
            'search'        => 'searchProduct',
            'updateStatus'  => 'updateStatus',
        ];

        if (!array_key_exists($action, $allowedActions)) {
            $this->addErrorAndRedirect('Invalid action specified.');
        }

        $method = $allowedActions[$action];
        $this->$method();
    }

    // ----------------------- Public  -----------------------
    public function getProductByIDAndSize($productID, $sizeID)
    {
        return $this->productDb->getProductByIDAndSize($productID, $sizeID);
    }

    public function getAllProducts()
    {
        return $this->productDb->getAllProducts();
    }

    public function getAllSeriesID()
    {
        return $this->productDb->getSeriesID();
    }

    public function getAllProductID()
    {
        return $this->productDb->getProductID();
    }

    // ----------------------- Private Controller Methods ------------------------------
    private function filterProducts()
    {
        // Minimal validation logic for filter
        $minPrice = isset($_POST['minPrice']) && $_POST['minPrice'] !== '' ? (float)$_POST['minPrice'] : null;
        $maxPrice = isset($_POST['maxPrice']) && $_POST['maxPrice'] !== '' ? (float)$_POST['maxPrice'] : null;

        // Price sanity check
        if ($minPrice !== null && $maxPrice !== null && $minPrice > $maxPrice) {
            $_SESSION['errors'] = ["Minimum price cannot exceed maximum price."];
            header("Location: ../pages/admin/product/filterResult.php");
            exit();
        }

        $filters = [
            'productID' => $_POST['productID'] ?? null,
            'priceMin'  => $minPrice,
            'priceMax'  => $maxPrice,
            'seriesID'  => $_POST['seriesID'] ?? null,
            'sizeID'    => $_POST['sizeID'] ?? null,
        ];

        try {
            $_SESSION['filterResult'] = $this->productDb->filterProduct($filters);
            header("Location: ../pages/admin/product/filterResult.php");
            exit();
        } catch (Exception $e) {
            $this->addErrorAndRedirect("Error filtering products: " . $e->getMessage());
        }
    }

    private function addProduct()
    {
        $productInformation = [
            'productId'    => $_POST['productId'] ?? null,
            'productName'  => $_POST['productName'] ?? null,
            'seriesId'     => $_POST['seriesId'] ?? null,
            'seriesName'   => $_POST['seriesName'] ?? null,
            'sizeId'       => $_POST['sizeId'] ?? null,
            'stock'        => $_POST['stock'] ?? null,
            'price'        => $_POST['price'] ?? null,
            'playerInfo'   => $_POST['playerInfo'] ?? null,
            'introduction' => $_POST['introduction'] ?? null,
        ];

        // Validate user input
        $errors = $this->validation($productInformation);
        if (!empty($errors)) {
            $_SESSION['Add_ErrorMsg'] = $errors;
            $this->redirectToAdmin();
        }

        // Check if productID & seriesID combination already exists
        $products = $this->getAllProducts();

        foreach ($products as $product) {
            if (
                $productInformation['productId'] == $product->productID &&
                $productInformation['sizeId'] == $product->sizeID
            ) {
                $errors[] = "Product ID already exists with the same sizeID.";
                break;
            }
            if (
                $productInformation['productId'] == $product->productID &&
                $productInformation['seriesId'] == $product->seriesID
            ) {
                $errors[] = "Product ID already exists with the same seriesID.";
                break;
            }
        }

        if (!empty($errors)) {
            $_SESSION['Add_ErrorMsg'] = $errors;
            $this->redirectToAdmin();
        }

        try {
            $this->productDb->beginTransaction();

            // 1. Insert product into the DB
            $result = $this->productDb->addProduct($productInformation);
            if (!$result['success']) {
                throw new Exception("Failed to add product: " . $result['error']);
            }

            // 2. Process images
            $uploadErrors1 = $this->processImages($_FILES['productImage'] ?? null, $productInformation['productId'], "product");
            if (!empty($uploadErrors1)) {
                throw new Exception(implode(", ", $uploadErrors1));
            }

            $uploadErrors2 = $this->processImages($_FILES['playerImage'] ?? null, $productInformation['productId'], "player");
            if (!empty($uploadErrors2)) {
                throw new Exception(implode(", ", $uploadErrors2));
            }

            $this->productDb->commitTransaction();

            $_SESSION['Add_SuccessMsg'] = "Product '{$productInformation['productName']}' (ID: {$productInformation['productId']}) added successfully!";
        } catch (Exception $e) {
            $this->productDb->rollbackTransaction();
            $_SESSION['Add_ErrorMsg'] = ["Error: " . $e->getMessage()];
        }

        $this->redirectToAdmin();
        
        generateQRCode($_db , $productInformation['productId'] , $productInformation['seriesId']);

    }

    private function updateProduct()
    {
        $productInformation = [
            'productId'    => $_POST['productId'] ?? null,
            'productName'  => $_POST['productName'] ?? null,
            'seriesId'     => $_POST['seriesId'] ?? null,
            'seriesName'   => $_POST['seriesName'] ?? null,
            'sizeId'       => $_POST['sizeId'] ?? null,
            'stock'        => $_POST['stock'] ?? null,
            'price'        => $_POST['price'] ?? null,
            'introduction' => $_POST['introduction'] ?? null,
            'playerInfo'   => $_POST['playerInfo'] ?? null,
        ];

        $errors = $this->validation($productInformation);
        if (!empty($errors)) {
            $_SESSION['Update_ErrorMsg'] = $errors;
            $this->redirectToAdmin();
        }

        try {
            $this->productDb->beginTransaction();

            // Update main product and stock
            $this->productDb->updateProducts($productInformation);

            // Update images (and remove old ones). If no new images, no changes
            $uploadErrors1 = $this->processImages($_FILES['productImage'] ?? null, $productInformation['productId'], "product");
            if (!empty($uploadErrors1)) {
                throw new Exception(implode(", ", $uploadErrors1));
            }
            $uploadErrors2 = $this->processImages($_FILES['playerImage'] ?? null, $productInformation['productId'], "player");
            if (!empty($uploadErrors2)) {
                throw new Exception(implode(", ", $uploadErrors2));
            }

            $this->productDb->commitTransaction();

            $_SESSION['Update_SuccessMsg'] = "Product '{$productInformation['productName']}' (ID: {$productInformation['productId']}) updated successfully!";
        } catch (Exception $e) {
            $this->productDb->rollbackTransaction();
            $_SESSION['Update_ErrorMsg'] = ["Error: " . $e->getMessage()];
        }

        $this->redirectToAdmin();
    }

    private function deleteProduct()
    {
        $productInformation = [
            'productId' => $_POST['productId'] ?? null,
            'sizeId'    => $_POST['sizeId'] ?? null,
        ];

        // Basic check. If you want more advanced checks, do them here.
        if (empty($productInformation['productId']) || empty($productInformation['sizeId'])) {
            $_SESSION['Delete_ErrorMsg'] = ["Product ID and Size ID are required for deletion."];
            $this->redirectToAdmin();
        }

        $result = $this->productDb->deleteProduct($productInformation);

        if ($result['success']) {
            $_SESSION['Delete_SuccessMsg'] = $result['message'] ?? 'Successfully deleted.';
        } else {
            $_SESSION['Delete_ErrorMsg'] = ['Failed to delete: ' . $result['message']];
        }
        $this->redirectToAdmin();
    }

    private function searchProduct()
    {
        // Minimal check for search input
        if (empty($_GET['searchText'])) {
            $_SESSION['errors'] = ["Search text cannot be empty."];
            header("Location: ../pages/admin/product/searchResult.php");
            exit();
        }

        $searchText = $_GET['searchText'];

        try {
            $_SESSION['searchResult'] = $this->productDb->search($searchText);
            $encoded = urlencode($searchText);
            header("Location: ../pages/admin/product/searchResult.php?search=" . $encoded);
            exit();
        } catch (Exception $e) {
            $this->addErrorAndRedirect("Error searching products: " . $e->getMessage());
        }
    }
    // ----------------------- Validation & File Processing ----------------------------

    private function validation($productInformation)
    {
        $errors = [];

        // Validate productId
        if (empty($productInformation['productId'])) {
            $errors[] = "Product ID cannot be null!";
        } elseif (strlen($productInformation['productId']) > 5) {
            $errors[] = "Product ID cannot exceed 5 characters.";
        }

        // Validate productName
        if (empty($productInformation['productName'])) {
            $errors[] = "Product name cannot be null!";
        } elseif (strlen($productInformation['productName']) > 100) {
            $errors[] = "Product name cannot exceed 100 characters.";
        }

        // Validate seriesId
        if (empty($productInformation['seriesId'])) {
            $errors[] = "Series ID cannot be null!";
        } elseif (strlen($productInformation['seriesId']) > 3) {
            $errors[] = "Series ID cannot exceed 3 characters.";
        }

        // Validate seriesName
        if (empty($productInformation['seriesName'])) {
            $errors[] = "Series Name cannot be null!";
        } elseif (strlen($productInformation['seriesName']) > 15) {
            $errors[] = "Series Name cannot exceed 15 characters.";
        }

        // Validate price
        if ($productInformation['price'] === '' || $productInformation['price'] === null) {
            $errors[] = "Price must have a value!";
        } elseif (!is_numeric($productInformation['price']) || (float)$productInformation['price'] < 0) {
            $errors[] = "Price must be a non-negative number!";
        }

        // Validate stock
        if ($productInformation['stock'] === '' || $productInformation['stock'] === null) {
            $errors[] = "Stock must have a value!";
        } elseif (!is_numeric($productInformation['stock']) || (int)$productInformation['stock'] < 0) {
            $errors[] = "Stock must be a non-negative integer!";
        }

        // Validate sizeId
        if (empty($productInformation['sizeId'])) {
            $errors[] = "Size ID cannot be null!";
        } elseif (strlen($productInformation['sizeId']) > 4) {
            $errors[] = "Size ID cannot exceed 4 characters.";
        }

        // Optional: Validate introduction length
        if (!empty($productInformation['introduction']) && strlen($productInformation['introduction']) > 2000) {
            $errors[] = "Introduction cannot exceed 2000 characters.";
        }

        // Optional: Validate playerInfo length
        if (!empty($productInformation['playerInfo']) && strlen($productInformation['playerInfo']) > 2000) {
            $errors[] = "Player Info cannot exceed 2000 characters.";
        }

        return $errors;
    }

    private function processImages($files, $productId, $type)
    {
        if (!$files || empty($files['name'][0])) {
            return []; // No file(s) uploaded
        }

        $uploadDir = realpath(__DIR__ . '/../File');
        $allowedTypes = ["jpg", "jpeg", "png"];
        $fileCount = count($files['name']);
        $uploadErrors = [];

        for ($i = 0; $i < $fileCount; $i++) {
            // Catch standard PHP file upload errors
            if ($files['error'][$i] !== UPLOAD_ERR_OK) {
                $uploadErrors[] = $this->codeToMessage($files['error'][$i]);
                continue;
            }

            $fileTmpPath = $files['tmp_name'][$i];
            $fileName = $files['name'][$i];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (!in_array($fileExt, $allowedTypes)) {
                $uploadErrors[] = "Invalid file type '{$fileExt}' for {$fileName}. Allowed: jpg, jpeg, png.";
                continue;
            }

            // Double-check it was uploaded via HTTP POST
            if (!is_uploaded_file($fileTmpPath)) {
                $uploadErrors[] = "Possible file upload attack detected for {$fileName}.";
                continue;
            }

            $newFileName = "{$type}_{$productId}_" . time() . "{$i}" ."." . $fileExt;
            $targetPath = $uploadDir . '/' . $newFileName;

            if (!move_uploaded_file($fileTmpPath, $targetPath)) {
                $uploadErrors[] = "Failed to move uploaded file: {$fileName}";
                continue;
            }

            // If all good, record in DB
            try {
                $this->productDb->addProductImage($productId, $newFileName, $type);
            } catch (Exception $e) {
                $uploadErrors[] = "Error storing image path in DB for {$fileName}: " . $e->getMessage();
            }
        }

        return $uploadErrors;
    }

    private function codeToMessage($code)
    {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return "File is too large.";
            case UPLOAD_ERR_PARTIAL:
                return "File was only partially uploaded.";
            case UPLOAD_ERR_NO_FILE:
                return "No file was uploaded.";
            case UPLOAD_ERR_NO_TMP_DIR:
                return "Missing a temporary folder.";
            case UPLOAD_ERR_CANT_WRITE:
                return "Failed to write file to disk.";
            case UPLOAD_ERR_EXTENSION:
                return "File upload stopped by extension.";
            default:
                return "Unknown file upload error.";
        }
    }

    private function redirectToAdmin()
    {
        header('Location: ../pages/admin/product/admin_product.php');
        exit();
    }

    private function addErrorAndRedirect($msg)
    {
        $_SESSION['errors'] = [$msg];
        $this->redirectToAdmin();
    }
}

$productController = new ProductController($_db);
if (isset($_GET['action']) || isset($_POST['action'])) {
    $productController->handleAction();
}
