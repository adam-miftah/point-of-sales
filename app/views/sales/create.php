<h2 class="mb-4">Transaksi Baru</h2>

<form action="index.php?controller=sales&action=create" method="POST" id="form-sales">
    
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="id_customer">Pilih Pelanggan</label>
                        <select name="id_customer" id="id_customer" class="form-control" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            <?php foreach ($customers as $customer): ?>
                                <option value="<?= $customer['id_customer']; ?>"><?= htmlspecialchars($customer['nama_customer']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tgl_sales">Tanggal Transaksi</label>
                        <input type="date" name="tgl_sales" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Item ke Keranjang</h6>
        </div>
        <div class="card-body">
            <div class="row align-items-end">
                <div class="col-md-6">
                    <label for="search-item">Cari Item</label>
                    <input type="text" id="search-item" list="item-list" class="form-control" placeholder="Ketik untuk mencari nama item...">
                    <datalist id="item-list">
                        <?php foreach ($items as $item): ?>
                            <option value="<?= htmlspecialchars($item['nama_item']); ?>">
                        <?php endforeach; ?>
                    </datalist>
                </div>
                <div class="col-md-2">
                    <label for="qty">Jumlah</label>
                    <input type="number" id="qty" class="form-control" value="1" min="1">
                </div>
                <div class="col-md-4">
                    <button type="button" id="add-to-cart" class="btn btn-primary">Tambah ke Keranjang</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Keranjang Belanja</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama Item</th>
                            <th>Harga</th>
                            <th width="120px">Qty</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="cart-items">
                        </tbody>
                </table>
            </div>
            <hr>
            <div class="text-right">
                <h4>Total Belanja: <span id="grand-total" class="font-weight-bold">Rp 0</span></h4>
            </div>
        </div>
    </div>

    <div class="text-right">
        <a href="index.php?controller=dashboard" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-success">Simpan Transaksi</button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Siapkan data item dari PHP ke JavaScript
    const itemsData = <?= json_encode($items); ?>;
    let cart = []; // Keranjang belanja

    const searchInput = document.getElementById('search-item');
    const qtyInput = document.getElementById('qty');
    const addToCartBtn = document.getElementById('add-to-cart');
    const cartBody = document.getElementById('cart-items');
    const grandTotalEl = document.getElementById('grand-total');
    const salesForm = document.getElementById('form-sales');

    // Fungsi untuk menambah item ke keranjang
    addToCartBtn.addEventListener('click', function() {
        const itemName = searchInput.value;
        const qty = parseInt(qtyInput.value);

        if (!itemName || qty <= 0) {
            alert('Silakan pilih item dan masukkan jumlah yang valid.');
            return;
        }

        const selectedItem = itemsData.find(item => item.nama_item === itemName);

        if (!selectedItem) {
            alert('Item tidak ditemukan!');
            return;
        }

        const existingCartItem = cart.find(item => item.id_item === selectedItem.id_item);

        if (existingCartItem) {
            existingCartItem.quantity += qty;
        } else {
            cart.push({
                id_item: selectedItem.id_item,
                nama_item: selectedItem.nama_item,
                price: parseFloat(selectedItem.harga_jual),
                quantity: qty
            });
        }
        
        searchInput.value = '';
        qtyInput.value = 1;
        renderCart();
    });

    // Fungsi untuk merender ulang tabel keranjang dan total
    function renderCart() {
        cartBody.innerHTML = ''; // Kosongkan tabel
        let grandTotal = 0;

        cart.forEach((item, index) => {
            const subtotal = item.price * item.quantity;
            grandTotal += subtotal;

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.nama_item}</td>
                <td>Rp ${item.price.toLocaleString('id-ID')}</td>
                <td>
                    <input type="number" class="form-control form-control-sm cart-qty" value="${item.quantity}" min="1" data-index="${index}">
                </td>
                <td>Rp ${subtotal.toLocaleString('id-ID')}</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-item" data-index="${index}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            cartBody.appendChild(row);
        });

        grandTotalEl.textContent = `Rp ${grandTotal.toLocaleString('id-ID')}`;
    }

    // Fungsi event listener untuk tombol hapus dan ubah qty
    cartBody.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item') || e.target.closest('.remove-item')) {
            const button = e.target.classList.contains('remove-item') ? e.target : e.target.closest('.remove-item');
            const indexToRemove = parseInt(button.dataset.index);
            cart.splice(indexToRemove, 1);
            renderCart();
        }
    });

    cartBody.addEventListener('change', function(e) {
        if (e.target.classList.contains('cart-qty')) {
            const indexToUpdate = parseInt(e.target.dataset.index);
            const newQty = parseInt(e.target.value);
            if (newQty > 0) {
                cart[indexToUpdate].quantity = newQty;
                renderCart();
            }
        }
    });

    // Fungsi saat form disubmit
    salesForm.addEventListener('submit', function(e) {
        if (cart.length === 0) {
            e.preventDefault();
            alert('Keranjang belanja masih kosong!');
            return;
        }
        
        // Hapus input tersembunyi yang lama
        const oldInputs = salesForm.querySelectorAll('input[type="hidden"]');
        oldInputs.forEach(input => input.remove());

        // Buat input tersembunyi untuk setiap item di keranjang
        cart.forEach((item, index) => {
            salesForm.insertAdjacentHTML('beforeend', `<input type="hidden" name="items[${index}][id_item]" value="${item.id_item}">`);
            salesForm.insertAdjacentHTML('beforeend', `<input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">`);
            salesForm.insertAdjacentHTML('beforeend', `<input type="hidden" name="items[${index}][price]" value="${item.price}">`);
        });
    });
});
</script>