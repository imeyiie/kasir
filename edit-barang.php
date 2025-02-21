<?php 
include 'connection.php'; 
include 'sidebar.php';  

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $id_barang = $_POST['id_barang'];
    $nama_barang = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $merk = $_POST['merk'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];
    $satuan_barang = $_POST['satuan_barang'];
    $stok = $_POST['stok'];
    $tgl_update = $_POST['tgl_update'];

    $query_stok = mysqli_query($conn, "SELECT stok FROM barang WHERE id = $id");
    $row = mysqli_fetch_assoc($query_stok);
    $stok_lama = $row['stok'];

    if ($stok < $stok_lama) {
        echo "<script>alert('Stok hanya bisa ditambah, tidak bisa dikurangi!'); window.location.href='master-barang.php';</script>";
        exit();
    }

    if (!empty($_FILES['gambar']['name'])) {
        $gambar = $_FILES['gambar']['name'];
        $target_dir = "img/";
        $target_file = $target_dir . basename($gambar);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowedTypes = array('jpg', 'png', 'jpeg', 'gif');
    
        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            } else {
                echo "<script>alert('Gagal mengupload gambar');</script>";
                exit();
            }
        } else {
            echo "<script>alert('Hanya gambar dengan format JPG, JPEG, PNG, atau GIF yang diperbolehkan');</script>";
            exit();
        }
    } else {
        $query_gambar = mysqli_query($conn, "SELECT gambar FROM barang WHERE id = $id");
        $row = mysqli_fetch_assoc($query_gambar);
        $gambar = $row['gambar'];
    }
    
    $update = mysqli_query($conn, "UPDATE barang SET 
        id_barang = '$id_barang',
        nama_barang = '$nama_barang',
        id_kategori = '$kategori',
        merk = '$merk',
        harga_beli = '$harga_beli',
        harga_jual = '$harga_jual',
        satuan_barang = '$satuan_barang',
        stok = '$stok',
        tgl_update = '$tgl_update',
        gambar = '$gambar' 
        WHERE id = $id");

    if ($update) {
        echo "<script> 
                window.location.href='master-barang.php?success-edit'; 
            </script>";
    } else {
        echo "<script> 
                alert('Gagal mengupdate data'); 
                window.location.href='master-barang.php'; 
            </script>";
    }
}


$id = $_GET['id'];

$tampil = mysqli_query($conn, "SELECT * FROM barang JOIN kategori
ON barang.id_kategori = kategori.id_kategori WHERE id = $id");

if (!$tampil) {
    die("Query failed: " . mysqli_error($conn)); 
}

$data = mysqli_fetch_array($tampil);

if (!$data) {
    echo "Data barang tidak ditemukan."; 
    exit();
}
?>

<div class="container">
    <div class="card card-body">
        <h2 class="mb-4">Edit Data Barang</h2>
        <a href="master-barang.php" class="text-decoration-none text-muted mb-3"><i class="fa fa-arrow-left"></i> Kembali</a>
        <div class="table-responsive">
            <table class="table table-striped">
                <form method="post" action="" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?=$data['id']?>">
                    <tr>
                        <td>ID Barang</td>
                        <td><input type="text" class="form-control" value="<?php echo $data['id_barang'];?>" name="id_barang" readonly></td> <!-- ID Barang, tidak dapat diubah -->
                    </tr>   
                    <tr>
                        <td>Nama Barang</td>
                        <td><input type="text" class="form-control" value="<?php echo $data['nama_barang'];?>" name="nama_barang"></td>
                    </tr>  
                    <tr>
                        <td>Kategori Barang</td>
                        <td>
                            <select name="kategori" class="form-control" required>
                            <option value="<?php echo $data['id_kategori'];?>"><?php echo $data['nama_kategori'];?></option>
                            <?php 
                            include 'config.php';
                            $sql = "SELECT * FROM kategori";
                            $result = mysqli_query($conn, $sql);
                            ?>
                            <?php while ($row = mysqli_fetch_assoc($result)) { 
                                echo "<option value='{$row['id_kategori']}'>{$row['nama_kategori']}</option>"; 
                            } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Merk</td>
                        <td><input type="text" class="form-control" value="<?php echo $data['merk'];?>" name="merk"></td>
                    </tr>  
                    <tr>
                        <td>Harga Beli</td>
                        <td><input type="text" class="form-control" value="<?php echo $data['harga_beli'];?>" name="harga_beli"></td>
                    </tr>  
                    <tr>
                        <td>Harga Jual</td>
                        <td><input type="text" class="form-control" value="<?php echo $data['harga_jual'];?>" name="harga_jual"></td>
                    </tr>  
                    <tr>
                        <td>Satuan Barang</td>
                        <td>
                            <select class="form-control" name="satuan_barang">
                                <option value="PCS" <?php if ($data['satuan_barang'] == 'PCS') echo 'selected'; ?>>PCS</option>
                                <option value="Box" <?php if ($data['satuan_barang'] == 'BOX') echo 'selected'; ?>>Box</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Stok</td>
                        <td><input type="text" class="form-control" value="<?php echo $data['stok'];?>" name="stok"></td>
                    </tr>
                    <tr>
                        <td>Tanggal Update Barang</td>
                        <td><input type="text" class="form-control" name="tgl_update" value="<?php echo date('Y-m-d H:i:s'); ?>" readonly></td> 
                    </tr>  
                    <tr>
                        <td>Gambar Barang</td>
                        <td>
                            <?php if ($data['gambar']) { ?>
                                <img src="img/<?=$data['gambar']?>" width="100" alt="Gambar Barang">
                            <?php } ?>
                            <br>
                            <input type="file" class="form-control" name="gambar">
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar</small>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button type="submit" name="update" class="btn btn-warning"><i class="fa fa-edit"></i> Update Data</button></td>
                    </tr>
                </form>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
