<?php
session_start();
include 'koneksi.php'; // Menghubungkan ke file koneksi.php

// Cek apakah pengguna telah mengirimkan formulir login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data yang dikirimkan melalui formulir
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk memeriksa kecocokan data login dalam tabel users
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query); 

    if ($result && mysqli_num_rows($result) === 1) {
        // Ambil data pengguna
        $row = mysqli_fetch_assoc($result);

        // Verifikasi password
        if (password_verify($password, $row['password'])) {
            // Jika password cocok, arahkan ke halaman sesuai peran (role) pengguna
            $_SESSION['logged_in'] = true;
            if ($row['role'] === 'admin') {
                header("Location: admin/home.php");
            } elseif ($row['role'] === 'kasir') {
                header("Location: kasir/home.php");
            } elseif ($row['role'] === 'owner') {
                header("Location: owner/home.php");
            } else {
                // Role not recognized, handle accordingly
                header("Location: home.php");
            }
            exit;
        } else {
            // Jika password tidak cocok, tampilkan pesan error
            $error_message = "Username atau password salah!";
        }
        
    } else {
        // Jika data login tidak cocok, tampilkan pesan error
        $error_message = "Username atau password salah!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/login/login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="box">
    <span class="borderline"></span>
    <form method="POST" action="">
        <h2><strong>Login</strong></h2>
        <?php if (isset($error_message)) { ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php } ?>
        <div class="inputBox">
            <input type="text" name="username" required="required">
            <span>Username</span>
            <i></i>
        </div>
        <div class="inputBox">
            <input type="password" name="password" required="required">
            <span>Password</span>
            <i></i>
        </div>
        <div class="links">
            <a href="#">Forgot password</a>
            <a href="#">Signup</a>
        </div>
        <input type="submit" value="Login">
    </form>
  </div>
</body>
</html>