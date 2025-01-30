    <?php
    include 'connection.php';
    include 'sidebar.php';

    $kategoriSql = "SELECT id_kategori, nama_kategori FROM kategori";
    $kategoriResult = $conn->query($kategoriSql);
    ?>

<div class="container mt-4">
    <div class="card">
        <div class="card-body">
            <h2 class="mb-4">Data Kategori</h2>

            <?php
            if (isset($_GET['success-edit'])) {
                echo '<div class="alert alert-primary" role="alert" id="alert">Data kategori berhasil diubah!</div>';
            } elseif (isset($_GET['success-insert'])) {
                echo '<div class="alert alert-success" role="alert" id="alert">Data kategori berhasil ditambahkan!</div>';
            } elseif (isset($_GET['success-delete'])) {
                echo '<div class="alert alert-danger" role="alert" id="alert">Data kategori berhasil dihapus!</div>';
            }
            ?>

            <form id="kategoriForm" action="proses-kategori.php" method="POST">
                <input type="hidden" id="id_kategori" name="id_kategori">
                <div class="mb-3 d-flex">
                    <input type="text" class="form-control form-control-lg me-2" id="nama_kategori" name="nama_kategori" placeholder="Masukkan Kategori Barang Baru" style="width: 400px;" required>
                    <button type="submit" id="actionButton" name="action" value="insert" class="btn btn-primary btn-lg me-2">+ Insert Data</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>No.</th>
                            <th>Nama Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($kategoriResult->num_rows > 0) {
                            $no = 1;
                            while ($kategori = $kategoriResult->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . $kategori['nama_kategori'] . "</td>";
                                echo "<td>
                                        <button type='button' class='btn btn-sm btn-primary' onclick='editKategori(" . $kategori['id_kategori'] . ", `" . $kategori['nama_kategori'] . "`)' title='Edit'>
                                            <i class='fas fa-edit'></i>
                                        </button>
                                        <a href='proses-kategori.php?action=delete&id=" . $kategori['id_kategori'] . "' class='btn btn-sm btn-danger' title='Hapus' onclick='return confirm(\"Yakin ingin menghapus kategori ini?\")'>
                                            <i class='fas fa-trash'></i>
                                        </a>
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
        </div>
    </div>
</div>


    <script>
        let isEditing = false;

        function editKategori(id, nama) {
            isEditing = true;
            document.getElementById('id_kategori').value = id;
            document.getElementById('nama_kategori').value = nama;
            document.getElementById('actionButton').innerText = 'Update Data';
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
                }, 1500); 
            }
        };
    </script>

    <?php include 'footer.php'; ?>
