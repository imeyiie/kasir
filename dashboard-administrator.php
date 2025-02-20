<?php include 'sidebar.php';
include 'connection.php'; ?>

<div class="container">
    <h2>Dashboard</h2>
    <div class="custom-dashboard-cards">
        <div class="custom-card">
            <div class="custom-card-header">
                <i class="fas fa-box"></i> Nama Barang
            </div>
            <div class="custom-card-body">
                <center>
                    <?php
                    $barang = "SELECT * FROM barang";
                    $barang_query = mysqli_query($conn, $barang);
                    $barang_total = mysqli_num_rows($barang_query);
                    echo "<h3>$barang_total</h3>";
                    ?>
                </center>
            </div>
            <div class="custom-card-footer">
                <a href="master-barang.php">Tabel Barang &raquo;</a>
            </div>
        </div>

        <div class="custom-card">
            <div class="custom-card-header">
                <i class="fas fa-chart-bar"></i> Stok Barang
            </div>
            <div class="custom-card-body">
                <center>
                    <?php
                    $stok = "SELECT SUM(stok) AS stok FROM barang";
                    $stok_query = mysqli_query($conn, $stok);
                    $stok_data = mysqli_fetch_assoc($stok_query);
                    echo "<h3>{$stok_data['stok']}</h3>";
                    ?>
                </center>
            </div>
            <div class="custom-card-footer">
                <a href="master-barang.php">Tabel Barang &raquo;</a>
            </div>
        </div>

        <div class="custom-card">
            <div class="custom-card-header">
                <i class="fas fa-shopping-cart"></i> Telah Terjual
            </div>
            <div class="custom-card-body">
                <center>
                    <?php
                    $penjualan = "SELECT SUM(jumlah) AS total_terjual FROM penjualan";
                    $penjualan_query = mysqli_query($conn, $penjualan);
                    $penjualan_data = mysqli_fetch_assoc($penjualan_query);
                    $total_terjual = $penjualan_data['total_terjual'] ? $penjualan_data['total_terjual'] : 0;
                    echo "<h3>$total_terjual</h3>";
                    ?>
                </center>
            </div>
            <div class="custom-card-footer">
                <a href="laporan-transaksi.php">Tabel Laporan &raquo;</a>
            </div>
        </div>

        <div class="custom-card">
            <div class="custom-card-header">
                <i class="fas fa-tags"></i> Kategori Barang
            </div>
            <div class="custom-card-body">
                <center>
                    <?php
                    $kategori = "SELECT COUNT(id_kategori) AS total_kategori FROM kategori";
                    $kategori_query = mysqli_query($conn, $kategori);
                    $kategori_data = mysqli_fetch_assoc($kategori_query);
                    echo "<h3>{$kategori_data['total_kategori']}</h3>";
                    ?>
                </center>
            </div>
            <div class="custom-card-footer">
                <a href="master-kategori.php">Tabel Kategori &raquo;</a>
            </div>
        </div>

    </div>
</div>++++++++
















































<?php include "footer.php" ?>