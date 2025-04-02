<?php

// 1. meation thgat return as json type 
header('Content-Type: application/json');

// 2, include file to call out the service 
include_once __DIR__ . "/../../db/productStock.php";
include_once __DIR__ . "/../../db_connection.php";

    // 2.1 make class 

    $manager = new $checkStock($_db);

// 3. get data from frontend :
$method = $_SERVER['REQUEST_METHOD'];
$data = ($method === 'POST') ? $_POST : $_GET;

$response = [
    "success" => false,
    "message" => "Invalid request",
];

if (isset($data['action'])) {
    switch ($data['action']) {

        case 'change_threshold':
            if (isset($data['low_stock_threshold'], $data['productID'], $data['sizeID'])) {
                $success = $manager->change_low_stock_threshold(
                    $data['low_stock_threshold'],
                    $data['productID'],
                    $data['sizeID']
                );
                $response['success'] = $success;
                $response['message'] = $success ? "Threshold updated" : "No update made";
            }
            break;

        case 'update_stock':
            if (isset($data['quantity'], $data['productID'], $data['sizeID'])) {
                $success = $manager->update_product_stock(
                    $data['quantity'],
                    $data['productID'],
                    $data['sizeID']
                );
                $response['success'] = $success;
                $response['message'] = $success ? "Stock updated" : "No update made";
            }
            break;

        case 'record_restock':
            if (isset($data['productID'], $data['sizeID'], $data['quantity'], $data['admin'])) {
                $success = $manager->record_restock(
                    $data['productID'],
                    $data['sizeID'],
                    $data['quantity'],
                    $data['admin']
                );
                $response['success'] = $success;
                $response['message'] = $success ? "Restock recorded" : "Error recording restock";
            }
            break;

        default:
            $response['message'] = "Unknown action";
    }
}

echo json_encode($response);
exit;



?> 