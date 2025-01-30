<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User - Beauty Unnie</title>
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>
<body>
    <?php
    include 'connection.php'; include 'sidebar.php';

    $sql = "SELECT l.user, m.nm_member, m.alamat_member, m.telepon, m.email, m.NIK, r.nama_role
            FROM login l
            JOIN member m ON l.id_member = m.id_member
            JOIN role r ON m.id_role = r.id_role";
    
    $result = $conn->query($sql);
    ?>

    <div class="container mt-4">
        <h2 class="mb-4">Data User</h2>

        <div class="mb-3">
            <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">Tambah</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
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
                                    <button class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#editModal' data-user='" . $row['user'] . "' data-nm_member='" . $row['nm_member'] . "' data-alamat='" . $row['alamat_member'] . "' data-telepon='" . $row['telepon'] . "' data-email='" . $row['email'] . "' data-nik='" . $row['NIK'] . "'>
                                        <i class='fas fa-edit'></i>
                                    </button>
                                    <button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#deleteModal' data-user='" . $row['user'] . "'>
                                        <i class='fas fa-trash-alt'></i>
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

    <?php include 'footer.php'; ?>
