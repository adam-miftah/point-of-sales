<h2>Data Transaksi</h2>
<a href="index.php?controller=transaction&action=create">+ Tambah Transaksi</a>
<table border="1" cellpadding="5">
    <tr><th>ID</th><th>Customer</th><th>Total</th><th>Tanggal</th></tr>
    <?php foreach($transactions as $t): ?>
    <tr>
        <td><?= $t['id'] ?></td>
        <td><?= $t['customer_id'] ?></td>
        <td><?= $t['total'] ?></td>
        <td><?= $t['tanggal'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
