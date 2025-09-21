<h2 class="mb-4">Laporan Pelanggan</h2>

<div class="card shadow mb-4">
    <div class="card-body">
        <form method="GET">
            <input type="hidden" name="controller" value="report">
            <input type="hidden" name="action" value="customers">
            <div class="form-row align-items-end">
                <div class="col-md-10">
                    <label for="search">Cari Pelanggan (Nama / Alamat / Telepon)</label>
                    <input type="text" name="search" class="form-control" value="<?= htmlspecialchars($keyword ?? ''); ?>" placeholder="Ketik untuk mencari...">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-block">Cari</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card shadow">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Hasil Laporan Pelanggan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th class="text-center">Jumlah Transaksi</th>
                        <th class="text-right">Total Belanja</th>
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
                                <td class="text-center"><?= $customer['jumlah_transaksi']; ?></td>
                                <td class="text-right">Rp <?= number_format($customer['total_belanja'] ?? 0, 0, ',', '.'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Data tidak ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>