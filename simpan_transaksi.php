<?php
include 'connection.php';
session_start();

// Ambil id_member dari sesi login
if (isset($_SESSION['id_member'])) {
    $id_member = $_SESSION['id_member']; // Ambil id_member dari sesi
} else {
    echo json_encode(['status' => 'error', 'message' => 'Anda harus login untuk melakukan transaksi']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak valid']);
    exit;
}

$keranjang = $data['keranjang'];
$total = $data['total'];
$bayar = $data['bayar'];
$kembalian = $data['kembalian'];
$tanggal = $data['tanggal'];

// Menggunakan transaksi untuk memastikan semua data disimpan dengan konsisten
$conn->begin_transaction();

try {
    // Looping untuk menyimpan data ke tabel penjualan
    foreach ($keranjang as $barang) {
        $id_barang = $barang['id'];
        $jumlah = $barang['jumlah'];
        $total_harga = $barang['harga'] * $jumlah;

        // Simpan ke tabel penjualan
        $sql_penjualan = "INSERT INTO penjualan (id_barang, id_member, jumlah, total, tanggal_input)
                          VALUES ('$id_barang', '$id_member', '$jumlah', '$total_harga', '$tanggal')";
        $conn->query($sql_penjualan);

        // Simpan ke tabel nota
        $sql_nota = "INSERT INTO nota (id_barang, id_member, jumlah, total, tanggal_input)
                     VALUES ('$id_barang', '$id_member', '$jumlah', '$total_harga', '$tanggal')";
        $conn->query($sql_nota);
    }

    // Commit transaksi jika semua berhasil
    $conn->commit();

    echo json_encode(['status' => 'success', 'message' => 'Transaksi berhasil disimpan']);
} catch (Exception $e) {
    // Jika ada error, rollback transaksi
    $conn->rollback();
    echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat menyimpan transaksi: ' . $e->getMessage()]);
}
?>
