<h2>Data Petugas</h2>
<a href="index.php?controller=petugas&action=create">+ Tambah Petugas</a>
<table border="1" cellpadding="5">
    <tr><th>ID</th><th>Username</th><th>Level</th><th>Aksi</th></tr>
    <?php foreach($users as $u): ?>
    <tr>
        <td><?= $u['id'] ?></td>
        <td><?= $u['username'] ?></td>
        <td><?= $u['level'] ?></td>
        <td>
            <a href="index.php?controller=petugas&action=delete&id=<?= $u['id'] ?>" onclick="return confirm('Hapus?')">Hapus</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
