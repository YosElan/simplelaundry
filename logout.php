<?php
session_start();

// Menghapus semua data session
session_destroy();

// Mengarahkan pengguna ke halaman login atau halaman lain yang sesuai
header("Location: login.php");
exit;
?>
