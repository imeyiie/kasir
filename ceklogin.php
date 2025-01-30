<?php
session_start();
include "connection.php";

if(isset($_POST['submit'])) {
    $username = $_POST['user'];
    $password = md5($_POST['pass']);

    $query = mysqli_query($conn, "SELECT * FROM `login`
    INNER JOIN member ON login.id_member = member.id_member
    WHERE user='$username' 
    and pass='$password'");
    
    $count = mysqli_num_rows($query);
    
    if ($count > 0) {
        $login = mysqli_fetch_array($query);

        $_SESSION['id_member'] = $login['id_member'];
        $_SESSION['user'] = $login['user'];
        $_SESSION['id_role'] = $login['id_role'];
        $_SESSION['nm_member'] = $login['nm_member'];
        $_SESSION['gambar'] = $login['gambar'];
        $_SESSION['status'] = 'login';

        if ($login['id_role'] == 1) {
            echo "<script>
                    alert('Login berhasil');
                    window.location.href='dashboard-administrator.php';
                  </script>";
        } elseif ($login['id_role'] == 2) {
            echo "<script>
                    alert('Login berhasil');
                    window.location.href='dashboard-petugas.php';
                  </script>";
        }
    } else {
        echo "<script>
              alert('Login gagal');
              window.location.href='login.php';
              </script>";
    }
}
?>
