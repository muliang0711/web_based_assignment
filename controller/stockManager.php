<?php

// 2. Include required files
include_once __DIR__ . '/../db_connection.php';
include_once __DIR__ . '/../db/productStock.php'; // Assuming this is where your CheckStock class is

class ProductManager {

    private $checkStock;

    public function __construct($pdo) {
        $this->checkStock = new CheckStock($pdo);
    }

    public function handleAction()
    {
        $action = $_POST['action'] ?? $_GET['action'] ?? null;
        if (!$action) {
            $this->addErrorAndRedirect('No action specified.');
        }
    
        if ($action === 'updateStock') {
            // Special handling for updateStock
            $productID = $_POST['productID'] ?? null;
            $sizeID = $_POST['sizeID'] ?? null;
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;
            $price = isset($_POST['restock_price']) ? (float)$_POST['restock_price'] : 0.00;
            $adminName = $_SESSION['adminID'] ;
    
            if (!$productID || !$sizeID || $quantity <= 0 || $price <= 0) {
                $this->addErrorAndRedirect('Missing or invalid input fields.');
            }
    
            $result = $this->updateStock($productID, $sizeID, $quantity, $price, $adminName);
    
            if ($result['success']) {
                $_SESSION['success'] = $result['message'];
            } else {
                $_SESSION['errors'] = [$result['message']];
            }
            
            $url = "../pages/admin/product/update-stock.php?productID=" . urlencode($productID) . "&sizeID=" . urlencode($sizeID);
            header("Location: $url");
            
            exit();
        }
    
        // Normal mappings for other actions
        $allowedActions = [
            'filter'        => 'filterRecord',
            'search'        => 'searchProduct',
            'sendEmail'     => 'emailSubmit',
            'sendSMS'       => 'SMSSubmit',
            'filterRecord'  => 'filterRecord'  
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

    public function updateStock($productID, $sizeID, $quantity, $price, $adminName) {
    
        $success = $this->checkStock->update_product_stock($quantity, $productID, $sizeID);
        
        if ($success) {
            $this->checkStock->record_restock($productID, $sizeID, $quantity, $price, $adminName);
    
            $_SESSION['successupdate'] = 'Stock updated and restock recorded.';
    
            return ['success' => true, 'message' => 'Stock updated and restock recorded.'];

        } else {

            $_SESSION['failedupdate'] = 'Update failed or no stock change.';
    
            return ['success' => false, 'message' => 'Update failed or no stock change.'];
        }
    }

    private function filterRecord()
    {
        session_start();
        // echo '<pre>';
        // print_r($_POST);
        // echo '</pre>';
        // 1. Minimal validation
        $startDate = $_POST['startDate'] ?? '';
        $endDate = $_POST['endDate'] ?? '';
    
    
        // 2. Build Filters
        $filters = [
            'productID'    => $_POST['productID'] ?? null,
            'sizeID'       => $_POST['sizeID'] ?? null,
            'restocked_by' => $_POST['restocked_by'] ?? null,
            'startDate'    => $startDate,
            'endDate'      => $endDate
        ];
        
        // echo '<pre>';
        // print_r($filters);
        // echo '</pre>';
        // 3. Query Filtered Records
        try {
            // $records = $this->checkStock->getFilteredRestockRecords($filters);

            $_SESSION['filterRecordResult'] = $this->checkStock->getFilteredRestockRecords($filters);
            // echo '<pre>';
            // print_r($_SESSION['filterRecordResult']);
            // echo '</pre>';
            header("Location: ../pages/admin/product/filterRecordResult.php"); // new page
            exit();
        } catch (Exception $e) {
            $this->addErrorAndRedirect("Error filtering restock history: " . $e->getMessage());
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
        $phone      = $_POST['phone'] ?? '';
        $message    = $_POST['message'] ?? '';
    
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
        header("Location : ../pages/admin/product/sendSMS.php");
        exit();
    }

    public function sumRestockPriceAndQuantity($productID, $sizeID) {
        return $this->checkStock->getTotalRestockData($productID, $sizeID);
    }

    public function suggestSellPrice($productID, $sizeID) {
        $sumData = $this->sumRestockPriceAndQuantity($productID, $sizeID);
    
        if ($sumData['totalQuantity'] === 0) {
            return 0; // Cannot calculate if no quantity
        }
    
        // Calculate average cost per unit
        $averageCost = $sumData['totalCost'] / $sumData['totalQuantity'];
    
        // Add markup
        $markupRate = 1.3; // 30% markup
        $suggestedPrice = $averageCost * $markupRate;
    
        return round($suggestedPrice, 2);
    }

    private function addErrorAndRedirect($msg)
    {
        $_SESSION['errors'] = [$msg];
        $this->redirectToAdmin();
    }
    
    private function redirectToAdmin()
    {
        header('Location: ../pages/admin/product/stock.php');
        exit();
    }
}

// 6. Example usage
$stockManager = new ProductManager($_db);
if (isset($_GET['action']) || isset($_POST['action'])) {
    $stockManager->handleAction();
}
?>
