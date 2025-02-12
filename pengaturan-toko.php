<?php
include 'connection.php';
include 'sidebar.php';

$query = "SELECT id_toko, nama_toko, alamat_toko, tlp, nama_pemilik FROM toko WHERE id_toko = 1"; // Sesuaikan ID toko jika perlu
$result = mysqli_query($conn, $query);
$toko = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_toko = $_POST['nama_toko'];
    $alamat_toko = $_POST['alamat_toko'];
    $tlp = $_POST['tlp'];
    $nama_pemilik = $_POST['nama_pemilik'];

    $update_query = "UPDATE toko SET 
        nama_toko = '$nama_toko', 
        alamat_toko = '$alamat_toko', 
        tlp = '$tlp', 
        nama_pemilik = '$nama_pemilik' 
        WHERE id_toko = 1"; 

    if (mysqli_query($conn, $update_query)) {
        echo "<script> 
                window.location.href='pengaturan-toko.php?success-edit'; 
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<div class="container mt-4">
    <div class="card p-4 shadow-sm">
        <h2 class="mb-3">Pengaturan Toko</h2>

        <?php
            if (isset($_GET['success-edit'])) {
                echo '<div class="alert alert-warning" role="alert" id="alert">Pengaturan Toko berhasil diubah!</div>';
            }
        ?>

        <form action="" method="POST">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama_toko" class="form-label">Nama Toko</label>
                        <input type="text" class="form-control w-80" id="nama_toko" name="nama_toko" value="<?= $toko['nama_toko']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="tlp" class="form-label">Telp</label>
                        <input type="text" class="form-control w-80" id="tlp" name="tlp" value="<?= $toko['tlp']; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="alamat_toko" class="form-label">Alamat Toko</label>
                        <input type="text" class="form-control w-80" id="alamat_toko" name="alamat_toko" value="<?= $toko['alamat_toko']; ?>">
                    </div>  
                    <div class="mb-3">
                        <label for="nama_pemilik" class="form-label">Nama Pemilik</label>
                        <input type="text" class="form-control w-80" id="nama_pemilik" name="nama_pemilik" value="<?= $toko['nama_pemilik']; ?>">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-warning mt-3 px-4">
                <i class="fa fa-edit me-2"></i> Update
            </button>
        </form>
    </div>
</div>

<script>
    window.onload = function() {
    const alertElement = document.getElementById('alert');
        if (alertElement) {
            setTimeout(function() {
                alertElement.style.display = 'none';
            }, 3000); 
        }
    };
</script>
<?php
include 'footer.php';
?>
