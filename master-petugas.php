    <?php
    include 'connection.php'; 
    include 'sidebar.php';

    $sql_user = "SELECT l.user, l.pass, m.id_member, m.nm_member, m.alamat_member, m.telepon, m.email, m.gambar, m.NIK, r.nama_role
    FROM login l INNER JOIN member m ON l.id_member = m.id_member 
    INNER JOIN role r ON m.id_role = r.id_role
    WHERE m.id_role = 2 AND m.tgl_keluar IS NULL";


    $result = $conn->query($sql_user);
    ?>

    <div class="container">
        <div class="card">
            <div class="card-body">
                <h2 class="mb-4">Data Petugas</h2>

                <?php
                if (isset($_GET['success-resign'])) {
                    echo '<div class="alert alert-danger" role="alert" id="alert">Data User berhasil dipindahkan ke resign!</div>';
                } elseif (isset($_GET['success-insert'])) {
                    echo '<div class="alert alert-primary" role="alert" id="alert">Data User berhasil ditambahkan!</div>';
                }
                ?>

                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahData">Tambah</a>
                        <a href="#" class="btn btn-success" id="refreshPage">Refresh</a>
                    </div>

                    <input type="text" id="searchInput" class="form-control w-25" placeholder="Cari User...">
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="userTable">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Alamat</th>
                                <th>No Telepon</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                $no = 1;
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $no++ . "</td>";
                                    echo "<td>" . $row['nm_member'] . "</td>";
                                    echo "<td>" . $row['alamat_member'] . "</td>";
                                    echo "<td>" . $row['telepon'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td>    
                                            <a href='detail-petugas.php?id=" . $row['id_member'] . "'>
                                                <button class='btn btn-info btn-sm'>
                                                    <i class='fas fa-info-circle'></i> 
                                                </button>
                                            </a>    
                                            <button type='button' class='btn btn-sm btn-danger' title='Resign' 
                                                data-bs-toggle='modal' data-bs-target='#resignModal' 
                                                onclick='setResignId(" . $row['id_member'] . ")'>
                                                <i class='fas fa-user-slash'></i>
                                            </button>
                                        </td>";
                                    echo "</tr>";   
                                }
                            } else {
                                echo "<tr><td colspan='9'>Tidak ada data user</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="tambahData" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 0px;">
                <div class="modal-header" style="background: #c09dd1; color: #fff;">
                    <h5 class="modal-title"><i class="fa fa-plus"></i> Tambah Data Petugas</h5>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <td>Nama Lengkap</td>
                                <td><input type="text" class="form-control" name="nm_member" required></td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td>
                                    <select class="form-control" name="jenis_kelamin" required>
                                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td><input type="text" class="form-control" name="alamat_member" required></td>
                            </tr>
                            <tr>
                                <td>No Telepon</td>
                                <td><input type="text" class="form-control" name="telepon" required></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td><input type="email" class="form-control" name="email" required></td>
                            </tr>
                            <tr>
                                <td>NIK</td>
                                <td><input type="text" class="form-control" name="NIK" required></td>
                            </tr>
                            <tr>
                                <td>Username</td>
                                <td><input type="text" class="form-control" name="user" required></td>
                            </tr>
                            <tr>
                                <td>Password</td>
                                <td>
                                    <input type="password" class="form-control" name="pass" id="password" required>
                                    <input type="checkbox" id="showPassword"> Tampilkan Password
                                </td>
                            </tr>
                            <tr>
                                <td>Foto</td>
                                <td><input type="file" class="form-control" name="gambar" accept="image/*"></td>
                            </tr>
                            <input type="hidden" name="tgl_masuk" value="<?php echo date('Y-m-d H:i:s'); ?>">
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="submit"><i class="fa fa-plus"></i> Insert Data</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST['submit'])) {
        $nm_member = $_POST['nm_member'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $alamat_member = $_POST['alamat_member'];
        $telepon = $_POST['telepon'];
        $email = $_POST['email'];
        $NIK = $_POST['NIK'];
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $tgl_masuk = $_POST['tgl_masuk']; 

        $hashed_pass = md5($pass);

        $gambar_name = '';
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
            $gambar_tmp_name = $_FILES['gambar']['tmp_name'];
            $gambar_name = time() . "_" . $_FILES['gambar']['name'];
            $upload_dir = 'img/';
            if (!move_uploaded_file($gambar_tmp_name, $upload_dir . $gambar_name)) {
                echo "<script>alert('Gagal mengupload gambar.');</script>";
                exit;
            }
        }

        $id_role = 2;
        $sql_member = "INSERT INTO member (nm_member, jenis_kelamin, alamat_member, telepon, email, NIK, tgl_masuk, gambar, id_role) 
                    VALUES ('$nm_member', '$jenis_kelamin', '$alamat_member', '$telepon', '$email', '$NIK', '$tgl_masuk', '$gambar_name', '$id_role')";

        if (mysqli_query($conn, $sql_member)) {
            $id_member = mysqli_insert_id($conn); 
            $sql_login = "INSERT INTO login (user, pass, id_member) 
                        VALUES ('$user', '$hashed_pass', '$id_member')";
            if (mysqli_query($conn, $sql_login)) {
                echo "<script>window.location.href='master-petugas.php?success-insert';</script>";
            }
        } else {
            echo "<script>alert('Gagal menambahkan data.');</script>";
        }
    }
    ?> 

    <form action="" method="POST">
        <div class="modal fade" id="resignModal" tabindex="-1" aria-labelledby="resignModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="resignModalLabel">Konfirmasi Resign</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin mengubah status karyawan ini menjadi <strong>Resign</strong>? Data karyawan tetap akan ada di sistem, namun statusnya akan berubah.</p>
                        <p><strong>Perhatian: Anda dapat mengubah status ini kembali jika diperlukan.</strong></p>
                        
                        <input type="hidden" name="id_member" id="id_member">
                        <input type="hidden" name="tgl_keluar" value="<?php echo date('Y-m-d H:i:s'); ?>">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger" name="submit_resign">Ya, Resign</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php
    if(isset($_POST['submit_resign'])){
    
        $id_member = $_POST['id_member'];
        $tgl_keluar = date('Y-m-d H:i:s');
    
        $ubah = mysqli_query($conn, "UPDATE `member` SET `tgl_keluar`='$tgl_keluar' WHERE `id_member` = '$id_member'");
    
        if($ubah){
            echo "<script> 
                    window.location.href='master-petugas.php?success-resign';
                </script>";
        }else{
            echo "<script> 
                    alert('Gagal mengupdate data: " . mysqli_error($conn) . "');
                    window.location.href='master-petugas.php';
                </script>";
        }
    }
    
    ?>

    <script>
    function setResignId(id) {
        document.getElementById("id_member").value = id;
    }

    window.onload = function() {
        const alertElement = document.getElementById('alert');
            if (alertElement) {
                setTimeout(function() {
                    alertElement.style.display = 'none';
                }, 1500); 
            }
    };

    document.getElementById('refreshPage').addEventListener('click', function() {
        location.reload();
    });

    document.getElementById('showPassword').addEventListener('change', function() {
            var passwordField = document.getElementById('password');
        
            if (this.checked) {
                passwordField.type = 'text';
            } else {
        
                passwordField.type = 'password';
            }
        });
    </script>
    

    <?php include 'footer.php'; ?>