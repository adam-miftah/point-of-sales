<?php
// Panggil autoloader dari Composer
require_once __DIR__ . '/../../vendor/autoload.php';

// Gunakan namespace Dompdf
use Dompdf\Dompdf;

// Memanggil semua model yang datanya akan kita laporkan
require_once __DIR__ . '../../models/SalesModel.php';
require_once __DIR__ . '../../models/CustomerModel.php';
require_once __DIR__ . '../../models/Item.php';

class ReportController {

    /**
     * Menampilkan halaman laporan penjualan.
     * View: report/sales.php
     */
    public function sales() {
        $startDate = $_GET['start_date'] ?? '';
        $endDate = $_GET['end_date'] ?? '';
        
        $sales = [];
        if (!empty($startDate) && !empty($endDate)) {
            $sales = SalesModel::findByDateRange($startDate, $endDate);
        }
        
        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/layout/sidebar.php';
        require __DIR__ . '/../views/report/sales.php';
        require __DIR__ . '/../views/layout/footer.php';
    }

    /**
     * Menampilkan halaman laporan pelanggan.
     * View: report/customers.php
     */
    public function customers() {
        $customers = CustomerModel::allWithTransactionSummary();
        
        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/layout/sidebar.php';
        // PERBAIKAN: Memanggil view yang benar untuk laporan pelanggan
        require __DIR__ . '/../views/report/customers.php';
        require __DIR__ . '/../views/layout/footer.php';
    }

    /**
     * Menampilkan halaman laporan stok item.
     * View: report/items.php
     */
    public function items() {
        $items = Item::allWithStockSummary();

        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/layout/sidebar.php';
        // PERBAIKAN: Memanggil view yang benar untuk laporan item
        require __DIR__ . '/../views/report/items.php';
        require __DIR__ . '/../views/layout/footer.php';
    }

    /**
     * Membuat dan menampilkan laporan penjualan dalam format PDF.
     */
    public function printPdf() {
        $startDate = $_GET['start_date'] ?? '';
        $endDate = $_GET['end_date'] ?? '';
        
        $sales = [];
        if (!empty($startDate) && !empty($endDate)) {
            $sales = SalesModel::findByDateRange($startDate, $endDate);
        } else {
            die("Silakan tentukan rentang tanggal terlebih dahulu.");
        }

        ob_start();
        require __DIR__ . '/../views/report/sales_pdf.php';
        $html = ob_get_clean();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("laporan-penjualan-{$startDate}-sd-{$endDate}.pdf", ["Attachment" => false]);
        exit;
    }
}