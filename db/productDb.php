<?php
include_once __DIR__ . '/../db_connection.php';

class productDb
{
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function beginTransaction() {
        $this->pdo->beginTransaction();
    }
    public function commitTransaction() {
        $this->pdo->commit();
    }
    public function rollbackTransaction() {
        $this->pdo->rollBack();
    }

    // -------------------------------------------------------------------------
    public function getAllProducts() {
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
                JOIN productstock ps ON p.productID = ps.productID
                JOIN series s ON p.seriesID = s.seriesID
                ORDER BY p.productID, ps.sizeID;
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getSeriesID() {
        $sql = "SELECT seriesID FROM series";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function getProductID() {
        $sql = "SELECT productID FROM product";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    // -------------------------------------------------------------------------
    public function filterProduct($filters) {
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
                        ps.stock AS stock,
                        SUM(ps.stock) OVER (PARTITION BY p.productID) AS total_stock
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

            $sql .= " ORDER BY p.productID, ps.sizeID";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error filtering products: " . $e->getMessage());
        }
    }

    // -------------------------------------------------------------------------
    public function addProductImage($productID, $imagePath, $type)
    {
        try {
            $sql = "INSERT INTO product_images(productID, image_path, image_type)
                    VALUES (?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$productID, $imagePath, $type]);
        } catch (Exception $e) {
            throw new Exception("Error inserting into product_images: " . $e->getMessage());
        }
    }

    // -------------------------------------------------------------------------
    public function addProduct($productInformation)
    {
        // Extract info
        $productID    = $productInformation['productId'];
        $productName  = $productInformation['productName'];
        $seriesID     = $productInformation['seriesId'];
        $sizeID       = $productInformation['sizeId'];
        $seriesName   = $productInformation['seriesName'];
        $price        = $productInformation['price'];
        $stock        = $productInformation['stock'];
        $introduction = $productInformation['introduction'];
        $playerInfo   = $productInformation['playerInfo'];

        try {
            // Insert series if not exist
            $checkSql = "SELECT seriesName FROM series WHERE seriesName = ? AND seriesID = ? LIMIT 1";
            $checkStmt = $this->pdo->prepare($checkSql);
            $checkStmt->execute([$seriesName, $seriesID]);
            if (!$checkStmt->fetch()) {
                $sqlSeries = "INSERT INTO series (seriesID, seriesName) VALUES (?, ?)";
                $stmtSeries = $this->pdo->prepare($sqlSeries);
                $stmtSeries->execute([$seriesID, $seriesName]);
            }

            // Insert product if not exist
            $checkSql = "SELECT productID FROM product WHERE productID = ? LIMIT 1";
            $checkStmt = $this->pdo->prepare($checkSql);
            $checkStmt->execute([$productID]);
            if (!$checkStmt->fetch()) {
                $sqlProd = "INSERT INTO product (productID, productName, price, seriesID, introduction, playerInfo)
                            VALUES (?, ?, ?, ?, ?, ?)";
                $stmtProd = $this->pdo->prepare($sqlProd);
                $stmtProd->execute([$productID, $productName, $price, $seriesID, $introduction, $playerInfo]);
            }

            // Insert/Update productstock
            $sqlStock = "INSERT INTO productstock (productID, sizeID, stock)
                         VALUES (?, ?, ?)
                         ON DUPLICATE KEY UPDATE stock = stock + VALUES(stock)";
            $stmtStock = $this->pdo->prepare($sqlStock);
            $stmtStock->execute([$productID, $sizeID, $stock]);

            return ["success" => true, "message" => "Add successful"];
        } catch (Exception $e) {
            return ["success" => false, "error" => $e->getMessage()];
        }
    }

    // -------------------------------------------------------------------------
    public function updateProducts($productInformation)
    {
        $productID    = $productInformation['productId'];
        $productName  = $productInformation['productName'];
        $sizeID       = $productInformation['sizeId'];
        $price        = $productInformation['price'];
        $stock        = $productInformation['stock'];
        $introduction = $productInformation['introduction'];
        $playerInfo   = $productInformation['playerInfo'];

        try {
            // Update product table
            $sql = "UPDATE product
                    SET productName = ?, price = ?, introduction = ?, playerInfo = ?
                    WHERE productID = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$productName, $price, $introduction, $playerInfo, $productID]);

            // Update productstock
            $sql = "UPDATE productstock
                    SET stock = ?
                    WHERE productID = ? AND sizeID = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$stock, $productID, $sizeID]);

            // Remove old images physically and from DB
            $this->deleteImage($productID);

        } catch (Exception $e) {
            throw new Exception("Error updating product: " . $e->getMessage());
        }
    }

    // -------------------------------------------------------------------------
    public function deleteProduct($productInformation)
    {
        try {
            $productID = $productInformation['productId'];
            $sizeID    = $productInformation['sizeId'];

            // 1. Check if product-size is part of any active (not delivered) order
            $orderCheckStmt = $this->pdo->prepare("
                SELECT COUNT(*) 
                FROM order_items oi
                JOIN orders o ON oi.orderId = o.orderId
                WHERE oi.productId = ? AND oi.gripSize = ? AND o.status != 'Delivered'
            ");
            $orderCheckStmt->execute([$productID, $sizeID]);
            $activeOrders = $orderCheckStmt->fetchColumn();

            if ($activeOrders > 0) {
                return [
                    "success" => false,
                    "message" => "Cannot delete. This product (ID: $productID, Size: $sizeID) is used in an active order."
                ];
            }

            // 2. Delete this specific product-size
            $deleteSizeStmt = $this->pdo->prepare("DELETE FROM productstock WHERE productID = ? AND sizeID = ?");
            $deleteSizeStmt->execute([$productID, $sizeID]);

            // 3. Check if any sizes remain
            $remainingSizesStmt = $this->pdo->prepare("SELECT COUNT(*) FROM productstock WHERE productID = ?");
            $remainingSizesStmt->execute([$productID]);
            $remainingSizes = $remainingSizesStmt->fetchColumn();

            // 4. If no more sizes, delete the product
            if ($remainingSizes == 0) {
                // Remove images
                $this->deleteImage($productID);

                $deleteProductStmt = $this->pdo->prepare("DELETE FROM product WHERE productID = ?");
                $deleteProductStmt->execute([$productID]);

                return [
                    "success" => true,
                    "message" => "Product '$productID' (last size) fully deleted."
                ];
            }

            return [
                "success" => true,
                "message" => "Size '$sizeID' for product '$productID' deleted successfully."
            ];

        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => "Database error: " . $e->getMessage()
            ];
        }
    }

    // -------------------------------------------------------------------------
    public function getProductByIDAndSize($productID, $sizeID)
    {
        $sql = "SELECT 
                    p.productID,
                    p.productName,
                    p.price,
                    p.introduction,
                    p.playerInfo,
                    p.seriesID,
                    s.seriesName,
                    ps.sizeID,
                    ps.stock AS total_stock,
                    GROUP_CONCAT(CASE WHEN pi.image_type = 'product' THEN pi.image_path END) AS product_images,
                    GROUP_CONCAT(CASE WHEN pi.image_type = 'player' THEN pi.image_path END) AS player_images
                FROM product p
                JOIN productstock ps ON p.productID = ps.productID
                JOIN series s ON p.seriesID = s.seriesID
                LEFT JOIN product_images pi ON p.productID = pi.productID
                WHERE p.productID = :productID
                  AND ps.sizeID = :sizeID
                GROUP BY p.productID, ps.sizeID
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':productID' => $productID,
            ':sizeID'    => $sizeID
        ]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            // Convert image paths into arrays
            $product['product_images'] = array_filter(explode(',', $product['product_images'] ?? ''));
            $product['player_images']  = array_filter(explode(',', $product['player_images'] ?? ''));
        }

        return $product;
    }

    // -------------------------------------------------------------------------
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
                    WHERE p.productName LIKE ? 
                    OR s.seriesName LIKE ? 
                    OR s.seriesID LIKE ?
            ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$like, $like, $like]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error searching products: " . $e->getMessage());
        }
    }

    // -------------------------------------------------------------------------
    public function updateProductStatus($productID, $sizeID, $status)
    {
        try {
            $sql = "UPDATE productstock 
                    SET status = ?
                    WHERE productID = ? AND sizeID = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$status, $productID, $sizeID]);

            return ['success' => true];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    // -------------------------------------------------------------------------
    private function deleteImage($productID)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT image_path FROM product_images WHERE productID = ?");
            $stmt->execute([$productID]);
            $images = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $uploadDir = __DIR__ . '/../File';

            // Delete each file from disk
            foreach ($images as $image) {
                $filePath = $uploadDir . '/' . $image['image_path'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // Remove records from DB
            $del = $this->pdo->prepare("DELETE FROM product_images WHERE productID = ?");
            $del->execute([$productID]);

        } catch (Exception $e) {
            throw new Exception("Error when deleting images: " . $e->getMessage());
        }
    }
    
}
