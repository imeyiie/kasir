<?php 
session_start(); date_default_timezone_set('Asia/Jakarta');
include "connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beauty Unnie</title>
    <link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            font-family: "Nunito", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #858796;
            text-align: left;
            background-color: #f2f2f2;
        }

        .navbar {
            width: calc(100% - 250px);
            left: 250px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            height: 60px;
        }

        .navbar .navbar-left {
            display: flex;
            align-items: center;
        }

        .navbar .navbar-left h5 {
            margin: 0;
            color: #6c757d;
        }

        .navbar .navbar-right {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar .nav-item.dropdown .nav-link {
            display: flex;
            align-items: center;
        }

        .navbar .nav-item.dropdown .text-gray-600 {
            font-size: 1rem;
            margin-right: 5px;
        }

        .navbar .nav-item.dropdown .fa-user-circle {
            font-size: 1.7rem;
            margin-right: 10px;
        }

        .arrow-icon {
            transition: transform 0.3s ease;
        }

        .collapse.show + .nav-link .arrow-icon {
            transform: rotate(180deg);
        }

        .main-content {
            display: flex;
            flex-grow: 1;
        }

        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            background-color: #b399d4;
            color: #fff;
            padding-top: 20px;
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            padding: 10px 25px;
            display: block;
            border-radius: 4px;
            font-weight: 500;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f2f2f2;
            padding-right: 54px;
        }

        footer.sticky-footer {
            position: fixed;
            bottom: 0;
            left: 250px; 
            width: calc(100% - 250px); 
            background-color: #f8f9fc;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1rem;
            color: #858796;
        }

        footer.sticky-footer .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .container {
            margin-left: 250px; 
            width: calc(100% - 250px);
            padding: 20px;
        }

        .custom-dashboard-cards {
            display: flex;
            gap: 20px;
            margin-top: 20px;
            justify-content: space-between;
            flex-wrap: wrap; 
        }

        .custom-card {
            width: 23%; 
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
        }

        .custom-card-header {
            background-color: #b399d4;
            color: white;
            font-size: 15px;
            padding: 12px;
        }

        .custom-card-body {
            padding: 25px;
            font-size: 28px;
            font-weight: bold;
            color: #b399d4;
        }

        .custom-card-footer {
            background-color: #f8f9fc;
            padding: 12px;
        }

        .custom-card-footer a {
            text-decoration: none;
            color: #b399d4;
            font-weight: bold;
            font-size: 16px;
        }

        .sale-card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .sale-card-body {
            padding: 20px;
        }

        .custom-input-search {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 8px;
        }

        .custom-border {
            border: 1px solid #f0f0f0;
        }

        .cart-table th {
            background-color: #f7f7f7;
        }

        .reset-cart-btn {
            background-color: #ff4d4d;
            color: white;
            border: none;
            border-radius: 5px;
        }

        .print-btn {
            background-color: #9E9E9E;
            color: white;
            border-radius: 5px;
        }

        .pay-btn {
            background-color: #28a745;
            color: white;
            border-radius: 5px;
        }

        .custom-input {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 8px;
        }

        .profile-img {
            width: 100%;
            height: auto;
            max-width: 200px;
        }

    </style>
</head>
<body>
       
    <?php if ($_SESSION['id_role'] == 1) { ?>
        <div class="sidebar d-flex flex-column">
            <div class="text-center mb-3">
                <img src="img/logo.png" alt="Logo" style="width: 180px;">
            </div>

            <hr class="sidebar-divider my-0">

            <a href="dashboard-administrator.php" class="nav-link active">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>

            <hr class="sidebar-divider">

            <div class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#masterDataMenu"
                    aria-expanded="false" aria-controls="masterDataMenu">
                    <i class="fas fa-database"></i>
                    <span>Data Master</span>
                </a>
                <div id="masterDataMenu" class="collapse">
                    <a class="collapse-item" href="master-barang.php">Barang</a>
                    <a class="collapse-item" href="master-kategori.php">Kategori</a>
                    <a class="collapse-item" href="master-petugas.php">Petugas</a>
                </div>
            </div>

            <div class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#transaksiMenu"
                    aria-expanded="false" aria-controls="transaksiMenu">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Transaksi</span>
                </a>
                <div id="transaksiMenu" class="collapse">
                    <a class="collapse-item" href="transaksi-jual.php">Transaksi Jual</a>
                    <a class="collapse-item" href="laporan-transaksi.php">Laporan Transaksi</a>
                </div>
            </div>

            <hr class="sidebar-divider">

            <div class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#karyawanMenu"
                    aria-expanded="false" aria-controls="karyawanMenu">
                    <i class="fas fa-users"></i>
                    <span>Karyawan</span>
                </a>
                <div id="karyawanMenu" class="collapse">
                    <a class="collapse-item" href="karyawan-resign.php">Karyawan Resign</a>
                    <a class="collapse-item" href="delete-data-karyawan.php">Delete Data Karyawan</a>
                </div>
            </div>

            <hr class="sidebar-divider d-none d-md-block">

            <a href="#" class="nav-link">
                <i class="fas fa-fw fa-cogs"></i>
                <span>Pengaturan Toko</span>
            </a>
        </div>
    <?php } ?>

    <?php if ($_SESSION['id_role'] == 2) { ?>
        <div class="sidebar d-flex flex-column">
            <div class="text-center mb-3">
                <img src="img/logo.png" alt="Logo" style="width: 180px;">
            </div>

            <hr class="sidebar-divider my-0">

            <a href="dashboard-petugas.php" class="nav-link active">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>

            <hr class="sidebar-divider">

            <div class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#masterDataMenu"
                    aria-expanded="false" aria-controls="masterDataMenu">
                    <i class="fas fa-database"></i>
                    <span>Data Master</span>
                </a>
                <div id="masterDataMenu" class="collapse">
                    <a class="collapse-item" href="master-barang.php">Barang</a>
                    <a class="collapse-item" href="master-kategori.php">Kategori</a>
                </div>
            </div>

            <div class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#transaksiMenu"
                    aria-expanded="false" aria-controls="transaksiMenu">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Transaksi</span>
                </a>
                <div id="transaksiMenu" class="collapse">
                    <a class="collapse-item" href="transaksi-jual.php">Transaksi Jual</a>
                    <a class="collapse-item" href="laporan-transaksi.php">Laporan Transaksi</a>
                </div>
            </div>

            <hr class="sidebar-divider d-none d-md-block">
        </div>
    <?php } ?>

    <div class="main-content">
         <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <?php
            $tampil = mysqli_query($conn, "SELECT * FROM `toko` WHERE 1");

            while ($toko = mysqli_fetch_array($tampil)):
            ?> 
            <h5 class="d-lg-block d-none mt-2"><b> <?= $toko['nama_toko']?>, <?= $toko['alamat_toko']?></b></h5>
            <?php endwhile; ?>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item d-sm-none">
                    <form class="form-inline mr-auto w-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </li>

                <div class="topbar-divider d-none d-sm-block"></div>

                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-circle"></i>
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small ml-2"><?= $_SESSION['nm_member']?></span>
                        <i class="fas fa-angle-down"></i>
                    </a>
                    
                    <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="userDropdown">
                        <?php if (isset($_SESSION['id_role']) && $_SESSION['id_role'] == 2 && isset($_SESSION['id_member']) && $_SESSION['id_member'] > 0) { ?>
                            <a class="dropdown-item" href="profile-petugas.php?id=<?php echo $_SESSION['id_member']; ?>">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <div class="dropdown-divider"></div>
                        <?php } ?>
                        <a class="dropdown-item" href="logout.php">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>

        <div class="content">

        <?php include 'footer.php'; ?>
