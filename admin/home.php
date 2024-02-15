<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Jika pengguna belum login, arahkan ke halaman login.php
    header("Location: ../login.php");
    exit;
}

$_SESSION['berhasil'] = "Selamat Datang";
echo $_SESSION['berhasil'];

include 'koneksi.php';
include 'nav.php';
?>


  
  <!-- Main Content Area -->
  <div class="container mt-5 content-container">
    <h2 class="text-center">Selamat datang di Aplikasi Lumba, Laundry Mudah Bahagia</h2>
    <div class="d-flex justify-content-end mb-3">
    </div>
    <div class="container">
    <!-- <h2>Silahkan Lihat Data disini</h2> -->
    <!-- <table class="table ">
      <thead>
        <tr>
          <th>Gambar</th>
          <th>Nama</th>
          <th>Deskripsi</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><img src="assets/gambar1.jpg" class="img-thumbnail" alt="Gambar 1" width="100"></td>
          <td>Kopi ABC</td>
          <td>Deskripsi Gambar 1</td>
        </tr>
        <tr>
          <td><img src="assets/gambar2.jpg" class="img-thumbnail" alt="Gambar 2" width="100"></td>
          <td>Kopi Kapal Api</td>
          <td>Deskripsi Gambar 2</td>
        </tr> -->
        <!-- Tambahkan baris lain sesuai kebutuhan -->
      <!-- </tbody>
    </table>
  </div> -->

  

    
<!-- Menghubungkan dengan Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
