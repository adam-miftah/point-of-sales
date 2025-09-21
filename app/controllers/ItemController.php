<?php
// Pastikan path ke model sudah benar
require_once __DIR__ . '../../models/Item.php';

class ItemController {

    /**
     * Menampilkan daftar semua item.
     */
    public function index() {
        $items = Item::all();
        
        // Panggil layout lengkap untuk membungkus view
        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/layout/sidebar.php';
        require __DIR__ . '/../views/item/index.php';
        require __DIR__ . '/../views/layout/footer.php';
    }

    /**
     * Menampilkan form untuk membuat item baru.
     */
    public function create() {
        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/layout/sidebar.php';
        require __DIR__ . '/../views/item/create.php';
        require __DIR__ . '/../views/layout/footer.php';
    }

    /**
     * Menyimpan data item baru dari form (request POST).
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nama_item'  => $_POST['nama_item'] ?? '',
                'uom'        => $_POST['uom'] ?? '',
                'harga_beli' => $_POST['harga_beli'] ?? 0,
                'harga_jual' => $_POST['harga_jual'] ?? 0,
                 'stok'       => $_POST['stok'] ?? 0 
            ];
            Item::create($data);
            // Redirect kembali ke halaman daftar item
            header("Location: index.php?controller=item&action=index");
            exit;
        }
    }

    /**
     * Menampilkan form untuk mengedit item.
     */
    public function edit($id) {
        $item = Item::find($id);
        
        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/layout/sidebar.php';
        require __DIR__ . '/../views/item/edit.php';
        require __DIR__ . '/../views/layout/footer.php';
    }

    /**
     * Mengupdate data item dari form edit (request POST).
     */
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nama_item'  => $_POST['nama_item'] ?? '',
                'uom'        => $_POST['uom'] ?? '',
                'harga_beli' => $_POST['harga_beli'] ?? 0,
                'harga_jual' => $_POST['harga_jual'] ?? 0,
                 'stok'       => $_POST['stok'] ?? 0
            ];
            Item::update($id, $data);
            header("Location: index.php?controller=item&action=index");
            exit;
        }
    }

    /**
     * Menghapus data item.
     */
    public function delete($id) {
        Item::delete($id);
        header("Location: index.php?controller=item&action=index");
        exit;
    }
}