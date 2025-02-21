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
                <i class="fas fa-dollar-sign"></i> Total Pendapatan
            </div>
            <div class="custom-card-body">
                <center>
                    <?php
                    $penjualan_query = "SELECT SUM(total) AS total_penjualan FROM penjualan";
                    $penjualan_result = mysqli_query($conn, $penjualan_query);
                    $penjualan_data = mysqli_fetch_assoc($penjualan_result);
                    $total_penjualan = $penjualan_data['total_penjualan'];

                    echo "<h3>Rp " . number_format($total_penjualan, 0, ',', '.') . "</h3>";
                    ?>
                </center>
            </div>
            <div class="custom-card-footer">
                <a href="laporan-transaksi.php">Lihat Laporan &raquo;</a>
            </div>
        </div>
    </div>
</div>

<div class="container" style="margin-top: -5px;">
    <div class="card" style="margin-top: -5px; background-color: #f8f9fa;">
        <div class="card-body">
            <h5 class="card-title">Grafik Penjualan Per Bulan</h5>
            <canvas id="salesChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    <?php

    $query = "SELECT MONTH(tanggal_input) AS bulan, SUM(total) AS total_penjualan 
              FROM penjualan 
              GROUP BY MONTH(tanggal_input)
              ORDER BY bulan";
    $result = mysqli_query($conn, $query);

    $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    $salesData = array_fill(0, 12, 0);

    while ($row = mysqli_fetch_assoc($result)) {
        $monthIndex = $row['bulan'] - 1; 
        $salesData[$monthIndex] = (int)$row['total_penjualan'];
    }
    ?>

    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($months); ?>, 
            datasets: [{
                label: 'Penjualan',
                data: <?php echo json_encode($salesData); ?>, 
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>


<?php include "footer.php" ?>