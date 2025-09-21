<h2 class="mb-4">Laporan Penjualan</h2>

<div class="card shadow mb-4">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">Filter Berdasarkan Tanggal</h6>
    </div>
    <div class="card-body">
        <form method="GET">
            <input type="hidden" name="controller" value="report">
            <input type="hidden" name="action" value="sales">
            <div class="form-row align-items-end">
                <div class="col-md-4">
                    <label for="start_date">Dari Tanggal</label>
                    <input type="date" name="start_date" class="form-control" value="<?= htmlspecialchars($startDate ?? ''); ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="end_date">Sampai Tanggal</label>
                    <input type="date" name="end_date" class="form-control" value="<?= htmlspecialchars($endDate ?? ''); ?>" required>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary mr-1">Tampilkan</button>
                    
                    <?php if (!empty($startDate) && !empty($endDate)): ?>
                        <a href="index.php?controller=report&action=printPdf&start_date=<?= htmlspecialchars($startDate) ?>&end_date=<?= htmlspecialchars($endDate) ?>" class="btn btn-danger mr-1" target="_blank">
                            <i class="fas fa-file-pdf"></i> PDF
                        </a>
                        <a href="index.php?controller=report&action=exportExcel&start_date=<?= htmlspecialchars($startDate) ?>&end_date=<?= htmlspecialchars($endDate) ?>" class="btn btn-success">
                            <i class="fas fa-file-excel"></i> Excel
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card shadow">
    <div class="card-body">
        <h5 class="mb-3">
            <?php if (!empty($startDate) && !empty($endDate)): ?>
                Menampilkan Laporan Periode: <strong><?= date("d F Y", strtotime($startDate)); ?></strong> s/d <strong><?= date("d F Y", strtotime($endDate)); ?></strong>
            <?php else: ?>
                Silakan pilih rentang tanggal untuk menampilkan laporan.
            <?php endif; ?>
        </h5>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>ID Penjualan</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Kasir</th>
                        <th class="text-right">Total Penjualan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($sales)): ?>
                        <?php $no = 1; $grandTotal = 0; ?>
                        <?php foreach ($sales as $sale): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>INV-<?= htmlspecialchars($sale['id_sales']); ?></td>
                                <td><?= date("d/m/Y h:i", strtotime($sale['tgl_sales'])); ?></td>
                                <td><?= htmlspecialchars($sale['nama_customer']); ?></td>
                                <td><?= htmlspecialchars($sale['nama_user']); ?></td>
                                <td class="text-right">Rp <?= number_format($sale['total_penjualan'], 0, ',', '.'); ?></td>
                            </tr>
                            <?php $grandTotal += $sale['total_penjualan']; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data untuk periode yang dipilih.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <?php if (!empty($sales)): ?>
                <tfoot class="bg-light">
                    <tr>
                        <td colspan="5" class="text-right"><strong>Grand Total</strong></td>
                        <td class="text-right font-weight-bold"><strong>Rp <?= number_format($grandTotal, 0, ',', '.'); ?></strong></td>
                    </tr>
                </tfoot>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>