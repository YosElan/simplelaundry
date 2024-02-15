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

<div class="container mt-5 content-container">
    <h2 class="text-center">Selamat datang, berikut data Member</h2>
    <div class="d-flex justify-content-end mb-3">
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahDataModal"><i class="fa fa-plus"></i>
        Tambah Data
      </button>
    </div>
    <?php
  if (isset($_SESSION['simpanMember'])) {
    echo '<div class="alert alert-success" role="alert">'
      . $_SESSION['simpanMember'] .
      '</div>';
    unset($_SESSION['simpanMember']);
  } elseif (isset($_SESSION['deleteMember'])) {
    echo '<div class="alert alert-danger" role="alert">'
      . $_SESSION['deleteMember'] .
      '</div>';
    unset($_SESSION['deleteMember']);
  } elseif (isset($_SESSION['editMember'])) {
    echo '<div class="alert alert-warning" role="alert">'
      . $_SESSION['editMember'] .
      '</div>';
    unset($_SESSION['editMember']);
  }
  ?>
    

    <table class="table mt-4">
      <thead class="table-info">
        <tr>
          <th scope="col">No</th>
          <th scope="col">ID Member</th>
          <th scope="col">Nama Member</th>
          <th scope="col">Alamat Member</th>
          <th scope="col">Jenis Kelamin</th>
          <th scope="col">Telepon</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        $hasil = $koneksi->query("SELECT * FROM member");
        while ($row = $hasil->fetch_assoc()) {
        ?>
        <tr>
          <td><?= $no++; ?></td>
          <td><?= $row['id_member']; ?></td>
          <td><?= $row['nama_member']; ?></td>
          <td><?= $row['alamat_member']; ?></td>
          <td><?= $row['jenis_kelamin']; ?></td>
          <td><?= $row['telp_member']; ?></td>
          <td>
            <!-- Tombol Edit Data -->
            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
              data-bs-target="#editModal<?= $row['id_member']; ?>"><i class="fa fa-pencil"></i>
              Edit
            </button>

            <!-- Modal Edit -->
            <div class="modal fade" id="editModal<?= $row['id_member']; ?>" tabindex="-1" aria-labelledby="editModal<?= $row['id_member']; ?>" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel<?= $row['id_member']; ?>">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <!-- Form edit data -->
                    <form method="POST" action="koneksi.php">
                      <input type="hidden" name="id_member" value="<?= $row['id_member']; ?>">
                      <div class="mb-3">
                        <label for="nama_member" class="form-label">Nama Member</label>
                        <input type="text" name="nama_member" class="form-control" id="nama_member" value="<?= $row['nama_member']; ?>" required>
                      </div>
                      <div class="mb-3">
                          <label for="alamat_member" class="form-label">Alamat member</label>
                          <textarea name="alamat_member" class="form-control" id="alamat_member" required><?= $row['alamat_member']; ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control" id="jenis_kelamin" required>
                            <option value="L" <?php echo (isset($row['jenis_kelamin']) && $row['jenis_kelamin'] == 'L') ? 'selected' : ''; ?>>L</option>
                            <option value="P" <?php echo (isset($row['jenis_kelamin']) && $row['jenis_kelamin'] == 'P') ? 'selected' : ''; ?>>P</option>
                        </select>
                    </div>
                      <div class="mb-3">
                        <label for="telp_member" class="form-label">Telepon</label>
                        <input type="number" name="telp_member" class="form-control" id="telp_member" value="<?= $row['telp_member']; ?>" required>
                      </div>
                      <button type="submit" name="edit_member" class="btn btn-primary" value="edit">Edit</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <!-- Tombol Hapus Data -->
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
              data-bs-target="#hapusModal<?= $row['id_member']; ?>"><i class="fa fa-trash"></i>
              Hapus
            </button>

            <!-- Modal Hapus -->
            <div class="modal fade" id="hapusModal<?= $row['id_member']; ?>" tabindex="-1" aria-labelledby="hapusModalLabel<?= $row['id_member']; ?>" aria-hidden="true">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="hapusModalLabel<?= $row['id_member']; ?>">Konfirmasi Hapus</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                          <p>Anda yakin ingin menghapus data ini?</p>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                          <a href="koneksi.php?id_member=<?= $row['id_member']; ?>" class="btn btn-danger">Hapus</a>
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
  <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel"
    aria-hidden="true">
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
              <label for="id_member" class="form-label">ID Member</label>
              <input type="number" name="id_member" class="form-control" id="id_member" required>
            </div>
            <div class="mb-3">
              <label for="nama_member" class="form-label">Nama Member</label>
              <input type="text" name="nama_member" class="form-control" id="nama_member" required>
            </div>
            <div class="mb-3">
              <label for="alamat_member" class="form-label">Alamat Member</label>
              <textarea name="alamat_member" class="form-control" id="alamat_member" required></textarea>
            </div>
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control" id="jenis_kelamin" required>
                    <option value="L" <?php echo (isset($row['jenis_kelamin']) && $row['jenis_kelamin'] == 'L') ? 'selected' : ''; ?>>L</option>
                    <option value="P" <?php echo (isset($row['jenis_kelamin']) && $row['jenis_kelamin'] == 'P') ? 'selected' : ''; ?>>P</option>
                </select>
            </div>
            <div class="mb-3">
              <label for="telp_member" class="form-label">Telepon Member</label>
              <input type="number" name="telp_member" class="form-control" id="telp_member" required>
            </div>
            <button type="submit" name="simpan_member" class="btn btn-primary">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>