<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pelanggan</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; font-size: 12px; }
        th { background-color: #f2f2f2; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        h2 { text-align: center; }
    </style>
</head>
<body>

    <h2>Laporan Pelanggan</h2>

    <?php if (!empty($keyword)): ?>
        <p class="text-center">
            Hasil pencarian untuk: <strong><?= htmlspecialchars($keyword) ?></strong>
        </p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Alamat</th>
                <th>Telepon</th>
                <th class="text-center">Jml Transaksi</th>
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

</body>
</html>