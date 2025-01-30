<?php
    include 'connection.php'; include 'sidebar.php';

    $sql = "SELECT b.id_barang, b.nama_barang, b.merk, b.harga_beli, b.harga_jual, b.stok, b.satuan_barang, k.nama_kategori
            FROM barang b
            JOIN kategori k ON b.id_kategori = k.id_kategori";
    
    $result = $conn->query($sql);
    ?>

