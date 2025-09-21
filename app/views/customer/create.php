<h2>Tambah Pelanggan Baru</h2>
<hr>

<div class="card shadow">
    <div class="card-body">
        <form action="index.php?controller=customer&action=create" method="POST">
            <div class="form-group">
                <label for="nama_customer">Nama Pelanggan</label>
                <input type="text" name="nama_customer" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="telp">Nomor Telepon</label>
                <input type="text" name="telp" class="form-control">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control">
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php?controller=customer&action=index" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>