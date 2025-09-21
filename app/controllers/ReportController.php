<?php
// Memuat semua library dari Composer (Dompdf, PhpSpreadsheet)
require_once __DIR__ . '/../../vendor/autoload.php';

// Menggunakan namespace untuk library eksternal
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Memanggil semua model yang dibutuhkan
require_once __DIR__ . '../../models/SalesModel.php';
require_once __DIR__ . '../../models/CustomerModel.php';
require_once __DIR__ . '../../models/Item.php';

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
     */
    public function printPdf() {
        $startDate = $_GET['start_date'] ?? die("Silakan tentukan rentang tanggal.");
        $endDate = $_GET['end_date'] ?? die("Silakan tentukan rentang tanggal.");
        $sales = SalesModel::findByDateRange($startDate, $endDate);

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
        $sheet->setCellValue('A4', 'No')->getStyle('A4')->getFont()->setBold(true);
        $sheet->setCellValue('B4', 'ID Penjualan')->getStyle('B4')->getFont()->setBold(true);
        $sheet->setCellValue('C4', 'Tanggal')->getStyle('C4')->getFont()->setBold(true);
        $sheet->setCellValue('D4', 'Pelanggan')->getStyle('D4')->getFont()->setBold(true);
        $sheet->setCellValue('E4', 'Kasir')->getStyle('E4')->getFont()->setBold(true);
        $sheet->setCellValue('F4', 'Total Penjualan')->getStyle('F4')->getFont()->setBold(true);

        // Mengisi Data
        $row = 5;
        $no = 1;
        $grandTotal = 0;
        foreach ($sales as $sale) {
            $sheet->setCellValue('A' . $row, $no++);
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

        // Output ke Browser
        $fileName = "laporan-penjualan-{$startDate}-sd-{$endDate}.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
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
        $sheet->setCellValue('A3', 'No')->getStyle('A3')->getFont()->setBold(true);
        $sheet->setCellValue('B3', 'Nama Pelanggan')->getStyle('B3')->getFont()->setBold(true);
        $sheet->setCellValue('C3', 'Alamat')->getStyle('C3')->getFont()->setBold(true);
        $sheet->setCellValue('D3', 'Telepon')->getStyle('D3')->getFont()->setBold(true);
        $sheet->setCellValue('E3', 'Jumlah Transaksi')->getStyle('E3')->getFont()->setBold(true);
        $sheet->setCellValue('F3', 'Total Belanja')->getStyle('F3')->getFont()->setBold(true);

        // Mengisi Data
        $row = 4;
        $no = 1;
        foreach ($customers as $customer) {
            $sheet->setCellValue('A' . $row, $no++);
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

        // Output ke Browser
        $fileName = "laporan-pelanggan.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
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
        $sheet->setCellValue('A3', 'No')->getStyle('A3')->getFont()->setBold(true);
        $sheet->setCellValue('B3', 'Nama Item')->getStyle('B3')->getFont()->setBold(true);
        $sheet->setCellValue('C3', 'Satuan')->getStyle('C3')->getFont()->setBold(true);
        $sheet->setCellValue('D3', 'Stok Saat Ini')->getStyle('D3')->getFont()->setBold(true);
        $sheet->setCellValue('E3', 'Harga Jual')->getStyle('E3')->getFont()->setBold(true);
        $sheet->setCellValue('F3', 'Total Terjual')->getStyle('F3')->getFont()->setBold(true);
        $sheet->setCellValue('G3', 'Total Pendapatan')->getStyle('G3')->getFont()->setBold(true);

        // Mengisi Data
        $row = 4;
        $no = 1;
        foreach ($items as $item) {
            $sheet->setCellValue('A' . $row, $no++);
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

        // Output ke Browser
        $fileName = "laporan-stok-item.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}