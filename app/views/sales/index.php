<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Daftar Transaksi</h2>
    <a href="index.php?controller=sales&action=create" class="btn btn-primary">
        + Transaksi Baru
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
                        <th>ID Penjualan</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Kasir</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($sales)): ?>
                        <?php $no = 1; ?>
                        <?php foreach ($sales as $sale): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>INV-<?= htmlspecialchars($sale['id_sales']); ?></td>
                                <td><?= date("d F Y, H:i", strtotime($sale['tgl_sales'])); ?></td>
                                <td><?= htmlspecialchars($sale['nama_customer']); ?></td>
                                <td><?= htmlspecialchars($sale['nama_user']); ?></td>
                                <td><span class="badge badge-success"><?= htmlspecialchars($sale['status']); ?></span></td>
                                <td class="text-center">
                                    <a href="index.php?controller=sales&action=detail&id=<?= $sale['id_sales']; ?>" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Belum ada riwayat transaksi.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>