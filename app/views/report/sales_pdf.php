<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        h2 { text-align: center; }
    </style>
</head>
<body>

    <h2>Laporan Penjualan</h2>
    <p class="text-center">
        Periode: <?= date("d F Y", strtotime($startDate)) ?> s/d <?= date("d F Y", strtotime($endDate)) ?>
    </p>

    <table>
        <thead>
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