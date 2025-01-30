<?php
include 'connection.php';

$id = $_GET['id'];
$sql= "DELETE FROM barang WHERE id = $id";
$hapus = mysqli_query($conn, $sql);

if($hapus){
    echo "<script> 
            window.location.href='master-barang.php?success-delete';
        </script>";
}else{
    echo "<script> 
            alert('Hapus Data Gagal!');
            window.location.href='master-barang.php';
        </script>";
}
?>