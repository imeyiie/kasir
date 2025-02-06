<?php include 'connection.php'; include 'sidebar.php'; ?>

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
        const barangIndex = keranjang.findIndex(item => item.id === id);

        if (barangIndex === -1) {
            keranjang.push({ id, nama, harga, jumlah: 1 });
        } else {
            keranjang[barangIndex].jumlah += 1;
        }

        updateKeranjangTable();
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
                        <button class="btn btn-warning btn-sm" onclick="editJumlah('${barang.id}')">
                            <i class="fa fa-edit"></i>  
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="hapusDariKeranjang('${barang.id}')">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>`).join('')
            : `<tr><td colspan="6" class="text-center">Keranjang kosong</td></tr>`;

        const totalSemua = keranjang.reduce((total, item) => total + (item.harga * item.jumlah), 0);
        document.getElementById('total-semua').value = `Rp ${totalSemua.toLocaleString()}`;
    }

    function editJumlah(id) {
        const barangIndex = keranjang.findIndex(item => item.id === id);
        
        if (barangIndex !== -1) {
            const jumlahCell = document.getElementById(`jumlah-${id}`);
            
            // Membuat input untuk mengedit jumlah
            const inputField = document.createElement('input');
            inputField.type = 'number';
            inputField.value = keranjang[barangIndex].jumlah;
            inputField.min = 1;
            inputField.className = 'form-control form-control-sm';
            
            // Tombol untuk menyimpan perubahan
            const saveButton = document.createElement('button');
            saveButton.className = 'btn btn-success btn-sm';
            saveButton.innerHTML = 'Simpan';
            saveButton.onclick = () => {
                keranjang[barangIndex].jumlah = parseInt(inputField.value, 10);
                updateKeranjangTable();  // Update tabel setelah perubahan
            };

            // Menyembunyikan jumlah dan menampilkan input untuk edit jumlah
            jumlahCell.innerHTML = '';
            jumlahCell.appendChild(inputField);
            jumlahCell.appendChild(saveButton);
        }
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
        const dataTransaksi = {
            keranjang: keranjang, 
            total: total,
            bayar: bayar,
            kembalian: kembalian,
            tanggal: new Date().toISOString().split('T')[0], 
        };

        fetch('simpan-transaksi.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(dataTransaksi),
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Data berhasil disimpan ke database!');
                bayarInput.value = '';
                kembaliInput.value = '';
            } else {
                alert('Gagal menyimpan data ke database: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan data ke database.');
        });
    }

    document.querySelector('.btn-secondary').addEventListener('click', function () {
        const printWindow = window.open('', '', 'height=500,width=800');

        const keranjangHtml = keranjang.map(item => `
            ${item.nama} - ${item.jumlah} x Rp ${(item.harga).toLocaleString()} = Rp ${(item.harga * item.jumlah).toLocaleString()}
            `).join('<br>');
            
            printWindow.document.write(`
                <html>
                    <head><title>Transaksi Print</title></head>
                    <body style="font-family: 'Courier New', Courier, monospace; font-size: 14px; text-align: center; padding: 20px;">
                        <h2>STRUK PENJUALAN</h2>
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
                        <p><strong>Total:</strong> Rp ${document.getElementById('total-semua').value}</p>
                        <p><strong>Bayar:</strong> Rp ${bayarInput.value}</p>
                        <p><strong>Kembalian:</strong> Rp ${kembaliInput.value}</p>
                        <hr>
                        <p>Terima kasih telah berbelanja!</p>
                    </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.print();
    });


</script>

<?php include 'footer.php'; ?>