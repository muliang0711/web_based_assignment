<?php

// 1. meation thgat return as json type 
header('Content-Type: application/json');

// 2, include file to call out the service 
include_once __DIR__ . "/../../db/productStock.php";
include_once __DIR__ . "/../../db_connection.php";

// 2.1 make class 
$manager = new CheckStock($_db);

// 3. get data from frontend :
$data = json_decode(file_get_contents('php://input'), true);

$response = [
    "success" => false,
    "message" => "Invalid request",
];

session_start();

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

        case 'get_low_stock_product':
            $result = $manager->get_low_stock_product();
            $response['success'] = true;
            $response['products'] = $result;
            $response['message'] = count($result) . " low-stock products found.";
            break;

        default:
            $response['message'] = "Unknown action";
    }
}

echo json_encode($response);
exit;
