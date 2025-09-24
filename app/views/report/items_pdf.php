<!DOCTYPE html> 
<html> 
<head> 
    <title>Laporan Stok dan Penjualan Item</title> 
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

    <h2>Laporan Stok dan Penjualan Item</h2> 

    <?php if (!empty($keyword)): ?> 
        <p class="text-center"> 
            Hasil pencarian untuk: <strong><?= htmlspecialchars($keyword) ?></strong> 
        </p> 
    <?php endif; ?> 

    <table> 
        <thead> 
            <tr> 
                <th>No</th> 
                <th>Nama Item</th> 
                <th>Satuan</th> 
                <th class="text-right">Stok Saat Ini</th> 
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
                        <td class="text-right"><?= $item['stok']; ?></td> 
                        <td class="text-right">Rp <?= number_format($item['harga_jual'], 0, ',', '.'); ?></td> 
                        <td class="text-center"><?= $item['total_terjual'] ?? 0; ?></td> 
                        <td class="text-right">Rp <?= number_format($item['total_pendapatan'] ?? 0, 0, ',', '.'); ?></td> 
                    </tr> 
                <?php endforeach; ?> 
            <?php else: ?> 
                <tr> 
                    <td colspan="7" class="text-center">Data tidak ditemukan.</td> 
                </tr> 
            <?php endif; ?> 
        </tbody> 
    </table> 

</body> 
</html>