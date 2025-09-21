<?php
require_once __DIR__ . '../../models/CustomerModel.php';

class CustomerController {

    /**
     * Menampilkan daftar semua customer.
     */
    public function index() {
        $customers = CustomerModel::all();
        
        // Panggil layout lengkap untuk membungkus view
        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/layout/sidebar.php';
        require __DIR__ . '/../views/customer/index.php';
        require __DIR__ . '/../views/layout/footer.php';
    }

    /**
     * Menampilkan form untuk membuat customer baru.
     */
    public function create() {
        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/layout/sidebar.php';
        require __DIR__ . '/../views/customer/create.php';
        require __DIR__ . '/../views/layout/footer.php';
    }

    /**
     * Menyimpan data customer baru dari form (request POST).
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nama_customer' => $_POST['nama_customer'] ?? '',
                'alamat'        => $_POST['alamat'] ?? '',
                'telp'          => $_POST['telp'] ?? '',
                'email'         => $_POST['email'] ?? ''
            ];
            CustomerModel::create($data);
            // Redirect kembali ke halaman daftar customer
            header("Location: index.php?controller=customer&action=index");
            exit;
        }
    }

    /**
     * Menampilkan form untuk mengedit customer.
     */
    public function edit($id) {
        $customer = CustomerModel::find($id);
        
        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/layout/sidebar.php';
        require __DIR__ . '/../views/customer/edit.php';
        require __DIR__ . '/../views/layout/footer.php';
    }

    /**
     * Mengupdate data customer dari form edit (request POST).
     */
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nama_customer' => $_POST['nama_customer'] ?? '',
                'alamat'        => $_POST['alamat'] ?? '',
                'telp'          => $_POST['telp'] ?? '',
                'email'         => $_POST['email'] ?? ''
            ];
            CustomerModel::update($id, $data);
            header("Location: index.php?controller=customer&action=index");
            exit;
        }
    }

    /**
     * Menghapus data customer.
     */
    public function delete($id) {
        CustomerModel::delete($id);
        header("Location: index.php?controller=customer&action=index");
        exit;
    }
}