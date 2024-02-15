<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Jika pengguna belum login, arahkan ke halaman login.php
    header("Location: login.php");
    exit;
}

include 'koneksi.php';
include 'nav.php';
?>


  
  <!-- Main Content Area -->
  <div class="container mt-5 content-container">
    <h2 class="text-center">Selamat datang di Aplikasi Lumba, Laundry Mudah Bahagia</h2>
    <div class="d-flex justify-content-end mb-3">
    </div>
    <div class="container">
    <h2>Silahkan Lihat Data disini </h2>
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

  <!-- Modal Admin Alert -->
  <div class="modal fade" id="adminModal" tabindex="-1" role="dialog" aria-labelledby="adminModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="adminModalLabel">Hanya Admin yang Dapat Masuk</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Anda harus memiliki hak akses sebagai admin untuk dapat mengakses halaman ini.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

    
<!-- Menghubungkan dengan Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
