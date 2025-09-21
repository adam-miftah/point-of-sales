<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Manajemen Pengguna</h2>
    <a href="index.php?controller=user&action=create" class="btn btn-primary">
        + Tambah Pengguna Baru
    </a>
</div>
<hr>

<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Level</th>
                        <th width="150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php $no = 1; foreach ($users as $user): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($user['nama_user']); ?></td>
                                <td><?= htmlspecialchars($user['username']); ?></td>
                                <td><span class="badge badge-info"><?= htmlspecialchars($user['level']); ?></span></td>
                                <td>
                                    <a href="index.php?controller=user&action=edit&id=<?= $user['id_user']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="index.php?controller=user&action=delete&id=<?= $user['id_user']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin?');">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center">Belum ada data pengguna.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>