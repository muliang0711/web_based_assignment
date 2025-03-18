<?php

require_once __DIR__ . "/../_base.php";

class ProductAnlysis{

    private $pdo ;

    public function __construct($_db){
        $this->pdo = $_db ;
    }

    public function handleRequest(){
        
        if(!is_post()){
            return; 
        }
        $action = $_POST['action'] ?? null;
        switch ($action) {
            case 'totalProductionSales':
                $this->totalProductionSales(); // done 
                break;
            case 'totalOrderMade':
                $this->totalOrderMade();
                break ; 
            default:
            ////
    }

    private function handleTotalSellTrack() {
        $filterData = [
            'startDate' => $_POST['startDate'] ?? null,
            'endDate' => $_POST['endDate'] ?? null,
            'status' => $_POST['status'] ?? null,
        ];
        
        $response = $this->productDb->totalsellTrack($filterData);
        $_SESSION['total_sales_results'] = $response['success'] ? $response['data'] : [];
        
        header('Location : ../pages/admin/admin_test.php');
        exit();
    }

    private function handleProductSellTrack() {
        $filterData = [
            'startDate' => $_POST['startDate'] ?? null,
            'endDate' => $_POST['endDate'] ?? null,
            'sizeID' => $_POST['sizeID'] ?? null,
        ];
        
        $response = $this->productDb->productSellTrack($filterData);
        $_SESSION['product_sales_results'] = $response['success'] ? $response['data'] : [];
        
        header('Location : ../pages/admin/admin_test.php');
        exit();
    }


}
?>