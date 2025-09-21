<?php
// Pastikan path ke model sudah benar
require_once __DIR__ . '../../models/Identitas.php';

class IdentitasController {

    /**
     * Menampilkan form untuk mengedit data identitas.
     * Kita asumsikan data identitas selalu ada di ID = 1.
     */
    public function index() {
        // Ambil data identitas dari database
        $identitas = Identitas::find(1);

        // Jika data tidak ada, tampilkan pesan error
        if (!$identitas) {
            die("Error: Data identitas tidak ditemukan. Silakan isi data awal melalui database.");
        }
        
        // Panggil layout lengkap untuk membungkus view
        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/layout/sidebar.php';
        require __DIR__ . '/../views/identitas/edit.php';
        require __DIR__ . '/../views/layout/footer.php';
    }

    /**
     * Menyimpan perubahan data identitas dari form (request POST).
     */
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Ambil ID dari hidden input di form
            $id = $_POST['id_identitas'];

            // Amankan data dari form (whitelisting)
            $data = [
                'nama_identitas' => $_POST['nama_identitas'] ?? '',
                'badan_hukum'    => $_POST['badan_hukum'] ?? '',
                'alamat'         => $_POST['alamat'] ?? '',
                'telp'           => $_POST['telp'] ?? '',
                'email'          => $_POST['email'] ?? '',
                'npwp'           => $_POST['npwp'] ?? '',
                'url'            => $_POST['url'] ?? '',
                'rekening'       => $_POST['rekening'] ?? ''
            ];
            
            // Panggil method update dari model
            Identitas::update($id, $data);
            
            // Redirect kembali ke halaman yang sama dengan pesan sukses
            header("Location: index.php?controller=identitas&status=sukses");
            exit;
        }
    }
}