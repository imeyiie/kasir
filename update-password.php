<?php
session_start();
include 'connection.php';

if (isset($_SESSION['id_member']) && $_SESSION['id_member'] > 0) {
    $id_member = $_SESSION['id_member'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $new_password = $_POST['new_password'];
        $hashed_password = md5($new_password);

        $query = "UPDATE login SET pass = '$hashed_password' WHERE id_member = '$id_member'";

        if (mysqli_query($conn, $query)) {
            header("Location: profile-petugas.php?success-pass=1");
            exit;
        } else {    
            echo "<script>alert('Terjadi kesalahan saat mengganti password.');</script>";
            echo "<script>window.location.href = 'profile-petugas.php';</script>";
        }
    }
} else {
    echo "<script>alert('Anda harus login terlebih dahulu!');</script>";
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}
?>
