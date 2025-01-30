<<<<<<< HEAD
<?php
include 'connection.php'; include 'sidebar.php';

$sql = "SELECT b.id, b.id_barang, b.nama_barang, b.merk, b.harga_beli, b.harga_jual, b.stok, b.satuan_barang, k.nama_kategori
        FROM barang b
        JOIN kategori k ON b.id_kategori = k.id_kategori";

$result = $conn->query($sql);
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-body">
            <h2 class="mb-4">Data Barang</h2>

            <?php
            if (isset($_GET['success-edit'])) {
                echo '<div class="alert alert-primary" role="alert" id="alert">Data Barang berhasil diubah!</div>';
            } elseif (isset($_GET['success-insert'])) {
                echo '<div class="alert alert-success" role="alert" id="alert">Data Barang berhasil ditambahkan!</div>';
            } elseif (isset($_GET['success-delete'])) {
                echo '<div class="alert alert-danger" role="alert" id="alert">Data Barang berhasil dihapus!</div>';
            }
        ?>
            
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <a href="#" class="btn" style="background-color: #b399d4; color: white;" data-bs-toggle="modal" data-bs-target="#tambahData">Tambah</a>
                    <a href="#" class="btn btn-warning" id="sortirBarang">Sortir Barang Kurang</a>
                    <a href="#" class="btn btn-success" id="refreshPage">Refresh</a>
                </div>

                <input type="text" id="searchInput" class="form-control w-25" placeholder="Cari Barang...">
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="barangTable">
                    <thead class="table-primary">
                        <tr>
                            <th>No.</th>
                            <th>ID Barang</th>
                            <th>Kategori</th>
                            <th>Nama Barang</th>
                            <th>Merk</th>
                            <th>Stok</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Satuan</th>
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
                                echo "<td>" . $row['id_barang'] . "</td>";
                                echo "<td>" . $row['nama_kategori'] . "</td>";
                                echo "<td>" . $row['nama_barang'] . "</td>";
                                echo "<td>" . $row['merk'] . "</td>";
                                echo "<td>" . $row['stok'] . "</td>";
                                echo "<td>" . $row['harga_beli'] . "</td>";
                                echo "<td>" . $row['harga_jual'] . "</td>";
                                echo "<td>" . $row['satuan_barang'] . "</td>";
                                echo "<td>
                                        <a href='detail-kelas2.php?id=" . $row['id'] . "'>
                                            <button class='btn btn-primary btn-sm'>
                                                <i class='fas fa-info-circle'></i> 
                                            </button>
                                        </a>
                                    
                                        <a href='edit-kelas2.php?id=" . $row['id'] . "'>
                                            <button class='btn btn-warning btn-sm'>
                                                <i class='fas fa-pencil-alt'></i> 
                                            </button>
                                        </a>
                                    
                                        <a href='hapus-barang.php?id=" . $row['id'] . "'>
                                            <button class='btn btn-danger btn-sm'>
                                                <i class='fas fa-trash-alt'></i> 
                                            </button>
                                        </a>
                                    </td>";
                                echo "</tr>";   
                            }
                        } else {
                            echo "<tr><td colspan='10'>Tidak ada data barang</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include 'connection.php';
$sql = "SELECT id_barang FROM barang ORDER BY id_barang DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if ($row) {
    $lastId = (int)substr($row['id_barang'], 2);
    $newId = 'BR' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT); 
} else {
    $newId = 'BR001';
}
?>

<div id="tambahData" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 0px;">
            <div class="modal-header" style="background: #c09dd1; color: #fff;">
                <h5 class="modal-title"><i class="fa fa-plus"></i> Tambah Data Barang</h5>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td>ID Barang</td>
                            <td><input type="text" required class="form-control" name="id_barang" value="<?php echo $newId; ?>" readonly></td>
                        </tr>
                        <tr>
                            <td>Kategori Barang</td>
                            <td><select class="form-control" name="kategori">
                                <option value="#"> - Pilih Kategori - </option>
                                    <?php
                                        include 'config.php';
                                            $sql = "SELECT * FROM kategori";
                                            $result = mysqli_query($conn, $sql);?>
                                    <?php
                                        while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='{$row['id_kategori']}'>{$row['nama_kategori']}
                                            </option>"; }?>
                                </select></td>
                        </tr>
                        <tr>
                            <td>Nama Barang</td>
                            <td><input type="text" required class="form-control" name="nama_barang"></td>
                        </tr>
                        <tr>
                            <td>Merk</td>
                            <td><input type="text" required class="form-control" name="merk"></td>
                        </tr>
                        <tr>
                            <td>Harga Beli</td>
                            <td><input type="number" required class="form-control" name="harga_beli"></td>
                        </tr>
                        <tr>
                            <td>Harga Jual</td>
                            <td><input type="number" required class="form-control" name="harga_jual"></td>
                        </tr>
                        <tr>
                            <td>Satuan Barang</td>
                            <td>
                                <select class="form-control" name="satuan_barang" required>
                                    <option value="pcs">PCS</option>
                                    <option value="box">Box</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Stok</td>
                            <td><input type="number" required class="form-control" name="stok"></td>
                        </tr>
                        <tr>
                            <td>Tanggal Update</td>
                            <td><input type="text" class="form-control" name="tanggal_update" value="<?php echo date('Y-m-d H:i:s'); ?>" readonly></td> 
                        </tr>
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

<div id="deleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 0px;">
            <div class="modal-header" style="background: #f8d7da; color: #721c24;">
                <h5 class="modal-title"><i class="fa fa-trash-alt"></i> Hapus Data Barang</h5>
            </div>
            <form method="POST" action="hapus-barang.php">
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus barang ini?</p>
                    <input type="hidden" name="id" id="id_delete">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" name="hapus_barang">Hapus</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    $id_barang = $_POST['id_barang'];
    $kelas = $_POST['kategori'];
    $nama_barang = $_POST['nama_barang'];
    $merk = $_POST['merk'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];
    $satuan_barang = $_POST['satuan_barang'];
    $stok = $_POST['stok'];
    $tanggal_update = $_POST['tanggal_update']; 

    $sql = "INSERT INTO `barang` (`id_barang`, `id_kategori`, `nama_barang`, `merk`, `harga_beli`, `harga_jual`, `satuan_barang`, `stok`, `tgl_input`) 
            VALUES ('$id_barang', '$kelas', '$nama_barang', '$merk', '$harga_beli', '$harga_jual', '$satuan_barang', '$stok', '$tanggal_update')";

    $query = mysqli_query($conn, $sql);

    if ($query) {
        echo "<script>
              window.location.href='master-barang.php?success-insert';
              </script>";
    } else {
        echo "<script>
              window.location.href='master-barang.php';
              </script>";
    }
}
?>

<script>
const searchInput = document.getElementById("searchInput");
searchInput.addEventListener("keyup", function() {
    let filter = searchInput.value.toLowerCase();
    let rows = document.querySelectorAll("#barangTable tbody tr");

    rows.forEach(row => {
        let namaBarang = row.cells[3].textContent.toLowerCase();
        let merk = row.cells[4].textContent.toLowerCase();

        if (namaBarang.includes(filter) || merk.includes(filter)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
});


document.getElementById('sortirBarang').addEventListener('click', function() {
    let rows = document.querySelectorAll("#barangTable tbody tr");
    
    rows.forEach(row => {
        let stok = parseInt(row.cells[5].textContent);
        if (stok < 10) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
});

document.getElementById('refreshPage').addEventListener('click', function() {
    location.reload();
});

var myModal = new bootstrap.Modal(document.getElementById('tambahData'));
myModal.hide();

document.querySelectorAll('.btn-danger').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        document.getElementById('id_delete').value = id; 
    });
});

window.onload = function() {
            const alertElement = document.getElementById('alert');
            if (alertElement) {
                setTimeout(function() {
                    alertElement.style.display = 'none';
                }, 1000); 
            }
        };

</script>

<?php include 'footer.php'; ?>
=======
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Barang - Beauty Unnie</title>

    <link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="assets/icons/fontawesome.min.css">
    <link rel="stylesheet" href="assets/login.css">
</head>
<body>
                <?php
                include 'config/connection.php';

                $sql = "SELECT b.id_barang, b.nama_barang, b.merk, b.harga_beli, b.harga_jual, b.satuan, b.stok, b.tgl_input, b.tgl_update, k.nama_kategori 
                        FROM barang b
                        JOIN kategori k ON b.id_kategori = k.id_kategori";
                $result = $conn->query($sql);
                ?>

                <?php include 'header.php'; ?>

                <div class="container mt-4">
                    <h2 class="mb-4">Data Barang</h2>

                    <?php if (isset($_GET['success'])) { ?>
                        <div class="alert alert-success">
                            <p>Data berhasil disimpan!</p>
                        </div>
                    <?php } ?>

                    <div class="mb-3">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahBarang">
                            <i class="fas fa-plus"></i> Tambah Barang
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="table-primary">
                                <tr>
                                    <th>No.</th>
                                    <th>ID Barang</th>
                                    <th>Kategori</th>
                                    <th>Nama Barang</th>
                                    <th>Merk</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
                                    <th>Satuan</th>
                                    <th>Stok</th>
                                    <th>Tgl Input</th>
                                    <th>Tgl Update</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    $no = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $no++ . "</td>";
                                        echo "<td>" . $row['id_barang'] . "</td>";
                                        echo "<td>" . $row['nama_kategori'] . "</td>";
                                        echo "<td>" . $row['nama_barang'] . "</td>";
                                        echo "<td>" . $row['merk'] . "</td>";
                                        echo "<td>Rp " . number_format($row['harga_beli'], 0, ',', '.') . "</td>";
                                        echo "<td>Rp " . number_format($row['harga_jual'], 0, ',', '.') . "</td>";
                                        echo "<td>" . $row['satuan'] . "</td>";
                                        echo "<td>" . $row['stok'] . "</td>";
                                        echo "<td>" . $row['tgl_input'] . "</td>";
                                        echo "<td>" . $row['tgl_update'] . "</td>";
                                        echo "<td>
                                                <a href='#' class='btn btn-sm btn-primary'>
                                                    <i class='fas fa-edit'></i> Edit
                                                </a>
                                                <a href='#' class='btn btn-sm btn-danger'>
                                                    <i class='fas fa-trash'></i> Hapus
                                                </a>
                                            </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='12'>Tidak ada data barang</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="modalTambahBarang" class="modal fade" tabindex="-1" aria-labelledby="modalTambahBarangLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTambahBarangLabel">Tambah Barang</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="fungsi/tambah_barang.php" method="POST">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="id_barang" class="form-label">ID Barang</label>
                                            <input type="text" name="id_barang" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="kategori" class="form-label">Kategori</label>
                                            <select name="id_kategori" class="form-control" required>
                                                <option value="">Pilih Kategori</option>
                                                <?php
                                                $kategoriQuery = "SELECT * FROM kategori";
                                                $kategoriResult = $conn->query($kategoriQuery);
                                                while ($kategori = $kategoriResult->fetch_assoc()) {
                                                    echo "<option value='" . $kategori['id_kategori'] . "'>" . $kategori['nama_kategori'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama_barang" class="form-label">Nama Barang</label>
                                        <input type="text" name="nama_barang" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="merk" class="form-label">Merk</label>
                                        <input type="text" name="merk" class="form-control" required>
                                    </div>  
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="harga_beli" class="form-label">Harga Beli</label>
                                            <input type="number" name="harga_beli" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="harga_jual" class="form-label">Harga Jual</label>
                                            <input type="number" name="harga_jual" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="satuan" class="form-label">Satuan</label>
                                        <select name="satuan" class="form-control" required>
                                            <option value="PCS">PCS</option>
                                            <option value="BOX">BOX</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="stok" class="form-label">Stok</label>
                                        <input type="number" name="stok" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tgl_input" class="form-label">Tanggal Input</label>
                                        <input type="text" name="tgl_input" class="form-control" readonly value="<?php echo date('d F Y'); ?>">
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div> 
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="assets/bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>
>>>>>>> 114b103d00cc3e496018367d93bd52d1793c7180
