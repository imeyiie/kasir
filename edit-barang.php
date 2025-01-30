<?php 
include 'connection.php'; 
include 'sidebar.php'; 

if (isset($_POST['update'])) {
    // Ambil data dari form
    $id = $_POST['id'];
    $nama_barang = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $merk = $_POST['merk'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];
    $satuan_barang = $_POST['satuan_barang'];
    $tgl_update = $_POST['tgl_update']; // jika ingin menyimpan tanggal update, meskipun readonly

    // Update data barang
    $update = mysqli_query($conn, "UPDATE barang SET 
        nama_barang = '$nama_barang',
        id_kategori = '$kategori',
        merk = '$merk',
        harga_beli = '$harga_beli',
        harga_jual = '$harga_jual',
        satuan_barang = '$satuan_barang',
        tgl_update = '$tgl_update'
        WHERE id = $id");

    // Cek apakah query berhasil
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

while ($data = mysqli_fetch_array($tampil)):
?>

<div class="container">
    <div class="card card-body">
        <h2 class="mb-4">Edit Data Barang</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <form method="post" action="">
                    <input type="hidden" name="id" value="<?=$data['id']?>">
                    <tr>
                        <td>ID Barang</td>
                        <td><input type="text" class="form-control" value="<?php echo $data['id_barang'];?>" name="id_barang" readonly></td>
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
                                <option value="Box" <?php if ($data['satuan_barang'] == 'Box') echo 'selected'; ?>>Box</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Tanggal Update Barang</td>
                        <td><input type="text" class="form-control" name="tgl_update" value="<?php echo date('Y-m-d H:i:s'); ?>" readonly></td> 
                    </tr>  
                    <tr>
                        <td></td>
                        <td><button type="submit" name="update" class="btn btn-primary"><i class="fa fa-edit"></i> Update Data</button></td>
                    </tr>

                </form>
            </table>
        </div>
    </div>
</div>

<?php endwhile; ?>

<?php include 'footer.php'; ?>
