<h2>Edit Pengguna: <?= htmlspecialchars($user['nama_user']); ?></h2>
<hr>

<div class="card shadow">
    <div class="card-body">
        <form action="index.php?controller=user&action=edit&id=<?= $user['id_user']; ?>" method="POST">
            <div class="form-group">
                <label for="nama_user">Nama Lengkap</label>
                <input type="text" name="nama_user" class="form-control" value="<?= htmlspecialchars($user['nama_user']); ?>" required>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="form-group">
                <label for="id_level">Level Pengguna</label>
                <select name="id_level" class="form-control" required>
                    <option value="">-- Pilih Level --</option>
                    <?php foreach ($levels as $level): ?>
                        <option value="<?= $level['id_level']; ?>" <?= ($level['id_level'] == $user['id_level']) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($level['level']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <hr>
            <div class="form-group">
                <label for="password">Password Baru</label>
                <input type="password" name="password" class="form-control">
                <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="index.php?controller=user&action=index" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>