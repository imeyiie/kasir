<?php
include 'connection.php';
include 'sidebar.php'; 

if (isset($_SESSION['id_member']) && $_SESSION['id_member'] > 0) {
    $id_member = $_SESSION['id_member'];
    $query = mysqli_query($conn, "SELECT * FROM member WHERE id_member = '$id_member'");
    $user = mysqli_fetch_array($query);

    if ($user) {
        $nama = $user['nm_member'];
        $email = $user['email'];
        $telepon = $user['telepon'];
        $nik = $user['NIK'];
        $alamat = $user['alamat_member'];
        $gambar = $user['gambar'];
    } else {
        echo "Data pengguna tidak ditemukan!";
        exit;
    }
} else {
    echo "Anda harus login terlebih dahulu!";
    exit;
}
?>

<div class="container">
    <div class="card">
        <div class="card-body">
            <h2 class="mb-4">Profile Pengguna Aplikasi</h2>

            <?php
                if (isset($_GET['success-edit']) && $_GET['success-edit'] == 1) {
                    echo '<div class="alert alert-warning" role="alert" id="alert">Data berhasil diubah!</div>';
                } if (isset($_GET['success-photo']) && $_GET['success-photo'] == 1) {
                    echo '<div class="alert alert-primary" role="alert" id="alert">Foto Profil berhasil diubah!</div>';
                } if (isset($_GET['success-pass']) && $_GET['success-pass'] == 1) {
                    echo '<div class="alert alert-success" role="alert" id="alert">Password berhasil diubah!</div>';
                }
            ?>

            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card p-3 profile-card">
                        <h5><i class="fas fa-user"></i> Foto Profil</h5>
                        <img src="img/<?php echo $gambar; ?>" class="profile-img mx-auto d-block" alt="Foto Profil">
                        <form action="upload-profile.php" method="POST" enctype="multipart/form-data">
                            <input type="file" name="gambar" class="form-control mt-2">
                            <button type="submit" class="btn btn-primary mt-2 btn-profile"><i class="fas fa-upload"></i> Ganti Foto</button>
                        </form>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card p-3 profile-card">
                        <h5><i class="fas fa-user-cog"></i> Kelola Data</h5>
                        <form action="update-profile.php" method="POST">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="nama" value="<?php echo $nama; ?>" required>

                            <label>Email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" required>

                            <label>Telepon</label>
                            <input type="text" class="form-control" name="telepon" value="<?php echo $telepon; ?>" required>

                            <label>NIK (KTP)</label>
                            <input type="text" class="form-control" name="nik" value="<?php echo $nik; ?>" required>

                            <label>Alamat</label>
                            <textarea class="form-control" name="alamat" required><?php echo $alamat; ?></textarea>

                            <button type="submit" class="btn btn-warning mt-3 btn-profile"><i class="fas fa-edit"></i> Ubah Profile </button>
                        </form>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card p-3 profile-card">
                        <h5><i class="fas fa-lock"></i> Ganti Password</h5>
                        <form action="update-password.php" method="POST">
                            <label>Username</label>
                            <input type="text" class="form-control" value="<?php echo $_SESSION['user']; ?>" readonly>

                            <label>Password Baru</label>
                            <input type="password" name="new_password" class="form-control" placeholder="Masukkan Password Baru" required>

                        <button type="submit" class="btn btn-success mt-3 btn-profile"><i class="fas fa-edit"></i> Ubah Password </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    window.onload = function() {
        const alertElement = document.getElementById('alert');
        if (alertElement) {
            setTimeout(function() {
                alertElement.style.display = 'none';
            }, 1500);
        }
    };
</script>

<?php include "footer.php"; ?>

<script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>