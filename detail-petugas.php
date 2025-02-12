<?php 
include 'connection.php'; 
include 'sidebar.php'; 

$id = $_GET['id'];
$tampil = mysqli_query($conn, "SELECT * FROM member 
    JOIN role ON member.id_role = role.id_role 
    WHERE id_member = $id");  

while ($data = mysqli_fetch_array($tampil)):
?>

<div class="container">
    <div class="card card-body">
        <h2 class="mb-4">Detail Data Petugas</h2>
        <a href="master-petugas.php" class="text-decoration-none text-muted mb-3"><i class="fa fa-arrow-left"></i> Kembali</a>
        <div class="row">   
            <div class="col-md-4 text-center">
                <?php if (!empty($data['gambar'])): ?>
                    <img src="img/<?php echo $data['gambar']; ?>" alt="Foto Member" class="img-fluid" style="max-width: 80%; height: auto;">
                <?php else: ?>
                    <img src="img/no-image.jpg" alt="No Image" class="img-fluid" style="max-width: 80%; height: auto;">
                <?php endif; ?>
            </div>

            <div class="col-md-8">
                <table class="table table-striped">
                    <tr>
                        <td>Role</td>
                        <td><span class="form-control-plaintext"><?php echo $data['nama_role'];?></span></td>
                    </tr>
                    <tr>
                        <td>Nama Lengkap</td>
                        <td><span class="form-control-plaintext"><?php echo $data['nm_member'];?></span></td>
                    </tr>  
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td><span class="form-control-plaintext"><?php echo $data['jenis_kelamin'];?></span></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td><span class="form-control-plaintext"><?php echo $data['alamat_member'];?></span></td>
                    </tr>  
                    <tr>
                        <td>No Telepon</td>
                        <td><span class="form-control-plaintext"><?php echo $data['telepon'];?></span></td>
                    </tr>  
                    <tr>
                        <td>Email</td>
                        <td><span class="form-control-plaintext"><?php echo $data['email'];?></span></td>
                    </tr>  
                    <tr>
                        <td>NIK</td>
                        <td><span class="form-control-plaintext"><?php echo $data['NIK'];?></span></td>
                    </tr>
                    <tr>
                        <td>Tanggal Masuk</td>
                        <td><span class="form-control-plaintext"><?php echo $data['tgl_masuk'];?></span></td>
                    </tr>  
                </table>
            </div>
        </div>
    </div>
</div>

<?php endwhile; ?>

<?php include 'footer.php'; ?>
