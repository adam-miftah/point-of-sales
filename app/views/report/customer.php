<h2 class="mb-4">Laporan Pelanggan</h2>

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
                            <td colspan="6" class="text-center">Belum ada data pelanggan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>