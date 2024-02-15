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
    <h2 class="text-center">Selamat datang, berikut data Paket</h2>
    <div class="d-flex justify-content-end mb-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahDataModal"><i class="fa fa-plus"></i>
            Tambah Data
        </button>
    </div>
    <?php
    if (isset($_SESSION['simpanPaket'])) {
        echo '<div class="alert alert-success" role="alert">'
            . $_SESSION['simpanPaket'] .
            '</div>';
        unset($_SESSION['simpanPaket']);
    } elseif (isset($_SESSION['deletePaket'])) {
        echo '<div class="alert alert-danger" role="alert">'
            . $_SESSION['deletePaket'] .
            '</div>';
        unset($_SESSION['deletePaket']);
    } elseif (isset($_SESSION['editPaket'])) {
        echo '<div class="alert alert-warning" role="alert">'
            . $_SESSION['editPaket'] .
            '</div>';
        unset($_SESSION['editPaket']);
    }
    ?>

    <table class="table mt-4">
        <thead class="table-info">
            <tr>
                <th scope="col">No</th>
                <th scope="col">ID Paket</th>
                <th scope="col">Jenis Paket</th>
                <th scope="col">Nama paket</th>
                <th scope="col">Harga</th>
                <th scope="col">Nama Outlet</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $hasil = $koneksi->query("SELECT paket.*, outlet.nama_outlet FROM paket 
            JOIN outlet ON paket.outlet_id = outlet.id_outlet");

            while ($row = $hasil->fetch_assoc()) {
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['id_paket']; ?></td>
                    <td><?= $row['jenis_paket']; ?></td>
                    <td><?= $row['nama_paket']; ?></td>
                    <td><?= $row['harga']; ?></td>
                    <td><?= $row['nama_outlet']; ?></td>
                    <td>
                        <!-- Tombol Edit Data -->
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id_paket']; ?>"><i class="fa fa-pencil"></i>
                            Edit
                        </button>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal<?= $row['id_paket']; ?>" tabindex="-1" aria-labelledby="editModal<?= $row['id_paket']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel<?= $row['id_paket']; ?>">Edit Data</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Form edit data -->
                                        <form method="POST" action="koneksi.php">
                                            <input type="hidden" name="id_paket" value="<?= $row['id_paket']; ?>">
                                            <div class="mb-3">
                                                <label for="jenis_paket" class="form-label">Jenis Paket</label>
                                                <select name="jenis_paket[]" class="form-control" id="jenis_paket" required>
                                                    <option value="kiloan" <?= ($row['jenis_paket'] == 'kiloan') ? 'selected' : ''; ?>>Kiloan</option>
                                                    <option value="selimut" <?= ($row['jenis_paket'] == 'selimut') ? 'selected' : ''; ?>>Selimut</option>
                                                    <option value="bedcover" <?= ($row['jenis_paket'] == 'bedcover') ? 'selected' : ''; ?>>Bedcover</option>
                                                    <option value="kaos" <?= ($row['jenis_paket'] == 'kaos') ? 'selected' : ''; ?>>Kaos</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nama_paket" class="form-label">Nama Paket</label>
                                                <input type="text" name="nama_paket" class="form-control" id="nama_paket" value="<?= $row['nama_paket']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="harga" class="form-label">Harga</label>
                                                <input type="number" name="harga" class="form-control" id="harga" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="outlet_id" class="form-label">Nama Outlet</label>
                                                <select name="outlet_id" class="form-control" id="outlet_id" required>
                                                    <?php
                                                    // Ambil data outlet dari database
                                                    $hasil_outlet = $koneksi->query("SELECT * FROM outlet");

                                                    // Tampilkan opsi untuk setiap outlet
                                                    while ($row_outlet = $hasil_outlet->fetch_assoc()) {
                                                        $selected = ($row_outlet['id_outlet'] == $row['outlet_id']) ? 'selected' : '';
                                                        echo '<option value="' . $row_outlet['id_outlet'] . '" ' . $selected . '>' . $row_outlet['nama_outlet'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <button type="submit" name="edit_paket" class="btn btn-primary" value="edit">Edit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Hapus Data -->
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusModal<?= $row['id_paket']; ?>"><i class="fa fa-trash"></i>
                            Hapus
                        </button>

                        <!-- Modal Hapus -->
                        <div class="modal fade" id="hapusModal<?= $row['id_paket']; ?>" tabindex="-1" aria-labelledby="hapusModalLabel<?= $row['id_paket']; ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="hapusModalLabel<?= $row['id_paket']; ?>">Konfirmasi
                                            Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Anda yakin ingin menghapus data ini?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal
                                        </button>
                                        <a href="koneksi.php?id_paket=<?= $row['id_paket']; ?>" class="btn btn-danger">Hapus</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php
            }
            ?>
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
                        <label for="id_paket" class="form-label">ID Paket</label>
                        <input type="number" name="id_paket" class="form-control" id="id_paket" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_paket" class="form-label">Jenis Paket</label>
                        <select name="jenis_paket" class="form-control" id="jenis_paket" required>
                            <option value="kiloan" <?php echo (isset($row['jenis_paket']) && in_array('kiloan', $row['jenis_paket'])) ? 'selected' : ''; ?>>Kiloan</option>
                            <option value="selimut" <?php echo (isset($row['jenis_paket']) && in_array('selimut', $row['jenis_paket'])) ? 'selected' : ''; ?>>Selimut</option>
                            <option value="bedcover" <?php echo (isset($row['jenis_paket']) && in_array('bedcover', $row['jenis_paket'])) ? 'selected' : ''; ?>>Bedcover</option>
                            <option value="kaos" <?php echo (isset($row['jenis_paket']) && in_array('kaos', $row['jenis_paket'])) ? 'selected' : ''; ?>>Kaos</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nama_paket" class="form-label">Nama Paket</label>
                        <input type="text" name="nama_paket" class="form-control" id="nama_paket" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" name="harga" class="form-control" id="harga" required>
                    </div>
                    <div class="mb-3">
                        <label for="outlet_id" class="form-label">Nama Outlet</label>
                        <select name="outlet_id" class="form-control" id="outlet_id" required>
                            <?php
                            // Ambil data outlet dari database
                            $hasil_outlet = $koneksi->query("SELECT * FROM outlet");

                            // Tampilkan opsi untuk setiap outlet
                            while ($row_outlet = $hasil_outlet->fetch_assoc()) {
                                echo '<option value="' . $row_outlet['id_outlet'] . '">' . $row_outlet['nama_outlet'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" name="simpan_paket" class="btn btn-primary">Simpan</button>
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