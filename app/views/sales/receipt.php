<style>
    .receipt-container {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    .receipt-header { text-align: center; margin-bottom: 20px; }
    .receipt-header h1 { margin: 0; }
    .receipt-details table { width: 100%; line-height: inherit; text-align: left; }
    .receipt-details table td { padding: 5px; vertical-align: top; }
    .receipt-details table tr.top td { padding-bottom: 20px; }
    .receipt-details table tr.heading td { background: #eee; border-bottom: 1px solid #ddd; font-weight: bold; }
    .receipt-details table tr.item td { border-bottom: 1px solid #eee; }
    .receipt-details table tr.total td:last-child { border-top: 2px solid #eee; font-weight: bold; }

    /* CSS untuk menyembunyikan elemen saat di-print */
    @media print {
        body, .receipt-container {
            margin: 0;
            box-shadow: none;
            border: none;
        }
        .no-print {
            display: none !important;
        }
        /* Sembunyikan sidebar saat print */
        #sidebar-wrapper {
            display: none !important;
        }
        #page-content-wrapper {
            width: 100% !important;
        }
    }
</style>

<div class="receipt-container" id="receipt-area">
    <div class="receipt-header">
        <h1>INVOICE</h1>
        <h2><?= htmlspecialchars($identity['nama_identitas']); ?></h2>
        <p><?= htmlspecialchars($identity['alamat']); ?><br>
        Telp: <?= htmlspecialchars($identity['telp']); ?> | Email: <?= htmlspecialchars($identity['email']); ?></p>
    </div>

    <div class="receipt-details">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="4">
                    <table>
                        <tr>
                            <td>
                                <strong>No. Nota:</strong> INV-<?= htmlspecialchars($sale['id_sales']); ?><br>
                                <strong>Tanggal:</strong> <?= date("d F Y", strtotime($sale['tgl_sales'])); ?><br>
                                <strong>Kasir:</strong> <?= htmlspecialchars($sale['nama_user']); ?>
                            </td>
                            <td>
                                <strong>Pelanggan:</strong><br>
                                <?= htmlspecialchars($sale['nama_customer']); ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Item</td>
                <td style="text-align: right;">Harga</td>
                <td style="text-align: center;">Qty</td>
                <td style="text-align: right;">Subtotal</td>
            </tr>

            <?php $grandTotal = 0; ?>
            <?php foreach ($transactions as $item): ?>
                <tr class="item">
                    <td><?= htmlspecialchars($item['nama_item']); ?></td>
                    <td style="text-align: right;">Rp <?= number_format($item['price'], 0, ',', '.'); ?></td>
                    <td style="text-align: center;"><?= $item['quantity']; ?></td>
                    <td style="text-align: right;">Rp <?= number_format($item['amount'], 0, ',', '.'); ?></td>
                </tr>
                <?php $grandTotal += $item['amount']; ?>
            <?php endforeach; ?>

            <tr class="total">
                <td colspan="3" style="text-align: right;"><strong>Total</strong></td>
                <td style="text-align: right;"><strong>Rp <?= number_format($grandTotal, 0, ',', '.'); ?></strong></td>
            </tr>
        </table>
    </div>
</div>

<div class="text-center mt-4 no-print">
    <a href="index.php?controller=sales&action=create" class="btn btn-primary">
        <i class="fas fa-plus"></i> Transaksi Baru
    </a>
    <button onclick="window.print()" class="btn btn-success">
        <i class="fas fa-print"></i> Cetak Nota
    </button>
</div>