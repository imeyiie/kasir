    <?php 
    include 'connection.php'; 
    include 'sidebar.php'; 

    $id = $_GET['id'];
    $tampil = mysqli_query($conn, "SELECT * FROM barang JOIN kategori
    ON barang.id_kategori = kategori.id_kategori WHERE id = $id");  

    while ($data = mysqli_fetch_array($tampil)):
    ?>

    <div class="container">
        <div class="card card-body">
            <h2 class="mb-4">Detail Barang</h2>
            <a href="master-barang.php" class="text-decoration-none text-muted mb-3"><i class="fa fa-arrow-left"></i> Kembali</a>
            <div class="row">   
                <div class="col-md-4 text-center">
                    <?php if (!empty($data['gambar'])): ?>
                        <img src="img/<?php echo $data['gambar']; ?>" alt="Foto Barang" class="img-fluid" style="max-width: 80%; height: auto;">
                    <?php else: ?>
                        <img src="img/no-image.jpg" alt="No Image" class="img-fluid" style="max-width: 80%; height: auto;">
                    <?php endif; ?>
                </div>

                <div class="col-md-8">
                    <table class="table table-striped">
                        <tr>
                            <td>ID Barang</td>
                            <td><span class="form-control-plaintext"><?php echo $data['id_barang'];?></span></td>
                        </tr>   
                        <tr>
                            <td>Nama Barang</td>
                            <td><span class="form-control-plaintext"><?php echo $data['nama_barang'];?></span></td>
                        </tr>  
                        <tr>
                            <td>Kategori Barang</td>
                            <td><span class="form-control-plaintext"><?php echo $data['nama_kategori'];?></span></td>
                        </tr>
                        <tr>
                            <td>Merk</td>
                            <td><span class="form-control-plaintext"><?php echo $data['merk'];?></span></td>
                        </tr>  
                        <tr>
                            <td>Harga Beli</td>
                            <td><span class="form-control-plaintext"><?php echo number_format($data['harga_beli'], 0, ',', '.');?></span></td>
                        </tr>  
                        <tr>
                            <td>Harga Jual</td>
                            <td><span class="form-control-plaintext"><?php echo number_format($data['harga_jual'], 0, ',', '.');?></span></td>
                        </tr>  
                        <tr>
                            <td>Satuan Barang</td>
                            <td><span class="form-control-plaintext"><?php echo $data['satuan_barang'];?></span></td>
                        </tr>
                        <tr>
                            <td>Tanggal Update</td>
                            <td><span class="form-control-plaintext"><?php echo $data['tgl_update'];?></span></td>
                        </tr> 
                    </div>
                </div>
            </div>
        </div>

    <?php endwhile; ?>

    <?php include 'footer.php'; ?>
