<?php
require_once __DIR__ . '../../models/CustomerModel.php';
require_once __DIR__ . '../../models/Item.php';
require_once __DIR__ . '../../models/SalesModel.php';
require_once __DIR__ . '../../models/Identitas.php';
require_once __DIR__ . '../../models/TransactionModel.php';
require_once __DIR__ . '/../../app/config/Database.php'; 

class SalesController {

    /**
     * Menampilkan daftar semua riwayat penjualan.
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
     * Menggunakan database transaction untuk memastikan integritas data.
     */
    public function store() {
        if (empty($_POST['id_customer'])) {
            // Jika customer tidak dipilih, hentikan proses dan beri pesan
            die("Error: Silakan pilih pelanggan terlebih dahulu. <a href='javascript:history.back()'>Kembali</a>");
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['items'])) {
            header('Location: index.php?controller=sales&action=create');
            exit;
        }

        $db = Database::getInstance();
        try {
            // Mulai Transaction
            $db->beginTransaction();

            // 1. Simpan data utama ke tabel 'sales'
            $salesData = [
                'id_customer' => $_POST['id_customer'],
                'id_user'     => $_SESSION['user_id'], // Ambil dari session yang login
                'tgl_sales'   => $_POST['tgl_sales'],
                'status'      => 'Selesai' // Atau status lainnya
            ];
            $salesId = SalesModel::create($salesData);

            if (!$salesId) {
                throw new Exception("Gagal membuat record penjualan utama.");
            }

            // 2. Simpan setiap item di keranjang ke tabel 'transactions'
            $totalAmount = 0;
            foreach ($_POST['items'] as $item) {
                $amount = $item['price'] * $item['quantity'];
                $totalAmount += $amount;

                $transactionData = [
                    'id_sales'   => $salesId,
                    'id_item'    => $item['id_item'],
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'],
                    'amount'     => $amount
                ];
                TransactionModel::create($transactionData);
            }

            // (Opsional) Update total amount di tabel sales jika ada kolomnya
            // SalesModel::updateTotal($salesId, $totalAmount);

            // Jika semua query berhasil, commit transaction
            $db->commit();

            // DIUBAH: Redirect ke halaman nota baru dengan membawa ID penjualan
            header('Location: index.php?controller=sales&action=receipt&id=' . $salesId);
            exit;

        } catch (Exception $e) {
            // Jika ada satu saja query yang gagal, batalkan semua perubahan
            $db->rollBack();
            
            // Tampilkan pesan error atau redirect dengan pesan error
            die("Transaksi Gagal: " . $e->getMessage());
        }
    }
    public function receipt($id) {
        // Ambil semua data yang dibutuhkan dari berbagai model
        $sale = SalesModel::findWithDetails($id);
        $transactions = TransactionModel::findAllBySalesId($id);
        $identity = Identitas::find(1); // Ambil data identitas usaha

        if (!$sale) {
            die("Transaksi tidak ditemukan.");
        }

        // Kita gunakan layout yang sama, tapi view-nya adalah receipt.php
        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/layout/sidebar.php';
        require __DIR__ . '/../views/sales/receipt.php';
        require __DIR__ . '/../views/layout/footer.php';
    }
}