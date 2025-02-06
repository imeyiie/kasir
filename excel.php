<?php
require_once 'PHPExcel.php'; // Pastikan file PHPExcel sudah terpasang

// Mengambil bulan dan tahun
if (isset($_GET['cari'])) {
    $bln = $_GET['bln'];
    $thn = $_GET['thn'];

    // Query untuk mengambil data berdasarkan bulan dan tahun yang dipilih
    $query = "SELECT p.id_penjualan, p.id_barang, p.id_member, p.jumlah, p.total, p.tanggal_input, 
                     b.nama_barang, b.harga_beli, b.harga_jual, m.nm_member
              FROM penjualan p
              JOIN barang b ON p.id_barang = b.id_barang
              JOIN member m ON p.id_member = m.id_member
              WHERE MONTH(p.tanggal_input) = '$bln' AND YEAR(p.tanggal_input) = '$thn'";

    // Eksekusi query (ganti dengan query database sesuai dengan konfigurasi)
    $result = mysqli_query($koneksi, $query);
} else {
    // Menampilkan semua data jika tidak ada filter
    $query = "SELECT p.id_penjualan, p.id_barang, p.id_member, p.jumlah, p.total, p.tanggal_input, 
                     b.nama_barang, b.harga_beli, b.harga_jual, m.nm_member
              FROM penjualan p
              JOIN barang b ON p.id_barang = b.id_barang
              JOIN member m ON p.id_member = m.id_member";
    $result = mysqli_query($koneksi, $query);
}

// Membuat objek PHPExcel
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$sheet = $objPHPExcel->getActiveSheet();
$sheet->setCellValue('A1', 'No.')
      ->setCellValue('B1', 'ID Barang')
      ->setCellValue('C1', 'Nama Barang')
      ->setCellValue('D1', 'Jumlah')
      ->setCellValue('E1', 'Modal')
      ->setCellValue('F1', 'Total')
      ->setCellValue('G1', 'Kasir')
      ->setCellValue('H1', 'Tanggal Input');

// Menambahkan data ke file Excel
$row = 2;
$no = 1;
while ($data = mysqli_fetch_array($result)) {
    $sheet->setCellValue('A' . $row, $no)
          ->setCellValue('B' . $row, $data['id_barang'])
          ->setCellValue('C' . $row, $data['nama_barang'])
          ->setCellValue('D' . $row, $data['jumlah'])
          ->setCellValue('E' . $row, 'Rp.' . number_format($data['harga_beli'] * $data['jumlah']))
          ->setCellValue('F' . $row, 'Rp.' . number_format($data['total']))
          ->setCellValue('G' . $row, $data['nm_member'])
          ->setCellValue('H' . $row, $data['tanggal_input']);
    $no++;
    $row++;
}

// Menyimpan file Excel
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Laporan_Penjualan_' . $bln . '-' . $thn . '.xls"');
header('Cache-Control: max-age=0');

// Menulis ke file Excel
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>
