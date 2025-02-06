<?php 
include 'connection.php'; 
include 'sidebar.php';

$bulan_tes = array(
    '01' => "Januari",
    '02' => "Februari",
    '03' => "Maret",
    '04' => "April",
    '05' => "Mei",
    '06' => "Juni",
    '07' => "Juli",
    '08' => "Agustus",
    '09' => "September",
    '10' => "Oktober",
    '11' => "November",
    '12' => "Desember"
);

$selectedMonth = isset($_POST['bln']) ? $_POST['bln'] : date('m');
$selectedYear = isset($_POST['thn']) ? $_POST['thn'] : date('Y');
?>

<div class="container custom-container">
    <h3>Data Laporan Penjualan</h3>

    <div class="card p-3 mb-4">
        <h5>Cari Laporan Perbulan</h5>
        <form method="post" action="laporan-penjualan.php?cari=ok">
            <div class="row">
                <div class="col-md-4">
                    <label>Pilih Bulan</label>
                    <select name="bln" class="form-select">
                        <option value="">Pilih Bulan</option>
                        <?php
                        $bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
                        $bln1 = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
                        foreach ($bulan as $key => $month) {
                            echo "<option value='$bln1[$key]' " . ($selectedMonth == $bln1[$key] ? 'selected' : '') . ">$month</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Pilih Tahun</label>
                    <select name="thn" class="form-select">
                        <option value="">Pilih Tahun</option>
                        <?php
                        $now = date('Y');
                        for ($a = 2017; $a <= $now; $a++) {
                            echo "<option value='$a' " . ($selectedYear == $a ? 'selected' : '') . ">$a</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2"><i class="fa fa-search"></i> Cari</button>
                    <a href="laporan-penjualan.php" class="btn btn-success me-2"><i class="fa fa-refresh"></i> Refresh</a>
                </div>
            </div>
        </form>
    </div>

    <div class="card p-3 mb-4">
        <h5>Pilih Hari</h5>
        <form method="post" action="laporan-penjualan.php?hari=cek">
            <div class="row">
                <div class="col-md-4">
                    <input type="date" class="form-control" name="hari" value="<?= date('Y-m-d'); ?>">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2"><i class="fa fa-search"></i> Cari</button>
                    <a href="laporan-penjualan.php" class="btn btn-success me-2"><i class="fa fa-refresh"></i> Refresh</a>
                </div>
            </div>
        </form>
    </div>

    <div class="card p-3 mb-4">
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr style="background:#DFF0D8;color:#333;">
                        <th>No</th>
                        <th>ID Barang</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Modal</th>
                        <th>Total</th>
                        <th>Kasir</th>
                        <th>Tanggal Input</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    if (!empty($_GET['cari'])) {
                        $periode = $selectedMonth . '-' . $selectedYear;
                        $query = "SELECT p.id_penjualan, p.id_barang, p.id_member, p.jumlah, p.total, p.tanggal_input,
                                  b.nama_barang, b.harga_beli, b.harga_jual, m.nm_member
                                  FROM penjualan p
                                  JOIN barang b ON p.id_barang = b.id_barang
                                  JOIN member m ON p.id_member = m.id_member
                                  WHERE MONTH(p.tanggal_input) = ? AND YEAR(p.tanggal_input) = ?
                                  ORDER BY p.tanggal_input DESC";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("ii", $selectedMonth, $selectedYear);
                        $stmt->execute();
                        $result = $stmt->get_result();
                    } elseif (!empty($_GET['hari'])) {
                        $hari = $_POST['hari'];
                        $query_hari = "SELECT p.id_penjualan, p.id_barang, p.id_member, p.jumlah, p.total, p.tanggal_input,
                                      b.nama_barang, b.harga_beli, b.harga_jual, m.nm_member
                                      FROM penjualan p
                                      JOIN barang b ON p.id_barang = b.id_barang
                                      JOIN member m ON p.id_member = m.id_member
                                      WHERE DATE(p.tanggal_input) = ?
                                      ORDER BY p.tanggal_input DESC";
                        $stmt = $conn->prepare($query_hari);
                        $stmt->bind_param("s", $hari);
                        $stmt->execute();
                        $result = $stmt->get_result();
                    } else {
                        $query_all = "SELECT p.id_penjualan, p.id_barang, p.id_member, p.jumlah, p.total, p.tanggal_input,
                                      b.nama_barang, b.harga_beli, b.harga_jual, m.nm_member
                                      FROM penjualan p
                                      JOIN barang b ON p.id_barang = b.id_barang
                                      JOIN member m ON p.id_member = m.id_member
                                      ORDER BY p.tanggal_input DESC";
                        $result = $conn->query($query_all);
                    }

                    $bayar = 0;
                    $jumlah = 0;
                    $modal = 0;
                    
                    while ($row = $result->fetch_assoc()) {
                        $bayar += $row['total'];
                        $modal += $row['harga_beli'] * $row['jumlah'];
                        $jumlah += $row['jumlah'];
                        ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $row['id_barang']; ?></td>
                            <td><?php echo $row['nama_barang']; ?></td>
                            <td><?php echo $row['jumlah']; ?></td>
                            <td>Rp.<?php echo number_format($row['harga_beli'] * $row['jumlah']); ?>,-</td>
                            <td>Rp.<?php echo number_format($row['total']); ?>,-</td>
                            <td><?php echo $row['nm_member']; ?></td>
                            <td><?php echo $row['tanggal_input']; ?></td>
                        </tr>
                        <?php $no++; } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Total Terjual</th>
                        <th><?php echo $jumlah; ?></th>
                        <th>Rp.<?php echo number_format($modal); ?>,-</th>
                        <th>Rp.<?php echo number_format($bayar); ?>,-</th>
                        <th style="background:#0bb365;color:#fff;">Keuntungan</th>
                        <th style="background:#0bb365;color:#fff;">Rp.<?php echo number_format($bayar - $modal); ?>,-</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
