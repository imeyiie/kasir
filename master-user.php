<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User - Beauty Unnie</title>
    
    <link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="assets/login.css">

    <style>
        .table {
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #D8B4E2; /* Ungu pastel */
            color: #fff;
            font-weight: bold;
            text-align: center;
        }

        .table td {
            background-color: #F3E5F5; /* Warna latar belakang tabel */
            color: #6A4C93; /* Ungu gelap untuk teks */
            text-align: center;
        }

        .table tr:hover {
            background-color: #E1BEE7; /* Efek hover */
        }

        .table thead th {
            font-size: 1rem;
            padding: 12px;
        }

        .table td {
            padding: 10px;
            font-size: 1rem;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #F8F3FB;
        }

        .table-bordered {
            border: 1px solid #D1A7D7; /* Border tabel */
        }

        .table-responsive {
            margin-top: 20px;
        }

        .table .btn {
            margin: 2px;
            border-radius: 5px;
            padding: 5px 10px;
        }

        .table .btn-primary {
            background-color: #9C27B0;  
            border: none;
        }

        .table .btn-danger {
            background-color: #F44336; 
            border: none;
        }

        .table .btn-success {
            background-color: #4CAF50;
            border: none;
        }

        .table .btn:hover {
            opacity: 0.9;
        }

    </style>
</head>
<body>
    <?php
    include 'config/connection.php';

    $sql = "SELECT u.id_user, u.username, u.nama_user, u.alamat_user, u.no_telepon, r.nama_role 
            FROM melan_user u
            JOIN melan_role r ON u.id_role = r.id_role";
    $result = $conn->query($sql);
    ?>
    
    <?php include 'header.php'; ?>

            <div class="container mt-4">
                <h2 class="mb-4">Data User</h2>

                <div class="mb-3">
                    <a href="#" class="btn btn-success">Tambah</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Alamat</th>
                                <th>No Telepon</th>
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
                                    echo "<td>" . $row['nama_user'] . "</td>";
                                    echo "<td>" . $row['alamat_user'] . "</td>";
                                    echo "<td>" . $row['no_telepon'] . "</td>";
                                    echo "<td>" . $row['username'] . "</td>";
                                    echo "<td>" . $row['nama_role'] . "</td>";
                                    echo "<td>
                                            <a href='#' class='btn btn-sm btn-primary'>Edit</a>
                                            <a href='#' class='btn btn-sm btn-danger'>Hapus</a>
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

    <?php include 'footer.php'; ?>

    <script src="assets/bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>
