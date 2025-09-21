<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; }
        .table th { background-color: #f2f2f2; text-align: left; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .header { text-align: center; margin-bottom: 20px; }
        h2, h4 { margin: 0; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Penjualan</h2>
        <h4>Periode: <?= date("d/m/Y", strtotime($startDate)); ?> s/d <?= date("d/m/Y", strtotime($endDate)); ?></h4>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Penjualan</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Kasir</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($sales)): ?>
                <?php $no = 1; $grandTotal = 0; ?>
                <?php foreach ($sales as $sale): ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td>INV-<?= htmlspecialchars($sale['id_sales']); ?></td>
                        <td><?= date("d/m/Y H:i", strtotime($sale['tgl_sales'])); ?></td>
                        <td><?= htmlspecialchars($sale['nama_customer']); ?></td>
                        <td><?= htmlspecialchars($sale['nama_user']); ?></td>
                        <td class="text-right">Rp <?= number_format($sale['total_penjualan'], 0, ',', '.'); ?></td>
                    </tr>
                    <?php $grandTotal += $sale['total_penjualan']; ?>
                <?php endforeach; ?>
                <tr>
                    <td colspan="5" class="text-right"><strong>Grand Total</strong></td>
                    <td class="text-right"><strong>Rp <?= number_format($grandTotal, 0, ',', '.'); ?></strong></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data untuk periode yang dipilih.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>