<h2 class="mb-4">Laporan Stok dan Penjualan Item</h2> 

<div class="card shadow mb-4"> 
    <div class="card-body"> 
        <form method="GET"> 
            <input type="hidden" name="controller" value="report"> 
            <input type="hidden" name="action" value="items"> 
            <div class="form-row align-items-end"> 
                <div class="col-md-9"> 
                    <label for="search">Cari Item (Nama)</label> 
                    <input type="text" name="search" class="form-control" value="<?= htmlspecialchars($keyword ?? ''); ?>" placeholder="Ketik nama item..."> 
                </div> 
                <div class="col-md-3"> 
                    <button type="submit" class="btn btn-primary mr-1">Cari</button> 

                    <a href="index.php?controller=report&action=printItemsPdf&search=<?= htmlspecialchars($keyword ?? '') ?>" class="btn btn-danger mr-1" target="_blank"> 
                        <i class="fas fa-file-pdf"></i> PDF 
                    </a> 

                    <a href="index.php?controller=report&action=exportItems&search=<?= htmlspecialchars($keyword ?? '') ?>" class="btn btn-success"> 
                        <i class="fas fa-file-excel"></i> Excel 
                    </a> 
                </div> 
            </div> 
        </form> 
    </div> 
</div> 

<div class="card shadow"> 
    <div class="card-header py-3"> 
        <h6 class="m-0 font-weight-bold text-primary">Hasil Laporan Stok Item</h6> 
    </div> 
    <div class="card-body"> 
        <div class="table-responsive"> 
            <table class="table table-bordered table-striped"> 
                <thead class="thead-dark"> 
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
        </div> 
    </div> 
</div>