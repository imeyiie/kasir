<?php
include 'connection.php'; include 'sidebar.php';

$sql_user = "SELECT l.user, m.nm_member, m.alamat_member, m.telepon, m.email, m.NIK, r.nama_role
            FROM login l
            JOIN member m ON l.id_member = m.id_member
            JOIN role r ON m.id_role = r.id_role";

$result = $conn->query($sql_user);
?>

<div class="container">
    <div class="card">
        <div class="card-body">
            <h2 class="mb-4">Data Petugas</h2>

            <?php
            if (isset($_GET['success-edit'])) {
                echo '<div class="alert alert-primary" role="alert" id="alert">Data User berhasil diubah!</div>';
            } elseif (isset($_GET['success-insert'])) {
                echo '<div class="alert alert-success" role="alert" id="alert">Data User berhasil ditambahkan!</div>';
            } elseif (isset($_GET['success-delete'])) {
                echo '<div class="alert alert-danger" role="alert" id="alert">Data User berhasil dihapus!</div>';
            }
            ?>

            <div class="d-flex justify-content-between mb-3">
                <div>
                    <a href="#" class="btn" style="background-color: #b399d4; color: white;" data-bs-toggle="modal" data-bs-target="#tambahData">Tambah</a>
                    <a href="#" class="btn btn-warning" id="sortirBarang">Sortir Barang Kurang</a>
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
                            <th>NIK</th>
                            <th>Username</th>
                            <th>Role</th>
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
                                echo "<td>" . $row['NIK'] . "</td>";
                                echo "<td>" . $row['user'] . "</td>";
                                echo "<td>" . $row['nama_role'] . "</td>";
                                echo "<td>    
                                        <a href='edit-user.php?id=" . $row['user'] . "'>
                                            <button class='btn btn-warning btn-sm'>
                                                <i class='fas fa-pencil-alt'></i> 
                                            </button>
                                        </a>
                                        <a href='hapus-user.php?id=" . $row['user'] . "'>
                                            <button class='btn btn-danger btn-sm'>
                                                <i class='fas fa-trash-alt'></i> 
                                            </button>
                                        </a>
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
