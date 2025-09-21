<h2 class="mb-4">Laporan Stok dan Penjualan Item</h2>

<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Item</th>
                        <th>Satuan</th>
                        <th class="text-right">Harga Jual</th>
                        <th class="text-center">Total Terjual</th>
                        <th class="text-right">Total Pendapatan</th>
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
                                <td class="text-right">Rp <?= number_format($item['harga_jual'], 0, ',', '.'); ?></td>
                                <td class="text-center"><?= $item['total_terjual']; ?></td>
                                <td class="text-right">Rp <?= number_format($item['total_pendapatan'], 0, ',', '.'); ?></td>
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