<?php
ob_start();
include 'connection.php';
include 'sidebar.php';

$perPage = 10; 

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $perPage;

$sql = "SELECT id_kategori, nama_kategori FROM kategori LIMIT $perPage OFFSET $offset";
$result = $conn->query($sql);

$sqlCount = "SELECT COUNT(*) AS total FROM kategori";
$resultCount = $conn->query($sqlCount);
$rowCount = $resultCount->fetch_assoc();
$totalRows = $rowCount['total'];

$totalPages = ceil($totalRows / $perPage);

?>

<div class="container">
    <div class="card">
        <div class="card-body">
            <h2 class="mb-4">Data Kategori</h2>

            <?php
            if (isset($_GET['success-edit'])) {
                echo '<div class="alert alert-warning" role="alert" id="alert">Data kategori berhasil diubah!</div>';
            } elseif (isset($_GET['success-insert'])) {
                echo '<div class="alert alert-primary" role="alert" id="alert">Data kategori berhasil ditambahkan!</div>';
            } elseif (isset($_GET['success-delete'])) {
                echo '<div class="alert alert-danger" role="alert" id="alert">Data kategori berhasil dihapus!</div>';
            }
            ?>

            <form id="kategoriForm" action="" method="POST">
                <div class="d-flex justify-content-between mb-3">
                    <input type="hidden" id="id_kategori" name="id_kategori">
                    <div class="d-flex">
                        <input type="text" class="form-control form-control-md me-2" id="nama_kategori" name="nama_kategori" placeholder="Masukkan Kategori Barang Baru" style="width: 350px;" required>
                        <button type="submit" id="actionButton" name="action" value="insert" class="btn btn-primary btn-md me-2">+ Tambah Data</button>
                        <button type="button" class="btn btn-success btn-md" onclick="refreshPage()">Refresh</button>
                    </div>

                    <input type="text" id="searchInput" class="form-control w-25" placeholder="Cari Kategori...">
                </div>    
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="kategoriTable">
                    <thead class="table-primary">
                        <tr>
                            <th>No.</th>
                            <th>Nama Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            $no = 1;
                            while ($kategori = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . $kategori['nama_kategori'] . "</td>";
                                echo "<td>
                                        <button type='button' class='btn btn-sm btn-warning' onclick='editKategori(" . $kategori['id_kategori'] . ", `" . $kategori['nama_kategori'] . "`)' title='Edit'>
                                            <i class='fas fa-pencil-alt'></i> 
                                        </button>
                                        <button type='button' class='btn btn-sm btn-danger' title='Hapus' data-bs-toggle='modal' data-bs-target='#deleteModal' onclick='setDeleteId(" . $kategori['id_kategori'] . ")'>
                                           <i class='fas fa-trash'></i>
                                        </button>
                                    </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>Tidak ada data kategori</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex mt-3 pagination-container">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item <?= ($page == 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=1">First</a>
                        </li>
                        <li class="page-item <?= ($page == 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?= $page - 1; ?>">Previous</a>
                        </li>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <li class="page-item <?= ($page == $totalPages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?= $page + 1; ?>">Next</a>
                        </li>
                        <li class="page-item <?= ($page == $totalPages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?= $totalPages; ?>">Last</a>
                        </li>
                    </ul>
                </nav>
            </div>

        </div>
    </div>
</div>

<div id="deleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 0px;">
            <div class="modal-header" style="background: #f8d7da; color: #721c24;">
                <h5 class="modal-title"><i class="fa fa-trash-alt"></i> Hapus Data Kategori</h5>
            </div>
            <form id="deleteForm" method="GET" action="">
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus kategori ini?</p>
                    <input type="hidden" name="id" id="id_delete">
                    <input type="hidden" name="action" value="delete">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_kategori'];
    $nama = $_POST['nama_kategori'];
    $action = $_POST['action'];

    if ($action === 'insert') {
        $query = "INSERT INTO kategori (nama_kategori) VALUES ('$nama')";
        if (mysqli_query($conn, $query)) {
            header('Location: master-kategori.php?success-insert');
            exit;
        }
    } elseif ($action === 'update') {
        $query = "UPDATE kategori SET nama_kategori = '$nama' WHERE id_kategori = $id";
        if (mysqli_query($conn, $query)) {
            header('Location: master-kategori.php?success-edit');
            exit;
        }
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = $_GET['id'];
    $query = "DELETE FROM kategori WHERE id_kategori = $id";

    if (mysqli_query($conn, $query)) {
        header('Location: master-kategori.php?success-delete');
        exit;
    }
}
ob_end_flush();
?>

<script>

    searchInput.addEventListener("keyup", function() {
        let filter = searchInput.value.toLowerCase();
        let rows = document.querySelectorAll("#kategoriTable tbody tr");

        rows.forEach(row => {
            let namaKategori = row.cells[1].textContent.toLowerCase();

            if (namaKategori.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });

    function setDeleteId(id) {
        document.getElementById('id_delete').value = id;
    }

    let isEditing = false;

    function editKategori(id, nama) {
        isEditing = true;
        document.getElementById('id_kategori').value = id;
        document.getElementById('nama_kategori').value = nama;
        document.getElementById('actionButton').innerText = 'Edit Data';
        document.getElementById('actionButton').classList.add('btn-warning');
        document.getElementById('actionButton').value = 'update';
    }

    function resetForm() {
        isEditing = false;
        document.getElementById('id_kategori').value = '';
        document.getElementById('nama_kategori').value = '';
        document.getElementById('actionButton').innerText = '+ Insert Data';
        document.getElementById('actionButton').value = 'insert';
    }

    window.onload = function() {
        const alertElement = document.getElementById('alert');
        if (alertElement) {
            setTimeout(function() {
                alertElement.style.display = 'none';
            }, 3000);
        }
    };

    function refreshPage() {
        window.location.reload();
    }

</script>

<?php include "footer.php"; ?>

<script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script> 