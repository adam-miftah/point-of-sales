<h2>Edit Pelanggan: <?= htmlspecialchars($customer['nama_customer']); ?></h2>
<hr>

<div class="card shadow">
    <div class="card-body">
        <form action="index.php?controller=customer&action=edit&id=<?= $customer['id_customer']; ?>" method="POST">
            <div class="form-group">
                <label for="nama_customer">Nama Pelanggan</label>
                <input type="text" name="nama_customer" class="form-control" value="<?= htmlspecialchars($customer['nama_customer']); ?>" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" class="form-control" rows="3"><?= htmlspecialchars($customer['alamat']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="telp">Nomor Telepon</label>
                <input type="text" name="telp" class="form-control" value="<?= htmlspecialchars($customer['telp']); ?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($customer['email']); ?>">
            </div>
            
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="index.php?controller=customer&action=index" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>