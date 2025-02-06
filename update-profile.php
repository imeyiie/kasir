<?php
session_start();
include 'connection.php';

if (isset($_SESSION['id_member']) && $_SESSION['id_member'] > 0) {
    $id_member = $_SESSION['id_member'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $telepon = $_POST['telepon'];
        $nik = $_POST['nik'];
        $alamat = $_POST['alamat'];

        $query = "UPDATE member SET nm_member = '$nama', email = '$email', telepon = '$telepon', NIK = '$nik', alamat_member = '$alamat' WHERE id_member = '$id_member'";

        if (mysqli_query($conn, $query)) {
            header("Location: profile-petugas.php?success-edit=1");
        } else {
            echo "<script>alert('Terjadi kesalahan saat mengubah data profile.');</script>";
            echo "<script>window.location.href = 'profile-petugas.php';</script>";
        }
    }
} else {
    echo "<script>alert('Anda harus login terlebih dahulu!');</script>";
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}
?>
