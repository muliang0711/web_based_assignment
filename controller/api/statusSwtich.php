<?php
// File: /controller/api/updateStatusController.php

require_once __DIR__ . "/../../db_connection.php";
require_once __DIR__ . "/../../db/productDb.php";

header('Content-Type: application/json');

// Read JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validate input
if (!isset($data['productID'], $data['sizeID'], $data['status']) ||
    !in_array($data['status'], ['onsales', 'notonsales'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
    exit();
}

// Extract
$productID = $data['productID'];
$sizeID = $data['sizeID'];
$status = $data['status'];

// Call DB update
$productDb = new productDb($_db);
$result = $productDb->updateProductStatus($productID, $sizeID, $status);

// Response
if ($result['success']) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $result['error'] ?? 'Database error']);
}
exit();
