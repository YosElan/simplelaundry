<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  // Jika pengguna belum login, arahkan ke halaman login.php
  header("Location: ../login.php");
  exit;
}

include 'koneksi.php';
include 'nav.php';

?>



<!-- Main Content Area -->
<div class="container mt-5 content-container">
  <h2 class="text-center">Selamat datang, berikut data Outlet</h2>
  <div class="d-flex justify-content-end mb-3">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahDataModal"><i class="fa fa-plus"></i>
      Tambah Data
    </button>
  </div>
  <?php
  if (isset($_SESSION['simpan'])) {
    echo '<div class="alert alert-success" role="alert">'
      . $_SESSION['simpan'] .
      '</div>';
    unset($_SESSION['simpan']);
  } elseif (isset($_SESSION['delete'])) {
    echo '<div class="alert alert-danger" role="alert">'
      . $_SESSION['delete'] .
      '</div>';
    unset($_SESSION['delete']);
  } elseif (isset($_SESSION['edit'])) {
    echo '<div class="alert alert-warning" role="alert">'
      . $_SESSION['edit'] .
      '</div>';
    unset($_SESSION['edit']);
  }
  ?>

  <table class="table mt-4">
    <thead class="table-info">
      <tr>
        <th scope="col">No</th>
        <th scope="col">ID Outlet</th>
        <th scope="col">Nama Outlet</th>
        <th scope="col">Alamat Outlet</th>
        <th scope="col">Telepon</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      $hasil = $koneksi->query("SELECT * FROM outlet");
      while ($row = $hasil->fetch_assoc()) {
      ?>
        <tr>
          <td><?= $no++; ?></td>
          <td><?= $row['id_outlet']; ?></td>
          <td><?= $row['nama_outlet']; ?></td>
          <td><?= $row['alamat_outlet']; ?></td>
          <td><?= $row['telp_outlet']; ?></td>
          <td>
            <!-- Tombol Edit Data -->
            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id_outlet']; ?>"><i class="fa fa-pencil"></i>
              Edit
            </button>


            <!-- Modal Edit -->
            <div class="modal fade" id="editModal<?= $row['id_outlet']; ?>" tabindex="-1" aria-labelledby="editModal<?= $row['id_outlet']; ?>" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel<?= $row['id_outlet']; ?>">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <!-- Form edit data -->
                    <form method="POST" action="koneksi.php">
                      <input type="hidden" name="id_outlet" value="<?= $row['id_outlet']; ?>">
                      <div class="mb-3">
                        <label for="nama_outlet" class="form-label">Nama Outlet</label>
                        <input type="text" name="nama_outlet" class="form-control" id="nama_outlet" value="<?= $row['nama_outlet']; ?>" required>
                      </div>
                      <div class="mb-3">
                        <label for="alamat_outlet" class="form-label">Alamat Outlet</label>
                        <textarea name="alamat_outlet" class="form-control" id="alamat_outlet" required><?= $row['alamat_outlet']; ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label for="telp_outlet" class="form-label">Telepon</label>
                        <input type="number" name="telp_outlet" class="form-control" id="telp_outlet" value="<?= $row['telp_outlet']; ?>" required>
                      </div>
                      <button type="submit" name="edit_outlet" class="btn btn-primary" value="edit">Edit</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <!-- Tombol Hapus Data -->
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusModal<?= $row['id_outlet']; ?>"><i class="fa fa-trash"></i>
              Hapus
            </button>

            <!-- Modal Hapus -->
            <div class="modal fade" id="hapusModal<?= $row['id_outlet']; ?>" tabindex="-1" aria-labelledby="hapusModalLabel<?= $row['id_outlet']; ?>" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="hapusModalLabel<?= $row['id_outlet']; ?>">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <p>Anda yakin ingin menghapus data ini?</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="koneksi.php?id_outlet=<?= $row['id_outlet']; ?>" class="btn btn-danger">Hapus</a>
                  </div>
                </div>
              </div>
            </div>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Form tambah data -->
        <form method="POST" action="koneksi.php">
          <div class="mb-3">
            <label for="id_outlet" class="form-label">ID Outlet</label>
            <input type="number" name="id_outlet" class="form-control" id="id_outlet" required>
          </div>
          <div class="mb-3">
            <label for="nama_outlet" class="form-label">Nama Outlet</label>
            <input type="text" name="nama_outlet" class="form-control" id="nama_outlet" required>
          </div>
          <div class="mb-3">
            <label for="alamat_outlet" class="form-label">Alamat Outlet</label>
            <textarea name="alamat_outlet" class="form-control" id="alamat_outlet" required></textarea>
          </div>
          <div class="mb-3">
            <label for="telp_outlet" class="form-label">Telepon Outlet</label>
            <input type="number" name="telp_outlet" class="form-control" id="telp_outlet" required>
          </div>
          <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- <script src="../assets/js/bootstrap.bundle.js"></script>
  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/bootstrap.bundle.min.js.map"></script>
  <script src="../assets/js/bootstrap.esm.js"></script>
  <script src="../assets/js/bootstrap.esm.js.map"></script>
  <script src="../assets/js/bootstrap.esm.min.js"></script>
  <script src="../assets/js/bootstrap.esm.min.js.map"></script>
  <script src="../assets/js/bootstrap.js"></script>
  <script src="../assets/js/bootstrap.js.map"></script>
  <script src="../assets/js/bootstrap.min.js"></script>
  <script src="../assets/js/bootstrap.min.js.map"></script> -->
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/bootstrap.esm.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>