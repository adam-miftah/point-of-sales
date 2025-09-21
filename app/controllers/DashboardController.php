<?php
require_once __DIR__ . '/../models/CustomerModel.php';
require_once __DIR__ . '/../models/Item.php';
require_once __DIR__ . '/../models/SalesModel.php';

class DashboardController {

    public function index() {
        // Ambil data rangkuman dari setiap model
        $totalCustomers = CustomerModel::count();
        $totalItems = Item::count();
        $salesToday = SalesModel::countToday();
        $recentSales = SalesModel::getRecent(5); // Ambil 5 transaksi terbaru

          require __DIR__ . '/../views/layout/header.php';
          require __DIR__ . '/../views/layout/sidebar.php'; 
          require __DIR__ . '/../views/dashboard/index.php'; 
          require __DIR__ . '/../views/layout/footer.php';
    }
}