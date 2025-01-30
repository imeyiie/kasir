<?php
include 'koneksi.php';
session_start();

$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($action == 'add_to_cart') {
    $id_barang = $_POST['id_barang'];

    // Ambil data barang dari database
    $stmt = $conn->prepare("SELECT * FROM barang WHERE id_barang = ?");
    $stmt->bind_param("i", $id_barang);
    $stmt->execute();
    $result = $stmt->get_result();
    $barang = $result->fetch_assoc();

    if ($barang) {
        // Tambahkan barang ke sesi keranjang
        if (isset($_SESSION['keranjang'][$id_barang])) {
            $_SESSION['keranjang'][$id_barang]['jumlah']++;
            $_SESSION['keranjang'][$id_barang]['total'] = $_SESSION['keranjang'][$id_barang]['jumlah'] * $barang['harga_jual'];
        } else {
            $_SESSION['keranjang'][$id_barang] = [
                'id_barang' => $barang['id_barang'],
                'nama_barang' => $barang['nama_barang'],
                'harga_jual' => $barang['harga_jual'],
                'jumlah' => 1,
                'total' => $barang['harga_jual']
            ];
        }

        // Kirim ulang data keranjang dalam bentuk tabel
        $output = '';
        foreach ($_SESSION['keranjang'] as $key => $value) {
            $output .= "<tr>
                        <td>{$value['id_barang']}</td>
                        <td>{$value['nama_barang']}</td>
                        <td>{$value['jumlah']}</td>
                        <td>Rp. " . number_format($value['total']) . "</td>
                        <td><button class='btn btn-danger' onclick='hapusBarang({$key})'>Hapus</button></td>
                    </tr>";
        }
        echo $output;
    }
} elseif ($action == 'remove_from_cart') {
    $id_barang = $_POST['id_barang'];

    // Hapus barang dari keranjang
    unset($_SESSION['keranjang'][$id_barang]);

    // Kirim ulang data keranjang dalam bentuk tabel
    $output = '';
    foreach ($_SESSION['keranjang'] as $key => $value) {
        $output .= "<tr>
                    <td>{$value['id_barang']}</td>
                    <td>{$value['nama_barang']}</td>
                    <td>{$value['jumlah']}</td>
                    <td>Rp. " . number_format($value['total']) . "</td>
                    <td><button class='btn btn-danger' onclick='hapusBarang({$key})'>Hapus</button></td>
                </tr>";
    }
    echo $output;
}
?>
