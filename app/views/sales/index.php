<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Riwayat Penjualan</h2>
    <a href="index.php?controller=sales&action=create" class="btn btn-primary">
        + Buat Transaksi Baru
    </a>
</div>
<hr>

<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID Penjualan</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Kasir</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($sales)): ?>
                        <?php foreach ($sales as $sale): ?>
                            <tr>
                                <td><?= htmlspecialchars($sale['id_sales']); ?></td>
                                <td><?= htmlspecialchars($sale['tgl_sales']); ?></td>
                                <td><?= htmlspecialchars($sale['nama_customer']); ?></td>
                                <td><?= htmlspecialchars($sale['nama_user']); ?></td>
                                <td><span class="badge badge-success"><?= htmlspecialchars($sale['status']); ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Belum ada riwayat penjualan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>