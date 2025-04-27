<?php
include_once __DIR__ . "/../db_connection.php";
require __DIR__ . "/../vendor/autoload.php"; // Composer autoload

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

ini_set('max_execution_time', 300);

use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\SMS\Message\SMS;

class CheckStock
{
    private $pdo;

    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    private function sendLowStockEmail($toEmail, $subject, $messageBody)
    {
        $mail = new PHPMailer(true);

        try {

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'puihy-wm24@student.tarc.edu.my';
            $mail->Password = 'mqps lalr ujvo fbqx';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('puihy-wm24@student.tarc.edu.my', 'Inventory Alert');
            $mail->addAddress($toEmail);

            $mail->isHTML(true);
            $mail->Subject = $subject;

            $mail->Body = "
            <h2>Low Stock Notification</h2>
            <p>The following products are below their stock threshold:</p>
            $messageBody
            <br><p><strong>Please restock soon!</strong></p>
        ";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Email error: " . $mail->ErrorInfo);
            return false;
        }
    }

    public function sendEmail($toEmail, $subject, $message)
    {
        $mail = new PHPMailer(true);

        try {
            // 1. SMTP setup
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'puihy-wm24@student.tarc.edu.my';
            $mail->Password   = 'mqps lalr ujvo fbqx';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // 2. Email setup
            $mail->setFrom('puihy-wm24@student.tarc.edu.my', 'Inventory System');
            $mail->addAddress($toEmail);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = nl2br(htmlspecialchars($message));

            // 3. Send
            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Email error: " . $mail->ErrorInfo);
            return false;
        }
    }
    // 1. This function checks all low stock products and sends a single email.
    public function check_low_stock()
    {
        // 2. Step: Fetch all low stock products
        $sql = "SELECT * FROM productstock WHERE stock <= low_stock_threshold AND alert_sent = 0";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $low_stock_products = $stmt->fetchAll();

        // 3. Step: If no low stock, exit early
        if (count($low_stock_products) === 0) {
            return;
        }

        // 4. Step: Prepare email content
        $messageLines = [];

        foreach ($low_stock_products as $product) {
            $productID = $product->productID;
            $sizeID = $product->sizeID;
            $productName = $product->product_name ?? "Product #$productID"; // fallback
            $stock = $product->stock;
            $threshold = $product->low_stock_threshold;

            $messageLines[] = "Product: <b>$productName</b> (Stock: $stock / Threshold: $threshold)";
        }

        $fullMessage = implode('<br>', $messageLines);

        $ownerEmail = 'puihy-wm24@student.tarc.edu.my';
        $subject = "Low Stock Alert for Multiple Products";

        $emailSent = $this->sendLowStockEmail($ownerEmail, $subject, $fullMessage);

        if ($emailSent) {
            foreach ($low_stock_products as $product) {
                $productID = $product->productID;
                $sizeID = $product->sizeID;

                $updateSql = "UPDATE productstock SET alert_sent = 1 WHERE productID = ? AND sizeID = ?";
                $updateStmt = $this->pdo->prepare($updateSql);
                $updateStmt->execute([$productID, $sizeID]);
            }

            echo "Low stock alert email sent successfully for " . count($low_stock_products) . " products.\n";
        } else {
            echo "Failed to send low stock alert email.\n";
        }
    }


    public function sendSMS($toPhone, $textMessage)
    {
        // Load env variables if not already loaded
        if (!isset($_ENV['VONAGE_KEY'])) {
            require_once __DIR__ . '/../config/bootstrap.php';
        }

        $key    = $_ENV['VONAGE_KEY'];
        $secret = $_ENV['VONAGE_SECRET'];

        try {
            $basic = new Basic($key, $secret);
            $client = new Client($basic);

            $response = $client->sms()->send(
                new SMS($toPhone, "VonageSMS", $textMessage)
            );

            $message = $response->current();

            if ($message->getStatus() == 0) {
                return ['success' => true];
            } else {
                return ['success' => false, 'error' => "Status: " . $message->getStatus()];
            }
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }


    public function getTotalRestockData($productID, $sizeID) {
        $sql = "SELECT 
                    SUM(restock_price * restock_quantity) AS totalCost,
                    SUM(restock_quantity) AS totalQuantity
                FROM restock_history
                WHERE productID = ? AND sizeID = ?";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$productID, $sizeID]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($result && $result['totalQuantity'] > 0) {
            return [
                'totalCost' => (float)$result['totalCost'],
                'totalQuantity' => (int)$result['totalQuantity']
            ];
        } else {
            return [
                'totalCost' => 0,
                'totalQuantity' => 0
            ];
        }
    }

    public function get_low_stock_product()
    {

        $sql = "SELECT 
                    p.productID,
                    p.productName,
                    p.price,
                    p.seriesID,
                    s.seriesName,
                    ps.sizeID,
                    ps.stock,
                    ps.low_stock_threshold,
                    img.image_path 
                FROM 
                    productstock ps
                JOIN 
                    product p ON ps.productID = p.productID
                LEFT JOIN 
                    series s ON p.seriesID = s.seriesID
                LEFT JOIN 
                    product_images img ON p.productID = img.productID AND img.image_type = 'product'
                WHERE 
                    ps.stock <= ps.low_stock_threshold ";


        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $low_stock_product = $stmt->fetchAll();

        return $low_stock_product;
    }


    public function change_low_stock_threshold($low_stock_threshold, $productID, $sizeID)
    {
        $sql = "UPDATE productstock 
                SET low_stock_threshold = ? 
                WHERE productID = ? 
                AND sizeID = ? ";

        $stmt = $this->pdo->prepare($sql);
        $success = $stmt->execute($low_stock_threshold, $productID, $sizeID);

        if ($success && $stmt->rowCount() > 0) {
            return true; // Update successful
        } else {
            return false; // Either no such product-size match, or no change needed
        }
    }

    // update product stock ; 
    public function update_product_stock($quantity, $productID, $sizeID)
    {
        $sql = "UPDATE productstock
                SET 
                    stock = stock + ?,
                    alert_sent = 
                    CASE 
                        WHEN (stock + ?) > low_stock_threshold THEN 0 
                        ELSE alert_sent 
                    END
                WHERE 
                    productID = ? AND
                    sizeID = ? ";
        $stmt = $this->pdo->prepare($sql);
        $success = $stmt->execute([$quantity, $quantity, $productID, $sizeID]);

        if ($success && $stmt->rowCount() > 0) {
            return true; // Update successful
        } else {
            return false; // Either no such product-size match, or no change needed
        }
    }


    public function getAllRestockRecords() {
        try {
            $sql = "SELECT rh.*, p.seriesID 
                    FROM restock_history rh
                    JOIN product p ON rh.productID = p.productID
                    ORDER BY rh.restock_time DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching restock records: " . $e->getMessage());
            return [];
        }
    }
    public function getFilteredRestockRecords($filters) {
        try {
            // 4. Base SQL with LEFT JOIN and starting WHERE 1=1
            $sql = "SELECT 
                        rh.*, 
                        p.seriesID
                    FROM restock_history rh
                    LEFT JOIN product p ON rh.productID = p.productID
                    WHERE 1=1
            ";
    
            $params = [];
    
            // 5. Dynamic filters
            if (!empty($filters['productID'])) {
                $sql .= " AND rh.productID = ?";
                $params[] = $filters['productID'];
            }
    
            if (!empty($filters['sizeID'])) {
                $sql .= " AND rh.sizeID = ?";
                $params[] = $filters['sizeID'];
            }
    
            if (!empty($filters['restocked_by'])) {
                $sql .= " AND rh.restocked_by = ?";
                $params[] = $filters['restocked_by'];
            }
    
            if (!empty($filters['startDate']) && !empty($filters['endDate'])) {
                $sql .= " AND rh.restock_time BETWEEN ? AND ?";
                $params[] = $filters['startDate'] . " 00:00:00";
                $params[] = $filters['endDate'] . " 23:59:59";
            }
    
            // 6. Order by latest restock time
            $sql .= " ORDER BY rh.restock_time DESC";
    
            // 7. Prepare and execute the statement
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            
            // 8. Return the result
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //echo '<pre>';
            //print_r($records);
            // echo '</pre>';

            return $records ; 
    
        } catch (Exception $e) {
            // 9. Catch and throw exception with specific message
            throw new Exception("Error filtering restock records: " . $e->getMessage());
        }
    }
    


    public function record_restock($productID, $sizeID, $quantity, $price, $admin)
    {
        // 2. Updated SQL to insert into 5 columns including restock_price
        $sql = "INSERT INTO restock_history (productID, sizeID, restock_quantity, restock_price, restocked_by)
                VALUES (?, ?, ?, ?, ?)";

        // 3. Prepare and execute the statement with new price field
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$productID, $sizeID, $quantity, $price, $admin]);
    }


    public function getDetailedProductInfo($productID, $sizeID)
    {
        $sql = "SELECT 
                    p.productName, p.price, 
                    ps.stock, ps.alert_sent, ps.low_stock_threshold 
                FROM productstock ps
                JOIN product p ON p.productID = ps.productID
                WHERE ps.productID = ? AND ps.sizeID = ?
                LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$productID, $sizeID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function filterProduct($filters)
    {
        try {
            $sql = "SELECT 
                        p.productID, 
                        p.productName, 
                        p.price, 
                        p.seriesID, 
                        s.seriesName, 
                        ps.sizeID,
                        p.introduction,
                        p.playerInfo,
                        ps.status,
                        ps.stock AS total_stock
                    FROM product p
                    LEFT JOIN productstock ps ON p.productID = ps.productID
                    LEFT JOIN series s ON p.seriesID = s.seriesID
                    WHERE 1=1
            ";
            $params = [];

            if (!empty($filters['productID'])) {
                $sql .= " AND p.productID = ?";
                $params[] = $filters['productID'];
            }
            if (!empty($filters['seriesID'])) {
                $sql .= " AND p.seriesID = ?";
                $params[] = $filters['seriesID'];
            }
            if (isset($filters['priceMin'])) {
                $sql .= " AND p.price >= ?";
                $params[] = $filters['priceMin'];
            }
            if (isset($filters['priceMax'])) {
                $sql .= " AND p.price <= ?";
                $params[] = $filters['priceMax'];
            }
            if (!empty($filters['sizeID'])) {
                $sql .= " AND ps.sizeID = ?";
                $params[] = $filters['sizeID'];
            }

            // Only include under-threshold stocks
            $sql .= " AND ps.stock < ps.low_stock_threshold";

            $sql .= " ORDER BY p.productID, ps.sizeID";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error filtering products: " . $e->getMessage());
        }
    }


    public function search($searchText)
    {
        try {
            $like = '%' . $searchText . '%';
            $sql = "SELECT 
                        p.productID, 
                        p.productName, 
                        p.price, 
                        p.seriesID, 
                        s.seriesName, 
                        ps.sizeID, 
                        ps.status,
                        ps.stock AS total_stock
                    FROM product p
                    JOIN series s ON p.seriesID = s.seriesID 
                    JOIN productstock ps ON p.productID = ps.productID 
                    WHERE (
                        p.productName LIKE ? 
                        OR p.productID LIKE ? 
                        OR s.seriesName LIKE ? 
                        OR s.seriesID LIKE ?
                        )
                    AND ps.stock < ps.low_stock_threshold
            ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$like, $like, $like, $like]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error searching products: " . $e->getMessage());
        }
    }
}
// here is just for test ; 


// 1. where php
// 2. copy this file path 
// schtasks /Create /SC MINUTE /MO 30 /TN "CheckLowStock" /TR "\"--REPLACE WITH YOUR PHP FILE PATH--" \" --REPLACE WITH YOUR FILE PATH --"" /F

// check : schtasks /Query /TN "CheckLowStock"
// run : schtasks /Run /TN "CheckLowStock"
// delete : schtasks /Delete /TN "CheckLowStock" /F
