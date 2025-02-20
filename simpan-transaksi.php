<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['id_member'])) {
    echo json_encode(['status' => 'error', 'message' => 'Anda harus login untuk melakukan transaksi']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak valid']);
    exit;
}

$nama = $data['nama'];
$nomor_telepon = $data['nomor_telepon'];
$alamat = $data['alamat'];
$keranjang = $data['keranjang'];
$total = $data['total'];
$bayar = $data['bayar'];
$kembalian = $data['kembalian'];
$tanggal = date('Y-m-d H:i:s', strtotime($data['tanggal']));
$id_member = $_SESSION['id_member'];

$conn->begin_transaction();

try {
    $stmt_pelanggan = $conn->prepare("INSERT INTO pelanggan (nama_pelanggan, no_telepon, alamat_pelanggan) VALUES (?, ?, ?)");
    $stmt_pelanggan->bind_param('sss', $nama, $nomor_telepon, $alamat);
    $stmt_pelanggan->execute();
    $id_pelanggan = $stmt_pelanggan->insert_id;

    $stmt_check_stok = $conn->prepare("SELECT stok FROM barang WHERE id_barang = ?");
    $stmt_update_stok = $conn->prepare("UPDATE barang SET stok = ? WHERE id_barang = ?");
    $stmt_penjualan = $conn->prepare("INSERT INTO penjualan (id_pelanggan, id_barang, id_member, jumlah, total, tanggal_input) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt_nota = $conn->prepare("INSERT INTO nota (id_pelanggan, id_barang, id_member, jumlah, total, tanggal_input) VALUES (?, ?, ?, ?, ?, ?)");

    foreach ($keranjang as $barang) {
        $id_barang = $barang['id'];
        $jumlah = $barang['jumlah'];
        $total_harga = $barang['harga'] * $jumlah;

        $stmt_check_stok->bind_param('s', $id_barang);
        $stmt_check_stok->execute();
        $result = $stmt_check_stok->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stok_tersedia = $row['stok'];

            if ($stok_tersedia < $jumlah) {
                echo json_encode(['status' => 'error', 'message' => 'Stok barang tidak mencukupi']);
                exit;
            }

            $new_stok = $stok_tersedia - $jumlah;
            $stmt_update_stok->bind_param('is', $new_stok, $id_barang);
            $stmt_update_stok->execute();
        }

        $stmt_penjualan->bind_param('isiids', $id_pelanggan, $id_barang, $id_member, $jumlah, $total_harga, $tanggal);
        $stmt_penjualan->execute();

        $stmt_nota->bind_param('isiids', $id_pelanggan, $id_barang, $id_member, $jumlah, $total_harga, $tanggal);
        $stmt_nota->execute();
    }

    $conn->commit();
    echo json_encode(['status' => 'success', 'message' => 'Transaksi berhasil disimpan']);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat menyimpan transaksi: ' . $e->getMessage()]);
}
?>
