<h2 class="mb-4">Pengaturan Identitas Usaha</h2>

<?php if (isset($_GET['status']) && $_GET['status'] === 'sukses'): ?>
    <div class="alert alert-success">
        Data identitas berhasil diperbarui.
    </div>
<?php endif; ?>

<div class="card shadow">
    <div class="card-body">
        <form action="index.php?controller=identitas&action=identitas" method="POST">
            <input type="hidden" name="id_identitas" value="<?= $identitas['id_identitas']; ?>">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama_identitas">Nama Usaha/Koperasi</label>
                        <input type="text" name="nama_identitas" class="form-control" value="<?= htmlspecialchars($identitas['nama_identitas'] ?? ''); ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="badan_hukum">Badan Hukum</label>
                        <input type="text" name="badan_hukum" class="form-control" value="<?= htmlspecialchars($identitas['badan_hukum'] ?? ''); ?>">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" class="form-control" rows="3"><?= htmlspecialchars($identitas['alamat'] ?? ''); ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="telp">Nomor Telepon</label>
                        <input type="text" name="telp" class="form-control" value="<?= htmlspecialchars($identitas['telp'] ?? ''); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($identitas['email'] ?? ''); ?>">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="npwp">NPWP</label>
                        <input type="text" name="npwp" class="form-control" value="<?= htmlspecialchars($identitas['npwp'] ?? ''); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="url">Website</label>
                        <input type="text" name="url" class="form-control" value="<?= htmlspecialchars($identitas['url'] ?? ''); ?>">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="rekening">Informasi Rekening</label>
                <input type="text" name="rekening" class="form-control" value="<?= htmlspecialchars($identitas['rekening'] ?? ''); ?>">
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>