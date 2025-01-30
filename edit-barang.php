<?php 
include 'connection.php'; 
include 'sidebar.php'; 

// Memastikan parameter 'id_barang' ada di URL
$id = isset($_GET['id_barang']) ? $_GET['id_barang'] : '';

if ($id) {
    // Query untuk mendapatkan data barang berdasarkan id_barang
    $tampil = mysqli_query($conn, "SELECT b.id, b.id_barang, b.nama_barang, b.merk, b.harga_beli, b.harga_jual, b.stok, b.satuan_barang, k.nama_kategori
                                   FROM barang b 
                                   JOIN kategori k ON b.id_kategori = k.id_kategori
                                   WHERE b.id_barang = '$id'");

    if (mysqli_num_rows($tampil) > 0) {
        // Menampilkan data
        while ($data = mysqli_fetch_array($tampil)):   
?>
            <a href="master-barang.php" class="btn btn-primary mb-3"><i class="fa fa-angle-left"></i> Balik </a>
            <h4>Edit Data Barang</h4>

            <div class="card card-body">
                <div class="table-responsive">
                    <form method="post" action="">
                        <input type="hidden" name="id_barang" value="<?php echo $data['id'];?>">
                        <table class="table table-striped">
                            <tr>
                                <td>ID Barang</td>
                                <td><input type="text" class="form-control" value="<?php echo $data['id_barang'];?>" name="id_barang" readonly></td>
                            </tr>
                            <tr>
                                <td>Nama Barang</td>
                                <td><input type="text" class="form-control" value="<?php echo $data['nama_barang'];?>" name="nama_barang"></td>
                            </tr>
                            <tr>
                                <td>Merk</td>
                                <td><input type="text" class="form-control" value="<?php echo $data['merk'];?>" name="merk"></td>
                            </tr>
                            <tr>
                                <td>Harga Beli</td>
                                <td><input type="number" class="form-control" value="<?php echo $data['harga_beli'];?>" name="harga_beli"></td>
                            </tr>
                            <tr>
                                <td>Harga Jual</td>
                                <td><input type="number" class="form-control" value="<?php echo $data['harga_jual'];?>" name="harga_jual"></td>
                            </tr>
                            <tr>
                                <td>Satuan Barang</td>
                                <td>
                                    <select name="satuan_barang" class="form-control" required>
                                        <option value="pcs" <?php echo ($data['satuan_barang'] == 'pcs') ? 'selected' : ''; ?>>PCS</option>
                                        <option value="box" <?php echo ($data['satuan_barang'] == 'box') ? 'selected' : ''; ?>>Box</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Stok</td>
                                <td><input type="number" class="form-control" value="<?php echo $data['stok'];?>" name="stok"></td>
                            </tr>
                            <tr>
                                <td>Kategori</td>
                                <td><input type="text" class="form-control" value="<?php echo $data['nama_kategori'];?>" readonly></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><button type="submit" name="update" class="btn btn-primary"><i class="fa fa-edit"></i> Update Data</button></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>

        <?php endwhile; ?>
    <?php 
    } else {
        echo "Data tidak ditemukan.";
    }
} else {
    echo "ID Barang tidak ditemukan.";
}

// Proses update data jika tombol submit ditekan
if (isset($_POST['update'])) {
    $id_barang = $_POST['id_barang'];
    $nama_barang = $_POST['nama_barang'];
    $merk = $_POST['merk'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];
    $satuan_barang = $_POST['satuan_barang'];
    $stok = $_POST['stok'];

    $sql = "UPDATE barang SET nama_barang = '$nama_barang', merk = '$merk', harga_beli = '$harga_beli', harga_jual = '$harga_jual', 
            satuan_barang = '$satuan_barang', stok = '$stok' WHERE id_barang = '$id_barang'";

    $query = mysqli_query($conn, $sql);

    if ($query) {
        echo "<script> 
                window.location.href='master-barang.php?success-edit';
              </script>";
    } else {
        echo "<script> 
                window.location.href='master-barang.php';
              </script>";
    }
}
?>

<?php include 'footer.php'; ?>
