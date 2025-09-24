<?php
// Mencegah akses langsung ke file dan memulai session
// Sebaiknya baris ini ada di file index.php utama Anda
// if (session_status() == PHP_SESSION_NONE) {
//     session_start();
// }

/**
 * ==================================================================
 * 1. DAFTAR SEMUA CONTROLLER
 * Pastikan semua path file ini sudah benar sesuai struktur folder Anda.
 * ==================================================================
 */
require_once __DIR__ . '/app/controllers/AuthController.php';
require_once __DIR__ . '/app/controllers/DashboardController.php';
require_once __DIR__ . '/app/controllers/CustomerController.php';
require_once __DIR__ . '/app/controllers/ItemController.php';
require_once __DIR__ . '/app/controllers/UserController.php';
require_once __DIR__ . '/app/controllers/LevelController.php';
require_once __DIR__ . '/app/controllers/IdentitasController.php';
require_once __DIR__ . '/app/controllers/SalesController.php';
require_once __DIR__ . '/app/controllers/TransactionController.php';
require_once __DIR__ . '/app/controllers/ReportController.php';

/**
 * ==================================================================
 * 2. AMBIL PARAMETER DARI URL
 * Menentukan controller dan action apa yang akan dijalankan.
 * ==================================================================
 */
$controller_name = $_GET['controller'] ?? 'dashboard';
$action          = $_GET['action'] ?? 'index';
$id              = $_GET['id'] ?? null;

// Tentukan halaman mana saja yang hanya boleh diakses oleh Admin
$adminOnlyPages = ['user', 'report', 'identitas'];

// Cek jika pengguna BUKAN Admin DAN mencoba mengakses halaman khusus Admin
if (isset($_SESSION['level']) && $_SESSION['level'] != 1 && in_array($controller_name, $adminOnlyPages)) {
    // Jika ya, tolak aksesnya
    http_response_code(403); // Kode 403 artinya "Forbidden" atau "Terlarang"
    die("<h1>Akses Ditolak!</h1><p>Anda tidak memiliki hak untuk mengakses halaman ini.</p><a href='index.php'>Kembali ke Dashboard</a>");
}

// Jika belum login, paksa ke halaman login, kecuali jika memang tujuannya halaman auth
if (!isset($_SESSION['user_id']) && $controller_name !== 'auth') {
    $controller_name = 'auth';
    $action = 'login';
}

/**
 * ==================================================================
 * 3. INISIALISASI CONTROLLER
 * Membuat objek controller yang sesuai berdasarkan parameter URL.
 * ==================================================================
 */
$ctrl = null;
switch ($controller_name) {
    case 'auth':
        $ctrl = new AuthController();
        break;
    case 'dashboard':
        $ctrl = new DashboardController();
        break;
    case 'customer':
        $ctrl = new CustomerController();
        break;
    case 'item':
        $ctrl = new ItemController();
        break;
    case 'user':
        $ctrl = new UserController();
        break;
    case 'level':
        $ctrl = new LevelController();
        break;
    case 'identitas':
        $ctrl = new IdentitasController();
        break;
    case 'sales':
        $ctrl = new SalesController();
        break;
    case 'transaction':
        $ctrl = new TransactionController();
        break;
    case 'report': 
        $ctrl = new ReportController();
        break;
    default:
        http_response_code(404);
        echo "404 - Controller tidak ditemukan.";
        exit;
}

/**
 * ==================================================================
 * 4. EKSEKUSI METHOD (ACTION)
 * Memanggil method yang tepat berdasarkan request GET atau POST.
 * ==================================================================
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Jika request adalah POST (mengirim data dari form)
    switch ($action) {
        case 'login':
            $ctrl->processLogin();
            break;
        case 'create':
            $ctrl->store();
            break;
        case 'edit':
            if ($id) $ctrl->update($id);
            break;
        case 'identitas':
            $ctrl->update();
            break;
        case 'customers': 
            $ctrl->customers();
            break;
        case 'items': 
            $ctrl->items();
            break;
        default:
            http_response_code(404);
            echo "404 - Aksi POST tidak valid.";
            break;
    }
} else {
    // Jika request adalah GET (menampilkan halaman)
    switch ($action) {
        case 'index':
            $ctrl->index();
            break;
        case 'create':
            $ctrl->create();
            break;
        case 'edit':
            if ($id) $ctrl->edit($id);
            break;
        case 'delete':
            if ($id) $ctrl->delete($id);
            break;
        case 'detail':
            if ($id) $ctrl->detail($id);
            break;
        case 'receipt':
            if ($id) $ctrl->receipt($id);
            break;
        case 'login':
            $ctrl->showLoginForm();
            break;
        case 'logout':
            $ctrl->logout();
            break;
        case 'sales':
             if ($controller_name == 'report') $ctrl->sales();
            break;
        case 'customers':
            if ($controller_name == 'report') $ctrl->customers();
            break;
        case 'items':
            if ($controller_name == 'report') $ctrl->items();
            break;
        case 'printPdf':
            if ($controller_name == 'report') $ctrl->printPdf();
            break;
        case 'exportExcel':
            if ($controller_name == 'report') $ctrl->exportExcel();
            break;
        case 'printCustomersPdf':
            if ($controller_name == 'report') $ctrl->printCustomersPdf();
            break;
        case 'printItemsPdf': 
            if ($controller_name == 'report') $ctrl->printItemsPdf(); 
            break;
        default:
            if ($controller_name == 'report') {
                $ctrl->sales();
            } else {
                $ctrl->index();
            }
            break;
    }
}