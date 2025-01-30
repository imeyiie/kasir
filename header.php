<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header - Beauty Unnie</title>
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            height: 100vh;
            margin: 0;
        }

        .navbar {
            background-color: #b399d4;
            padding-top: 1px; /* Ukuran lebih kecil */
            padding-bottom: 3px; /* Ukuran lebih kecil */
        }

        .navbar-brand img {
            margin-left: -100px; 
            max-width: 130px;
            height: auto;
        }

        .navbar a, .navbar .navbar-brand {
            color: white !important;
        }

        .brand-icon img {
            display: block;
            margin-left: auto;
            margin-right: auto;
            max-width: 178px; 
            height: auto;
            margin-bottom: 1.5rem; 
        }
        
        .main-content {
            display: flex;
            flex-grow: 1;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            background-color: #e8d7f9;
            color: white;
            padding-top: 15px;
            padding-bottom: 15px;
        }

        .sidebar h5 {
            text-align: center;
            margin-bottom: 15px;
            color: white;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            margin-bottom: 5px; 
        }

        .sidebar ul li a {
            font-size: 16px;
            font-weight: 500;
            color: white;
            text-decoration: none;
            display: block;
            padding: 5px 15px;
            border-radius: 5px;
        }

        .sidebar ul li a:hover {
            background-color: #d8b4f3;
            color: white;
        }

        .dropdown-menu {
            background-color: #e8d7f9;
            padding: 5px 0;
        }

        .dropdown-menu a {
            color: #6f42c1;
            padding: 8px 15px;
        }

        .dropdown-menu a:hover {
            background-color: #d8b4f3;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="img/logoo.png" alt="Beauty Unnie Logo" style="max-width: 150px; height: auto;">
            </a>
        </div>
    </nav>

    <div class="main-content">
        <div class="sidebar">
            <ul>
                <li>
                    <a href="#"><i class="fas fa-tachometer-alt me-2"></i> Dashboard </a>
                </li>
                <li>
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#masterMenu" aria-expanded="false" aria-controls="masterMenu">
                        <i class="fas fa-database me-2"></i> Master <i class="fas fa-caret-down float-end"></i>
                    </a>
                    <div class="collapse" id="masterMenu">
                        <ul class="list-unstyled ps-3">
                            <li><a href="master-user.php" class="d-block"><i class="fas fa-user me-2"></i> Data User</a></li>
                            <li><a href="master-barang.php" class="d-block"><i class="fas fa-box me-2"></i> Data Produk</a></li>
                            <li><a href="#" class="d-block"><i class="fas fa-users me-2"></i> Data Pelanggan</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#"><i class="fas fa-cash-register me-2"></i> Transaksi</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-chart-bar me-2"></i> Laporan</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-cog me-2"></i> Pengaturan</a>
                </li>
                <li>
                    <a href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Keluar</a>
                </li>
            </ul>
        </div>

        <div class="content">
          
            <script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
            <script>
                document.addEventListener('click', function (event) {
                    const dropdown = document.querySelector('#masterMenu');
                    const toggleButton = document.querySelector('[data-bs-toggle="collapse"]');

                    if (!dropdown.contains(event.target) && !toggleButton.contains(event.target)) {
                        const collapseElement = new bootstrap.Collapse(dropdown, {
                            toggle: false
                        });
                        collapseElement.hide();
                    }
                });
            </script>
</body>
</html>
