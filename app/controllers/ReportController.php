<?php

// Catatan: Baris error_reporting dan ini_set sebaiknya diletakkan di file index.php utama
// hanya selama masa pengembangan (development) untuk menampilkan semua error.
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Memuat semua library dari Composer (Dompdf, PhpSpreadsheet)
require_once __DIR__ . '/../../vendor/autoload.php';

// Menggunakan namespace untuk library eksternal
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Memanggil semua model yang dibutuhkan dengan path yang sudah benar
require_once __DIR__ . '/../models/SalesModel.php';
require_once __DIR__ . '/../models/CustomerModel.php';
require_once __DIR__ . '/../models/Item.php';

class ReportController {

    /**
     * Menampilkan halaman laporan penjualan dengan filter tanggal.
     */
    public function sales() {
        $startDate = $_GET['start_date'] ?? date('Y-m-01');
        $endDate = $_GET['end_date'] ?? date('Y-m-d');
        $sales = SalesModel::findByDateRange($startDate, $endDate);
        
        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/layout/sidebar.php';
        require __DIR__ . '/../views/report/sales.php';
        require __DIR__ . '/../views/layout/footer.php';
    }

    /**
     * Menampilkan halaman laporan pelanggan dengan filter pencarian.
     */
    public function customers() {
        $keyword = $_GET['search'] ?? '';
        $customers = CustomerModel::searchWithSummary($keyword);
        
        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/layout/sidebar.php';
        require __DIR__ . '/../views/report/customers.php';
        require __DIR__ . '/../views/layout/footer.php';
    }

    /**
     * Menampilkan halaman laporan stok item dengan filter pencarian.
     */
    public function items() {
        $keyword = $_GET['search'] ?? '';
        $items = Item::searchWithSummaryAndStock($keyword);

        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/layout/sidebar.php';
        require __DIR__ . '/../views/report/items.php';
        require __DIR__ . '/../views/layout/footer.php';
    }

    /**
     * Membuat dan menampilkan laporan penjualan dalam format PDF.
     * Arsitektur sudah benar: Controller mengambil data dan membuat PDF,
     * sementara View (sales_pdf.php) hanya berisi template HTML.
     */
    public function printPdf() {
        $startDate = $_GET['start_date'] ?? die("Silakan tentukan rentang tanggal.");
        $endDate = $_GET['end_date'] ?? die("Silakan tentukan rentang tanggal.");
        
        // Controller mengambil data dari Model
        $sales = SalesModel::findByDateRange($startDate, $endDate);

        // Menangkap output HTML dari file View ke dalam variabel
        ob_start();
        require __DIR__ . '/../views/report/sales_pdf.php';
        $html = ob_get_clean();

        // Controller memproses HTML menjadi PDF
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("laporan-penjualan-{$startDate}-sd-{$endDate}.pdf", ["Attachment" => false]);
        exit;
    }

    /**
     * Membuat dan mengunduh laporan penjualan dalam format Excel (.xlsx).
     */
    public function exportExcel() {
        $startDate = $_GET['start_date'] ?? die("Silakan tentukan rentang tanggal.");
        $endDate = $_GET['end_date'] ?? die("Silakan tentukan rentang tanggal.");
        $sales = SalesModel::findByDateRange($startDate, $endDate);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Membuat Header
        $sheet->setCellValue('A1', 'LAPORAN PENJUALAN');
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        $sheet->setCellValue('A2', "Periode: " . date("d/m/Y", strtotime($startDate)) . " s/d " . date("d/m/Y", strtotime($endDate)));
        $sheet->mergeCells('A2:F2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');

        // Header Tabel
        $sheet->fromArray(['No', 'ID Penjualan', 'Tanggal', 'Pelanggan', 'Kasir', 'Total Penjualan'], NULL, 'A4');
        $sheet->getStyle('A4:F4')->getFont()->setBold(true);

        // Mengisi Data
        $row = 5;
        $grandTotal = 0;
        foreach ($sales as $key => $sale) {
            $sheet->setCellValue('A' . $row, $key + 1);
            $sheet->setCellValue('B' . $row, 'INV-' . $sale['id_sales']);
            $sheet->setCellValue('C' . $row, date("d/m/Y H:i", strtotime($sale['tgl_sales'])));
            $sheet->setCellValue('D' . $row, $sale['nama_customer']);
            $sheet->setCellValue('E' . $row, $sale['nama_user']);
            $sheet->setCellValue('F' . $row, $sale['total_penjualan']);
            $grandTotal += $sale['total_penjualan'];
            $row++;
        }
        
        // Grand Total
        $sheet->setCellValue('E' . $row, 'Grand Total')->getStyle('E' . $row)->getFont()->setBold(true);
        $sheet->setCellValue('F' . $row, $grandTotal)->getStyle('F' . $row)->getFont()->setBold(true);

        // Formatting
        $sheet->getStyle('F5:F' . $row)->getNumberFormat()->setFormatCode('_("Rp"* #,##0_);_("Rp"* (#,##0);_("Rp"* "-"??_);_(@_)');
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Output ke Browser menggunakan helper method
        $fileName = "laporan-penjualan-{$startDate}-sd-{$endDate}.xlsx";
        $this->_outputExcel($spreadsheet, $fileName);
    }

    /**
     * Membuat dan mengunduh laporan pelanggan dalam format Excel (.xlsx).
     */
    public function exportCustomers() {
        $keyword = $_GET['search'] ?? '';
        $customers = CustomerModel::searchWithSummary($keyword);
 
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
 
        // Header
        $sheet->setCellValue('A1', 'LAPORAN PELANGGAN');
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        
        // Header Tabel
        $sheet->fromArray(['No', 'Nama Pelanggan', 'Alamat', 'Telepon', 'Jumlah Transaksi', 'Total Belanja'], NULL, 'A3');
        $sheet->getStyle('A3:F3')->getFont()->setBold(true);
 
        // Mengisi Data
        $row = 4;
        foreach ($customers as $key => $customer) {
            $sheet->setCellValue('A' . $row, $key + 1);
            $sheet->setCellValue('B' . $row, $customer['nama_customer']);
            $sheet->setCellValue('C' . $row, $customer['alamat']);
            $sheet->setCellValue('D' . $row, $customer['telp']);
            $sheet->setCellValue('E' . $row, $customer['jumlah_transaksi']);
            $sheet->setCellValue('F' . $row, $customer['total_belanja']);
            $row++;
        }
 
        // Formatting
        $sheet->getStyle('F4:F' . ($row - 1))->getNumberFormat()->setFormatCode('_("Rp"* #,##0_);_("Rp"* (#,##0);_("Rp"* "-"??_);_(@_)');
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
 
        // Output ke Browser menggunakan helper method
        $fileName = "laporan-pelanggan.xlsx";
        $this->_outputExcel($spreadsheet, $fileName);
    }
    public function printCustomersPdf() {
        // 1. Ambil keyword pencarian dari URL
        $keyword = $_GET['search'] ?? '';
        
        // 2. Controller mengambil data dari Model berdasarkan keyword
        $customers = CustomerModel::searchWithSummary($keyword);

        // 3. Tangkap output dari file View PDF ke dalam sebuah variabel
        ob_start();
        require __DIR__ . '/../views/report/customers_pdf.php';
        $html = ob_get_clean();

        // 4. Controller membuat file PDF dari HTML yang didapat
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("laporan-pelanggan.pdf", ["Attachment" => false]);
        exit;
    }
 
    /**
     * Membuat dan mengunduh laporan stok item dalam format Excel (.xlsx).
     */
    public function exportItems() {
        $keyword = $_GET['search'] ?? '';
        $items = Item::searchWithSummaryAndStock($keyword);
 
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
 
        // Header
        $sheet->setCellValue('A1', 'LAPORAN STOK DAN PENJUALAN ITEM');
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        
        // Header Tabel
        $sheet->fromArray(['No', 'Nama Item', 'Satuan', 'Stok Saat Ini', 'Harga Jual', 'Total Terjual', 'Total Pendapatan'], NULL, 'A3');
        $sheet->getStyle('A3:G3')->getFont()->setBold(true);
 
        // Mengisi Data
        $row = 4;
        foreach ($items as $key => $item) {
            $sheet->setCellValue('A' . $row, $key + 1);
            $sheet->setCellValue('B' . $row, $item['nama_item']);
            $sheet->setCellValue('C' . $row, $item['uom']);
            $sheet->setCellValue('D' . $row, $item['stok']);
            $sheet->setCellValue('E' . $row, $item['harga_jual']);
            $sheet->setCellValue('F' . $row, $item['total_terjual']);
            $sheet->setCellValue('G' . $row, $item['total_pendapatan']);
            $row++;
        }
 
        // Formatting
        $sheet->getStyle('E4:E' . ($row - 1))->getNumberFormat()->setFormatCode('_("Rp"* #,##0_);_("Rp"* (#,##0);_("Rp"* "-"??_);_(@_)');
        $sheet->getStyle('G4:G' . ($row - 1))->getNumberFormat()->setFormatCode('_("Rp"* #,##0_);_("Rp"* (#,##0);_("Rp"* "-"??_);_(@_)');
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
 
        // Output ke Browser menggunakan helper method
        $fileName = "laporan-stok-item.xlsx";
        $this->_outputExcel($spreadsheet, $fileName);
    }

    /**
     * Helper method privat untuk mengirim output Excel ke browser.
     * Mencegah duplikasi kode.
     * @param Spreadsheet $spreadsheet Objek spreadsheet yang sudah jadi.
     * @param string $fileName Nama file untuk diunduh.
     */
    private function _outputExcel(Spreadsheet $spreadsheet, string $fileName) {
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
 
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
    public function printItemsPdf() { 
        // 1. Ambil keyword pencarian dari URL 
        $keyword = $_GET['search'] ?? ''; 

        // 2. Controller mengambil data dari Model berdasarkan keyword 
        $items = Item::searchWithSummaryAndStock($keyword); 

        // 3. Tangkap output dari file View PDF ke dalam sebuah variabel 
        ob_start(); 
        require __DIR__ . '/../views/report/items_pdf.php'; 
        $html = ob_get_clean(); 

        // 4. Controller membuat file PDF dari HTML yang didapat 
        $dompdf = new Dompdf(); 
        $dompdf->loadHtml($html); 
        $dompdf->setPaper('A4', 'portrait'); 
        $dompdf->render(); 
        $dompdf->stream("laporan-stok-item.pdf", ["Attachment" => false]); 
        exit; 
    }
}