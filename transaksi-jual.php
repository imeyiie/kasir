<?php 
include 'connection.php';
include 'sidebar.php'; 

$query_toko = "SELECT nama_toko, alamat_toko, tlp FROM toko LIMIT 1";
$result_toko = $conn->query($query_toko);
$store = $result_toko->fetch_assoc();

$nama_toko = $store['nama_toko'];
$alamat_toko = $store['alamat_toko'];
$tlp = $store['tlp'];
?>

<div class="container">
    <div class="card">
        <div class="card-body">
            <h2 class="mb-4">Keranjang Penjualan</h2>

            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="search-barang">Cari Barang</label>
                        <input type="text" id="search-barang" class="form-control" placeholder="Masukan: Kode / Nama Barang [ENTER]">
                    </div>
                </div>

                <div class="col-md-8">
                    <label>Hasil Pencarian</label>
                    <div class="bg-light p-2 border rounded">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Merk</th>
                                    <th>Harga Jual</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="daftar-barang">
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Hasil pencarian kosong</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <h6>KASIR</h6>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div id="tanggal-sekarang">Tanggal: <strong></strong></div>
                            <button class="btn btn-danger btn-sm" id="reset-keranjang">RESET KERANJANG</button>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                    <th>Kasir</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="keranjang-barang">
                                <tr>
                                    <td colspan="6" class="text-center">Keranjang kosong</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="total-semua">Total Semua</label>
                            <input type="text" id="total-semua" class="form-control" value="0" readonly>
                        </div>
                        <hr class="mt-2 mb-3">
                        <div class="form-group">
                            <label for="kembali">Kembali</label>
                            <div class="d-flex">
                                <input type="text" id="kembali" class="form-control" readonly>
                                <button class="btn btn-secondary ms-2" style="font-size: 14px;">
                                    <i class="fas fa-print"></i> Print
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bayar">Bayar</label>
                            <div class="d-flex">
                                <input type="text" id="bayar" class="form-control" placeholder="Masukkan jumlah bayar">
                                <button class="btn btn-success ms-2" id="btn-bayar">Bayar</button>
                            </div>
                        </div>
                        <hr class="mt-2 mb-3">
                    </div>
                </div>    
            </div>

        </div>
    </div>
</div>

<script>
    const nmMember = "<?= $_SESSION['nm_member']; ?>";
    const searchInput = document.getElementById('search-barang');
    const daftarBarangTable = document.getElementById('daftar-barang');
    const keranjangTable = document.getElementById('keranjang-barang');

    let keranjang = [];

    searchInput.addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            const keyword = searchInput.value.trim();
            if (!keyword) {
                alert('Masukkan kode atau nama barang!');
                return;
            }
            cariBarang(keyword);
        }
    });

    searchInput.addEventListener('input', function () {
        const keyword = searchInput.value.trim();
        if (keyword === '') {
            daftarBarangTable.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center text-muted">Cari barang dengan memasukkan kode atau nama barang.</td>
                </tr>`;
        }
    });

    function cariBarang(keyword) {
        fetch(`search-barang.php?keyword=${encodeURIComponent(keyword)}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    tampilkanBarang(data.data);
                } else {
                    daftarBarangTable.innerHTML = `
                        <tr>
                            <td colspan="5" class="text-center text-muted">Barang tidak ditemukan</td>
                        </tr>`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mencari barang.');
            });
    }

    function tampilkanBarang(barangList) {
        daftarBarangTable.innerHTML = '';

        barangList.forEach(barang => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${barang.id_barang}</td>
                <td>${barang.nama_barang}</td>
                <td>${barang.merk}</td>
                <td>Rp ${barang.harga_jual.toLocaleString()}</td>
                <td>
                    <button class="btn btn-primary btn-sm" onclick="tambahKeKeranjang('${barang.id_barang}', '${barang.nama_barang}', ${barang.harga_jual})">
                        <i class="fa fa-shopping-cart"></i>
                    </button>
                </td>`;
            daftarBarangTable.appendChild(row);
        });
    }

    function tambahKeKeranjang(id, nama, harga) {
        fetch(`check-stok.php?id_barang=${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'error') {
                    alert('Stok barang tidak mencukupi!');
                    return;
                }
                
                const stokTersedia = data.stok;
                const jumlahBarang = prompt(`Stok tersedia: ${stokTersedia}. Berapa jumlah yang ingin dibeli?`);
                
                if (jumlahBarang <= 0 || jumlahBarang > stokTersedia) {
                    alert('Jumlah yang dibeli tidak valid atau melebihi stok tersedia.');
                    return;
                }
                
                const barangIndex = keranjang.findIndex(item => item.id === id);
                if (barangIndex === -1) {
                    keranjang.push({ id, nama, harga, jumlah: parseInt(jumlahBarang) });
                } else {
                    keranjang[barangIndex].jumlah += parseInt(jumlahBarang);
                }
                
                updateKeranjangTable();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memeriksa stok.');
            });
    }

    function updateKeranjangTable() {
        keranjangTable.innerHTML = keranjang.length
            ? keranjang.map((barang, index) => `
                <tr>
                    <td>${index + 1}</td>
                    <td>${barang.nama}</td>
                    <td id="jumlah-${barang.id}">
                        <span class="jumlah-text">${barang.jumlah}</span>
                    </td>
                    <td>Rp ${(barang.harga * barang.jumlah).toLocaleString()}</td>
                    <td>${nmMember}</td>
                    <td>
                        <button class="btn btn-danger btn-sm" onclick="hapusDariKeranjang('${barang.id}')">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>`).join('')
            : `<tr><td colspan="6" class="text-center">Keranjang kosong</td></tr>`;

        const totalSemua = keranjang.reduce((total, item) => total + (item.harga * item.jumlah), 0);
        document.getElementById('total-semua').value = `Rp ${totalSemua.toLocaleString()}`;
    }

    document.getElementById('reset-keranjang').addEventListener('click', () => {
        keranjang = [];
        updateKeranjangTable();
        alert('Keranjang telah dikosongkan!');
    });

    function hapusDariKeranjang(id) {
        keranjang = keranjang.filter(item => item.id !== id);
        updateKeranjangTable();
    }

    document.getElementById('tanggal-sekarang').querySelector('strong').textContent = new Date().toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'long',
        year: 'numeric',
        weekday: 'long'
    });

    const bayarInput = document.getElementById('bayar');
    const kembaliInput = document.getElementById('kembali');
    const btnBayar = document.getElementById('btn-bayar');

    btnBayar.addEventListener('click', () => {
        const totalBelanja = parseInt(document.getElementById('total-semua').value.replace(/\D/g, ''), 10);
        const jumlahBayar = parseInt(bayarInput.value.replace(/\D/g, ''), 10);

        if (isNaN(jumlahBayar) || jumlahBayar <= 0) {
            alert('Harap masukkan nominal bayar yang valid.');
            return;
        }

        if (jumlahBayar < totalBelanja) {
            alert('Uang kurang. Harap masukkan nominal yang mencukupi.');
            return;
        }

        let kembalian = jumlahBayar - totalBelanja;

        if (kembalian === 0) {
            alert('Transaksi berhasil! Uang pas.');
            simpanKeDatabase(totalBelanja, jumlahBayar, 0); 
        } else {
            kembaliInput.value = `Rp ${kembalian.toLocaleString()}`;
            alert(`Transaksi berhasil! Kembalian: Rp ${kembalian.toLocaleString()}`);
            simpanKeDatabase(totalBelanja, jumlahBayar, kembalian);
        }
    });

    function simpanKeDatabase(total, bayar, kembalian) {
        fetch('simpan-transaksi.php', {
            method: 'POST',
            body: JSON.stringify({
                total: total,
                bayar: bayar,
                kembalian: kembalian,
                keranjang: keranjang, 
                tanggal: new Date().toISOString()
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Kamu bisa ganti dengan log di console atau update tampilan di halaman
                console.log('Transaksi berhasil disimpan!');
                
                // Misalnya, mengosongkan keranjang atau mengupdate UI lainnya
                // document.getElementById('keranjang').innerHTML = ''; 

                // Mengecek stok barang
                keranjang.forEach(item => {
                    fetch(`check-stok.php?id_barang=${item.id}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.stok === 0) {
                                console.log(`Stok barang ${item.nama} habis!`);
                            }
                        });
                });
            } else {
                console.log('Gagal menyimpan transaksi!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            console.log('Terjadi kesalahan saat menyimpan transaksi.');
        });
    }

    document.querySelector('.btn-secondary').addEventListener('click', function () {
        const printWindow = window.open('', '', 'height=500,width=800');

        const keranjangHtml = keranjang.map(item => `
            ${item.nama} - ${item.jumlah} x Rp ${(item.harga).toLocaleString()} = Rp ${(item.harga * item.jumlah).toLocaleString()}
        `).join('<br>');

        const total = document.getElementById('total-semua').value; 
        const bayar = bayarInput.value;  
        const kembalian = kembaliInput.value;  

        const formattedBayar = bayar ? `Rp ${parseInt(bayar.replace(/\D/g, ''), 10).toLocaleString()}` : 'Rp 0';
        const formattedKembalian = kembalian ? `Rp ${parseInt(kembalian.replace(/\D/g, ''), 10).toLocaleString()}` : 'Rp 0';

        printWindow.document.write(`
            <html>
                <head><title>Transaksi Print</title></head>
                <body style="font-family: 'Courier New', Courier, monospace; font-size: 14px; text-align: center; padding: 20px;">
                    <h2>STRUK PENJUALAN</h2>
                    <p><?php echo $nama_toko; ?> , <?php echo $alamat_toko; ?></p>
                    <p>No. Telp : <?php echo $tlp; ?></p>
                    <p><strong>Tanggal:</strong> ${new Date().toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: 'long',
                        year: 'numeric',
                        weekday: 'long'
                    })}</p>
                    <p><strong>Kasir:</strong> ${nmMember}</p>
                    <hr>
                    <p>${keranjangHtml}</p>
                    <hr>
                    <p><strong>Total:</strong> ${total}</p>
                    <p><strong>Bayar:</strong> ${formattedBayar}</p>
                    <p><strong>Kembalian:</strong> ${formattedKembalian}</p>
                    <hr>
                    <p>Terima kasih telah berbelanja!</p>
                </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.print();
    });

</script>
