<?php
session_start();
include 'connection.php';

if (isset($_SESSION['id_member']) && $_SESSION['id_member'] > 0) {
    $id_member = $_SESSION['id_member'];

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $gambar = $_FILES['gambar'];
        $nama_file = $gambar['name'];
        $tmp_file = $gambar['tmp_name'];
        $ukuran_file = $gambar['size'];
        $ext = pathinfo($nama_file, PATHINFO_EXTENSION);

        $folder = "img/";

        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array(strtolower($ext), $allowed_extensions)) {
            echo "<script>alert('Format file tidak diperbolehkan!');</script>";
            echo "<script>window.location.href = 'profile-petugas.php';</script>";
            exit;
        }

        if ($ukuran_file > 2 * 1024 * 1024) {
            echo "<script>alert('Ukuran file terlalu besar! Maksimal 2MB.');</script>";
            echo "<script>window.location.href = 'profile-petugas.php';</script>";
            exit;
        }

        $new_file_name = time() . '.' . $ext;
        $path = $folder . $new_file_name;

        if (move_uploaded_file($tmp_file, $path)) {
            $query = "UPDATE member SET gambar = '$new_file_name' WHERE id_member = '$id_member'";
            if (mysqli_query($conn, $query)) {
                header("Location: profile-petugas.php?success-photo=1");
                exit;
            } else {
                echo "<script>alert('Terjadi kesalahan saat menyimpan data ke database.');</script>";
                echo "<script>window.location.href = 'profile-petugas.php';</script>";
                exit;
            }
        } else {
            echo "<script>alert('Terjadi kesalahan saat mengunggah gambar.');</script>";
            echo "<script>window.location.href = 'profile-petugas.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Tidak ada file yang diunggah.');</script>";
        echo "<script>window.location.href = 'profile-petugas.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Anda harus login terlebih dahulu!');</script>";
    echo "<script>window.location.href = 'profile-petugas.php';</script>";
    exit;
}
?>
