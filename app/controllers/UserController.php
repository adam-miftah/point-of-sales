<?php
// Memanggil kedua model yang dibutuhkan
require_once __DIR__ . '../../models/UserModel.php';
require_once __DIR__ . '../../models/Level.php';

class UserController {

    /**
     * Menampilkan daftar semua pengguna.
     */
    public function index() {
        // Method all() di UserModel sudah kita buat untuk join dengan tabel levels
        $users = UserModel::all();
        
        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/layout/sidebar.php';
        require __DIR__ . '/../views/user/index.php';
        require __DIR__ . '/../views/layout/footer.php';
    }

    /**
     * Menampilkan form untuk membuat pengguna baru.
     */
    public function create() {
        // Ambil data semua level untuk ditampilkan di dropdown form
        $levels = Level::all();
        
        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/layout/sidebar.php';
        require __DIR__ . '/../views/user/create.php';
        require __DIR__ . '/../views/layout/footer.php';
    }

    /**
     * Menyimpan data pengguna baru dari form (request POST).
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nama_user'  => $_POST['nama_user'] ?? '',
                'username'   => $_POST['username'] ?? '',
                'password'   => $_POST['password'] ?? '',
                'id_level'   => $_POST['id_level'] ?? 0
            ];
            UserModel::create($data); // Model akan menghash password
            header("Location: index.php?controller=user&action=index");
            exit;
        }
    }

    /**
     * Menampilkan form untuk mengedit pengguna.
     */
    public function edit($id) {
        $user = UserModel::find($id);
        $levels = Level::all();
        
        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/layout/sidebar.php';
        require __DIR__ . '/../views/user/edit.php';
        require __DIR__ . '/../views/layout/footer.php';
    }

    /**
     * Mengupdate data pengguna dari form edit (request POST).
     */
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nama_user'  => $_POST['nama_user'] ?? '',
                'username'   => $_POST['username'] ?? '',
                'password'   => $_POST['password'] ?? '', // Password baru (opsional)
                'id_level'   => $_POST['id_level'] ?? 0
            ];
            UserModel::update($id, $data); // Model akan menangani jika password kosong
            header("Location: index.php?controller=user&action=index");
            exit;
        }
    }

    /**
     * Menghapus data pengguna.
     */
    public function delete($id) {
        UserModel::delete($id);
        header("Location: index.php?controller=user&action=index");
        exit;
    }
}