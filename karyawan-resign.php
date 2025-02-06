<?php
    include 'connection.php'; 
    include 'sidebar.php';

    $sql_resign = "SELECT m.id_member, m.nm_member, m.alamat_member, m.telepon, m.email, m.tgl_keluar
        FROM login l 
        INNER JOIN member m ON l.id_member = m.id_member 
        INNER JOIN role r ON m.id_role = r.id_role
        WHERE m.id_role = 2 AND m.tgl_keluar IS NOT NULL AND m.tgl_keluar != '0000-00-00'
    ";


    $result_resign = $conn->query($sql_resign);
?>

<div class="container">
    <div class="card">
        <div class="card-body">
            <h2 class="mb-4">Data Karyawan Resign</h2>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Alamat</th>
                            <th>No Telepon</th>
                            <th>Email</th>
                            <th>Tanggal Keluar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result_resign->num_rows > 0) {
                            $no = 1;
                            while($row = $result_resign->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . $row['nm_member'] . "</td>";
                                echo "<td>" . $row['alamat_member'] . "</td>";
                                echo "<td>" . $row['telepon'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>" . $row['tgl_keluar'] . "</td>";
                                echo "<td>    
                                        <a href='detail-petugas.php?id=" . $row['id_member'] . "'>
                                            <button class='btn btn-info btn-sm'>
                                                <i class='fas fa-info-circle'></i> 
                                            </button>
                                        </a>    
                                        </td>";
                                echo "</tr>";   
                            }
                        } else {
                            echo "<tr><td colspan='6'>Tidak ada data karyawan yang resign</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
