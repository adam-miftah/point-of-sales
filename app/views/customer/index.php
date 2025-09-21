<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Manajemen Pelanggan</h2>
    <a href="index.php?controller=customer&action=create" class="btn btn-primary">
        + Tambah Pelanggan Baru
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
                        <th>Nama Pelanggan</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th width="150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($customers)): ?>
                        <?php $no = 1; ?>
                        <?php foreach ($customers as $customer): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($customer['nama_customer']); ?></td>
                                <td><?= htmlspecialchars($customer['alamat']); ?></td>
                                <td><?= htmlspecialchars($customer['telp']); ?></td>
                                <td><?= htmlspecialchars($customer['email']); ?></td>
                                <td>
                                    <a href="index.php?controller=customer&action=edit&id=<?= $customer['id_customer']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="index.php?controller=customer&action=delete&id=<?= $customer['id_customer']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data pelanggan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>