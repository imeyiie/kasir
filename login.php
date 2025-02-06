<?php
    include "connection.php";
    session_start();
    if(isset($_SESSION['status']) && $_SESSION['status']=="login"){
    echo"<script>window.location.href='dashboard-administrator.php'</script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Beauty Unnie</title>
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="img/logo.png" alt="Beauty Unnie Logo" style="max-width: 150px; height: auto;">
            </a>
        </div>
    </nav>

    <div class="login-container">
        <div class="login-card">
            <div class="brand-icon">
                <img src="img/logo.png" alt="Beauty Unnie Logo" class="logo-inside">
            </div>
            <h1>Welcome to Beauty Unnie</h1>
            <p>Please log in to continue</p>
            <form method="POST" action="ceklogin.php">
                <div class="mb-3 icon-input-group">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" placeholder="Enter Username" name="user" required>
                    </div>
                </div>
                <div class="mb-3 icon-input-group">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" placeholder="Enter Password" name="pass" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-login w-100" name="submit">Login</button>
            </form>
        </div>
    </div>

    <footer>
        &copy; 2025 Beauty Unnie. All Rights Reserved.
    </footer>   

    <script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
