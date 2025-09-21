<h2>Tambah Pengguna Baru</h2>
<hr>

<div class="card shadow">
    <div class="card-body">
        <form action="index.php?controller=user&action=create" method="POST">
            <div class="form-group">
                <label for="nama_user">Nama Lengkap</label>
                <input type="text" name="nama_user" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="id_level">Level Pengguna</label>
                <select name="id_level" class="form-control" required>
                    <option value="">-- Pilih Level --</option>
                    <?php foreach ($levels as $level): ?>
                        <option value="<?= $level['id_level']; ?>"><?= htmlspecialchars($level['level']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php?controller=user&action=index" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>