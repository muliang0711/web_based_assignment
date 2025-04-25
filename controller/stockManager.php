<?php
// 1. Start session to use session variables
session_start();

// 2. Include required files
include_once __DIR__ . '/../db_connection.php';
include_once __DIR__ . '/../db/productStock.php'; // Assuming this is where your CheckStock class is

class ProductManager {
    private $pdo;
    private $checkStock;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->checkStock = new CheckStock($pdo);
    }

    public function handleAction()
    {
        $action = $_POST['action'] ?? $_GET['action'] ?? null;
        if (!$action) {
            $this->addErrorAndRedirect('No action specified.');
        }

        $allowedActions = [
            'filter'        => 'filterProducts',
            'search'        => 'searchProduct',
            'sendEmail'     => 'emailSubmit',
            'sendSMS'       => 'SMSSubmit'
        ];

        if (!array_key_exists($action, $allowedActions)) {
            $this->addErrorAndRedirect('Invalid action specified.');
        }

        $method = $allowedActions[$action];
        $this->$method();
    }

    public function loadLowStockProductsToSession() {
        $lowStockProducts = $this->checkStock->get_low_stock_product();
        $_SESSION['low_stock_product'] = $lowStockProducts;
    }

    public function getProductInfo($productID, $sizeID) {
        return $this->checkStock->getDetailedProductInfo($productID, $sizeID);
    }

    public function updateStock($productID, $sizeID, $quantity, $adminName) {
        $success = $this->checkStock->update_product_stock($quantity, $productID, $sizeID);
        if ($success) {
            $this->checkStock->record_restock($productID, $sizeID, $quantity, $adminName);
            return ['success' => true, 'message' => 'Stock updated and restock recorded.'];
        } else {
            return ['success' => false, 'message' => 'Update failed or no stock change.'];
        }
    }

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
            $_SESSION['filterResult'] = $this->checkStock->filterProduct($filters);
            header("Location: ../pages/admin/product/filterResult.php");
            exit();
        } catch (Exception $e) {
            $this->addErrorAndRedirect("Error filtering products: " . $e->getMessage());
        }
    }

    private function emailSubmit()
    {
        // 1. Get data
        $to = $_POST['to'] ?? '';
        $subject = $_POST['subject'] ?? '';
        $message = $_POST['message'] ?? '';
    
        // 2. Validate
        if (empty($to) || empty($subject) || empty($message)) {
            $this->addErrorAndRedirect("All fields are required.");
            return;
        }
    
        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            $this->addErrorAndRedirect("Invalid email address.");
            return;
        }
    
        // 3. Send email (using PHPMailer helper)
        $success = $this->checkStock->sendEmail($to, $subject, $message);
    
        // 4. Handle result
        if ($success) {
            $_SESSION['EmailSuccess'] = "Email successfully sent to $to.";
        } else {
            $_SESSION['EmailError'] = "Failed to send email. Please try again later.";
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
            $_SESSION['searchResult'] = $this->checkStock->search($searchText);
            $encoded = urlencode($searchText);
            header("Location: ../pages/admin/product/searchResult.php?search=" . $encoded);
            exit();
        } catch (Exception $e) {
            $this->addErrorAndRedirect("Error searching products: " . $e->getMessage());
        }
    }

    private function SMSSubmit()
    {
        $phone = $_POST['phone'] ?? '';
        $message = $_POST['message'] ?? '';
    
        if (empty($phone) || empty($message)) {
            $this->addErrorAndRedirect("Phone number and message are required.");
            return;
        }
    
        if (!preg_match('/^\+\d{9,15}$/', $phone)) {
            $this->addErrorAndRedirect("Invalid phone number format. Example: +60123456789");
            return;
        }
    
        $success = $this->checkStock->sendSMS($phone, $message);

        if ($success) {
            $_SESSION['SMSSuccess'] = "SMS successfully sent to $phone.";
        } else {
            $_SESSION['SMSError'] = "Failed to send SMS. Please try again later.";
        }
    
        // 5. Redirect back to admin dashboard or appropriate page
        $this->redirectToAdmin();
    }
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
    private function addErrorAndRedirect($msg)
    {
        $_SESSION['errors'] = [$msg];
        $this->redirectToAdmin();
    }
    
    private function redirectToAdmin()
    {
        header('Location: ../pages/admin/product/emailForm.php');
        exit();
    }
}

// 6. Example usage
$stockManager = new ProductManager($_db);
if (isset($_GET['action']) || isset($_POST['action'])) {
    $stockManager->handleAction();
}
?>
