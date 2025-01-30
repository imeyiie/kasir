<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_kategori'];
    $nama = $_POST['nama_kategori'];
    $action = $_POST['action'];

    if ($action === 'insert') {
        $query = "INSERT INTO kategori (nama_kategori) VALUES ('$nama')";
        if (mysqli_query($conn, $query)) {
            header('Location: master-kategori.php?success-insert'); 
            exit;
        }
    } elseif ($action === 'update') {
        $query = "UPDATE kategori SET nama_kategori = '$nama' WHERE id_kategori = $id";
        if (mysqli_query($conn, $query)) {
            header('Location: master-kategori.php?success-edit');  
            exit;
        }
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = $_GET['id'];
    $query = "DELETE FROM kategori WHERE id_kategori = $id";
    
    if (mysqli_query($conn, $query)) {
        header('Location: master-kategori.php?success-delete');
        exit;
    }
}
?>
