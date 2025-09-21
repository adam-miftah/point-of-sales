<h2>Tambah Item Baru</h2>
<hr>

<div class="card shadow">
    <div class="card-body">
        <form action="index.php?controller=item&action=create" method="POST">
            <div class="form-group">
                <label for="nama_item">Nama Item</label>
                <input type="text" name="nama_item" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="uom">Satuan (Contoh: Pcs, Kg, Box)</label>
                <input type="text" name="uom" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="harga_beli">Harga Beli</label>
                <input type="number" name="harga_beli" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="harga_jual">Harga Jual</label>
                <input type="number" name="harga_jual" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php?controller=item&action=index" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>