<?php
include 'connection.php'; include 'sidebar.php';

$sql = "SELECT b.id, b.id_barang, b.nama_barang, b.merk, b.harga_beli, b.harga_jual, b.stok, b.satuan_barang, k.nama_kategori
        FROM barang b
        JOIN kategori k ON b.id_kategori = k.id_kategori";

$result = $conn->query($sql);
?>

<div class="container">
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
                                        <a href='edit-barang.php?id=" . $row['id'] . "'>
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
                            <td>Tanggal Input</td>
                            <td><input type="text" class="form-control" name="tgl_input" value="<?php echo date('Y-m-d H:i:s'); ?>" readonly></td> 
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
    $tgl_input = $_POST['tgl_input']; 

    $sql = "INSERT INTO `barang` (`id_barang`, `id_kategori`, `nama_barang`, `merk`, `harga_beli`, `harga_jual`, `satuan_barang`, `stok`, `tgl_input`) 
            VALUES ('$id_barang', '$kelas', '$nama_barang', '$merk', '$harga_beli', '$harga_jual', '$satuan_barang', '$stok', '$tgl_input')";

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
                }, 1500); 
            }
        };

</script>

<?php include 'footer.php'; ?>
