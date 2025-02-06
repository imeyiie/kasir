<?php
include 'connection.php';

if (isset($_GET['id_barang'])) {
    $id_barang = $_GET['id_barang'];

    $sql = "SELECT stok FROM barang WHERE id_barang = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $id_barang);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['status' => 'success', 'stok' => $row['stok']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Barang tidak ditemukan']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID barang tidak diberikan']);
}
?>
