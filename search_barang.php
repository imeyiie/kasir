<?php
include 'connection.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

    // Validasi input agar tidak kosong
    if (empty($keyword)) {
        echo json_encode(['status' => 'error', 'message' => 'Keyword tidak boleh kosong']);
        exit;
    }

    // Query untuk mencari barang berdasarkan id_barang atau nama_barang
    $stmt = $conn->prepare("SELECT id_barang, nama_barang, merk, harga_jual FROM barang WHERE id_barang = ? OR nama_barang LIKE ?");
    $likeKeyword = "%" . $keyword . "%";
    $stmt->bind_param("ss", $keyword, $likeKeyword);
    $stmt->execute();
    $result = $stmt->get_result();

    $barang = [];
    while ($row = $result->fetch_assoc()) {
        $barang[] = $row;
    }

    if (count($barang) > 0) {
        echo json_encode(['status' => 'success', 'data' => $barang]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Barang tidak ditemukan']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode request tidak valid']);
}
