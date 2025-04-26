<?php
require_once __DIR__ . '/../../db_connection.php';

// 1. fetch data form url : 
$reportType = $_GET['reportType'] ?? null;
$start = $_GET['from'] ?? null;
$end   = $_GET['end'] ?? null;

// 2. validation : ensure all value is existing 
if (!$reportType || !$start || !$end) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error'   => 'Missing required parameters. Please provide reportType, from, and end.'
    ]);
    exit();
}

// 2.1 validation : ensure value is valid 
$allowedTypes = ['Sales'];
if (!in_array($reportType, $allowedTypes)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error'   => 'Invalid report type. Allowed values are: Sales, Inventory, All.'
    ]);
    exit();
}

// 2.2 validation : ensure data type is in valid format 
$startDate = DateTime::createFromFormat('Y-m-d', $start);
$endDate   = DateTime::createFromFormat('Y-m-d', $end);
if (!$startDate || !$endDate) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error'   => 'Invalid date format. Dates must be in YYYY-MM-DD format.'
    ]);
    exit();
}
if ($startDate > $endDate) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error'   => '"from" date cannot be later than "end" date.'
    ]);
    exit();
}

// 3. execute : 
try {

    $responseData = [];

    // For Sales    , run the Sales report query
    if ($reportType === 'Sales' || $reportType === 'All') {
        $salesData = getTop5ProductSales($_db, $start, $end);
        $responseData['sales'] = $salesData;
    }


    echo json_encode([
        'success' => true,
        'data'    => $responseData
    ]);
    exit();

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error'   => $e->getMessage()
    ]);
    exit();
}

// --- Functions ---


function getTop5ProductSales(PDO $_db, string $start, string $end): array {
    $sql = "
        SELECT 
            p.productID,
            p.productName,
            SUM(oi.quantity) AS total_sold,
            SUM(oi.subtotal) AS total_revenue
        FROM order_items oi
        JOIN product p ON oi.productId = p.productID
        JOIN orders o ON oi.orderId = o.orderId
        WHERE o.orderDate BETWEEN ? AND ?
        GROUP BY p.productID
        ORDER BY total_sold DESC
        LIMIT 5
    ";

    $stmt = $_db->prepare($sql);
    if (!$stmt) {
        throw new Exception('Sales report: Statement preparation failed.');
    }

    $stmt->execute([$start, $end]);

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $data = [];
    foreach ($rows as $row) {
        $data[] = [
            'productID'     => $row['productID'],
            'productName'   => $row['productName'],
            'total_sold'    => (int)$row['total_sold'],
            'total_revenue' => (float)$row['total_revenue']
        ];
    }

    return $data;
}

