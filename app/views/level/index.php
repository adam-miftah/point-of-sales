<h2>Data Level</h2>
<a href="index.php?controller=level&action=create">+ Tambah Level</a>
<table border="1" cellpadding="5">
    <tr><th>ID</th><th>Nama Level</th><th>Aksi</th></tr>
    <?php foreach($levels as $l): ?>
    <tr>
        <td><?= $l['id'] ?></td>
        <td><?= $l['nama'] ?></td>
        <td>
            <a href="index.php?controller=level&action=delete&id=<?= $l['id'] ?>" onclick="return confirm('Hapus?')">Hapus</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
