<?php
require_once __DIR__ . '../../models/CustomerModel.php';
require_once __DIR__ . '../../models/Item.php';
require_once __DIR__ . '../../models/SalesModel.php';
require_once __DIR__ . '../../models/TransactionModel.php';
require_once __DIR__ . '../../models/Identitas.php';
require_once __DIR__ . '/../../app/config/Database.php';

class SalesController {

    /**
     * METHOD BARU: Menampilkan daftar semua riwayat penjualan.
     */
    public function index() {
        $sales = SalesModel::all();
        
        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/layout/sidebar.php';
        require __DIR__ . '/../views/sales/index.php';
        require __DIR__ . '/../views/layout/footer.php';
    }

    /**
     * Menampilkan form untuk membuat transaksi baru.
     */
    public function create() {
        $customers = CustomerModel::all();
        $items = Item::all();
        
        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/layout/sidebar.php';
        require __DIR__ . '/../views/sales/create.php';
        require __DIR__ . '/../views/layout/footer.php';
    }

    /**
     * Menyimpan data transaksi baru ke database.
     */
    public function store() {
        if (empty($_POST['id_customer'])) {
            die("Error: Silakan pilih pelanggan terlebih dahulu. <a href='javascript:history.back()'>Kembali</a>");
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['items'])) {
            header('Location: index.php?controller=sales&action=create');
            exit;
        }

        $db = Database::getInstance();
        try {
            $db->beginTransaction();

            $salesData = [
                'id_customer' => $_POST['id_customer'],
                'id_user'     => $_SESSION['user_id'],
                'tgl_sales'   => $_POST['tgl_sales'],
                'status'      => 'Selesai'
            ];
            $salesId = SalesModel::create($salesData);

            if (!$salesId) {
                throw new Exception("Gagal membuat record penjualan utama.");
            }

            foreach ($_POST['items'] as $item) {
                $amount = $item['price'] * $item['quantity'];
                $transactionData = [
                    'id_sales'   => $salesId,
                    'id_item'    => $item['id_item'],
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'],
                    'amount'     => $amount
                ];
                TransactionModel::create($transactionData);
            }

            $db->commit();
            header('Location: index.php?controller=sales&action=receipt&id=' . $salesId);
            exit;

        } catch (Exception $e) {
            $db->rollBack();
            die("Transaksi Gagal: " . $e->getMessage());
        }
    }

    /**
     * METHOD BARU: Menampilkan detail transaksi (sama dengan receipt).
     */
    public function detail($id) {
        $this->receipt($id);
    }
    
    /**
     * Menampilkan halaman nota/receipt untuk dicetak.
     */
    public function receipt($id) {
        $sale = SalesModel::findWithDetails($id);
        $transactions = TransactionModel::findAllBySalesId($id);
        $identity = Identitas::find(1);

        if (!$sale) {
            die("Transaksi tidak ditemukan.");
        }

        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/layout/sidebar.php';
        require __DIR__ . '/../views/sales/receipt.php';
        require __DIR__ . '/../views/layout/footer.php';
    }
     public function edit($id) {
        $sale = SalesModel::find($id);
        $customers = CustomerModel::all(); // Data untuk dropdown pelanggan

        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/layout/sidebar.php';
        require __DIR__ . '/../views/sales/edit.php';
        require __DIR__ . '/../views/layout/footer.php';
    }
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id_customer' => $_POST['id_customer'],
                'tgl_sales'   => $_POST['tgl_sales'],
                'status'      => $_POST['status']
            ];
            SalesModel::update($id, $data);
            header("Location: index.php?controller=sales&action=index");
            exit;
        }
    }

    public function delete($id) {
        SalesModel::delete($id);
        header("Location: index.php?controller=sales&action=index");
        exit;
    }
}