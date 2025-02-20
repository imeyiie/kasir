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
$tanggal = date('Y-m-d H:i:s', strtotime($data['tanggal']));
$nama = $data['nama']; 
$nomor_telepon = $data['nomor_telepon'];
$alamat = $data['alamat'];  

$conn->begin_transaction();

try {
    $stmt_check_pelanggan = $conn->prepare("SELECT id_pelanggan FROM pelanggan WHERE no_telepon = ?");
    $stmt_check_pelanggan->bind_param('s', $nomor_telepon);
    $stmt_check_pelanggan->execute();
    $result = $stmt_check_pelanggan->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_pelanggan = $row['id_pelanggan'];
    } else {
        $stmt_insert_pelanggan = $conn->prepare("INSERT INTO pelanggan (nama_pelanggan, no_telepon, alamat_pelanggan) VALUES (?, ?, ?)");
        $stmt_insert_pelanggan->bind_param('sss', $nama, $nomor_telepon, $alamat);
        $stmt_insert_pelanggan->execute();
        $id_pelanggan = $conn->insert_id; 
    }

    $stmt_check_stok = $conn->prepare("SELECT stok FROM barang WHERE id_barang = ?");
    $stmt_update_stok = $conn->prepare("UPDATE barang SET stok = ? WHERE id_barang = ?");
    $stmt_penjualan = $conn->prepare("INSERT INTO penjualan (id_pelanggan, id_barang, id_member, jumlah, total, tanggal_input)
                                      VALUES (?, ?, ?, ?, ?, ?)");
    $stmt_nota = $conn->prepare("INSERT INTO nota (id_pelanggan, id_barang, id_member, jumlah, total, tanggal_input)
                                 VALUES (?, ?, ?, ?, ?, ?)");

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

        // Insert into penjualan and nota tables
        $stmt_penjualan->bind_param('iiidsd', $id_pelanggan, $id_barang, $id_member, $jumlah, $total_harga, $tanggal);
        $stmt_penjualan->execute();

        $stmt_nota->bind_param('iiidsd', $id_pelanggan, $id_barang, $id_member, $jumlah, $total_harga, $tanggal);
        $stmt_nota->execute();
    }

    $conn->commit();
    echo json_encode(['status' => 'success', 'message' => 'Transaksi berhasil disimpan']);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat menyimpan transaksi: ' . $e->getMessage()]);
}
?>
