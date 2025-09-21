<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Manajemen Item</h2>
    <a href="index.php?controller=item&action=create" class="btn btn-primary">
        + Tambah Item Baru
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
                        <th>Nama Item</th>
                        <th>Satuan</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th width="150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($items)): ?>
                        <?php $no = 1; ?>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($item['nama_item']); ?></td>
                                <td><?= htmlspecialchars($item['uom']); ?></td>
                                <td>Rp <?= number_format($item['harga_beli'], 0, ',', '.'); ?></td>
                                <td>Rp <?= number_format($item['harga_jual'], 0, ',', '.'); ?></td>
                                <td><?= $item['stok']; ?></td>
                                <td>
                                    <a href="index.php?controller=item&action=edit&id=<?= $item['id_item']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="index.php?controller=item&action=delete&id=<?= $item['id_item']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data item.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>