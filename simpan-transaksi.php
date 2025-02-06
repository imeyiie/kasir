<?php
include 'connection.php';
session_start();

if (isset($_SESSION['id_member'])) {
    $id_member = $_SESSION['id_member'];
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

$conn->begin_transaction();

try {
    foreach ($keranjang as $barang) {
        $id_barang = $barang['id'];
        $jumlah = $barang['jumlah'];
        $total_harga = $barang['harga'] * $jumlah;

        $sql_check_stok = "SELECT stok FROM barang WHERE id_barang = '$id_barang'";
        $result = $conn->query($sql_check_stok);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stok_tersedia = $row['stok'];

            if ($stok_tersedia < $jumlah) {
                echo json_encode(['status' => 'error', 'message' => 'Stok barang tidak mencukupi']);
                exit;
            }

            $new_stok = $stok_tersedia - $jumlah;
            $sql_update_stok = "UPDATE barang SET stok = '$new_stok' WHERE id_barang = '$id_barang'";
            $conn->query($sql_update_stok);
        }

        $sql_penjualan = "INSERT INTO penjualan (id_barang, id_member, jumlah, total, tanggal_input)
                          VALUES ('$id_barang', '$id_member', '$jumlah', '$total_harga', '$tanggal')";
        $conn->query($sql_penjualan);

        $sql_nota = "INSERT INTO nota (id_barang, id_member, jumlah, total, tanggal_input)
                     VALUES ('$id_barang', '$id_member', '$jumlah', '$total_harga', '$tanggal')";
        $conn->query($sql_nota);
    }

    $conn->commit();
    echo json_encode(['status' => 'success', 'message' => 'Transaksi berhasil disimpan']);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat menyimpan transaksi: ' . $e->getMessage()]);
}
?>
