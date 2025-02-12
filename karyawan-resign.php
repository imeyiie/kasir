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

    if (isset($_POST['submit_restore'])) {
        $id_member = $_POST['id_member'];
        $sql_restore = "UPDATE member SET tgl_keluar = '0000-00-00 00:00:00', tgl_masuk = NOW() WHERE id_member = ?";
        $stmt = $conn->prepare($sql_restore);
        $stmt->bind_param("i", $id_member);
        
        if ($stmt->execute()) {
            echo "<script>window.location.href = 'master-petugas.php?success-restore';</script>";  
        } else {
            echo "<script>window.location.href = 'master-petugas.php?error=true';</script>";  
        }
    }
?>


<div class="container">
    <div class="card">
        <div class="card-body">
            <h2 class="mb-4">Data Karyawan Resign</h2>

            <?php
            if (isset($_GET['success-resign'])) {
                echo '<div class="alert alert-danger" role="alert" id="alert">Data petugas berhasil dipindahkan ke resign!</div>';
            }
            ?>

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
                                        <button type='button' class='btn btn-sm btn-warning' title='Restore' 
                                            data-bs-toggle='modal' data-bs-target='#resignModal' 
                                            onclick='setResignId(" . $row['id_member'] . ")'>
                                            <i class='fas fa-undo'></i>
                                        </button>
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

<form action="" method="POST">
    <div class="modal fade" id="resignModal" tabindex="-1" aria-labelledby="resignModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resignModalLabel">Konfirmasi Pemulihan Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin mengembalikan status karyawan ini ke status <strong>Aktif</strong>
    
                    <input type="hidden" name="id_member" id="id_member">
                    <input type="hidden" name="tgl_keluar" value="">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-warning" name="submit_restore"> Ya, Kembalikan </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function setResignId(id) {
        document.getElementById('id_member').value = id;
    }

    window.onload = function() {
        const alertElement = document.getElementById('alert');
            if (alertElement) {
                setTimeout(function() {
                    alertElement.style.display = 'none';
                }, 3000); 
            }
    };
</script>

<?php include 'footer.php'; ?>

<script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>