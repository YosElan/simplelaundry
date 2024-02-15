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
    <h2 class="text-center">Selamat datang, berikut detail_transaksi</h2>
    <div class="d-flex justify-content-end mb-3">
        <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#tambahDataModal"><i class="fa fa-plus"></i>
            Buat Transaksi
        </button>
        <button type="button" class="btn btn-success" onClick="window.print()"><i class="fa fa-print"></i>
            Print
        </button>
    </div>
    <?php
    if (isset($_SESSION['simpanDetail'])) {
        echo '<div class="alert alert-success" role="alert">'
            . $_SESSION['simpanDetail'] .
            '</div>';
        unset($_SESSION['simpanDetail']);
    } elseif (isset($_SESSION['deleteDetail'])) {
        echo '<div class="alert alert-danger" role="alert">'
            . $_SESSION['deleteDetail'] .
            '</div>';
        unset($_SESSION['deleteDetail']);
    } elseif (isset($_SESSION['editDetail'])) {
        echo '<div class="alert alert-warning" role="alert">'
            . $_SESSION['editDetail'] .
            '</div>';
        unset($_SESSION['editDetail']);
    }
    ?>

    <table class="table mt-4">
        <thead class="table-info">
            <tr>
                <th scope="col">No</th>
                <th scope="col">ID Detail</th>
                <th scope="col">ID Transaksi</th>
                <th scope="col">Nama Paket</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Keterangan</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $hasil = $koneksi->query("SELECT detail_transaksi.*, paket.nama_paket 
    FROM detail_transaksi 
    JOIN paket ON detail_transaksi.paket_id = paket.id_paket");

            while ($row = $hasil->fetch_assoc()) {
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['id_detail']; ?></td>
                    <td><?= $row['transaksi_id']; ?></td>
                    <td><?= $row['nama_paket']; ?></td>
                    <td><?= $row['qty']; ?></td>
                    <td><?= $row['keterangan']; ?></td>
                    <td>
                        <!-- Tombol Edit Data -->
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id_detail']; ?>"><i class="fa fa-pencil"></i>
                            Edit
                        </button>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal<?= $row['id_detail']; ?>" tabindex="-1" aria-labelledby="editModal<?= $row['id_detail']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel<?= $row['id_detail']; ?>">Edit Data</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Form edit data -->
                                        <form method="POST" action="koneksi.php">
                                            <input type="hidden" name="id_detail" value="<?= $row['id_detail']; ?>">
                                            <div class="mb-3">
                                                <label for="transaksi_id" class="form-label">ID Transaksi</label>
                                                <select name="transaksi_id" class="form-control" id="transaksi_id" required>
                                                    <?php
                                                    $hasil_transaksi = $koneksi->query("SELECT * FROM transaksi");
                                                    while ($row_transaksi = $hasil_transaksi->fetch_assoc()) {
                                                        $selected = ($row_transaksi['id_transaksi'] == $row['transaksi_id']) ? 'selected' : '';
                                                        echo '<option value="' . $row_transaksi['id_transaksi'] . '" ' . $selected . '>' . $row_transaksi['id_transaksi'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="paket_id" class="form-label">Nama Paket</label>
                                                <select name="paket_id" class="form-control" id="paket_id" required>
                                                    <?php
                                                    $hasil_paket = $koneksi->query("SELECT * FROM paket");
                                                    while ($row_paket = $hasil_paket->fetch_assoc()) {
                                                        $selected = ($row_paket['id_paket'] == $row['paket_id']) ? 'selected' : '';
                                                        echo '<option value="' . $row_paket['id_paket'] . '" ' . $selected . '>' . $row_paket['nama_paket'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="qty" class="form-label">Jumlah</label>
                                                <input type="number" name="qty" class="form-control" id="qty" value="<?= $row['qty']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="keterangan" class="form-label">Keterangan</label>
                                                <textarea name="keterangan" class="form-control" id="keterangan" required><?= htmlspecialchars($row['keterangan']); ?></textarea>
                                            </div>
                                            <button type="submit" name="edit_detail" class="btn btn-primary" value="edit">Edit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Hapus Data -->
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusModal<?= $row['id_detail']; ?>"><i class="fa fa-trash"></i>
                            Hapus
                        </button>

                        <!-- Modal Hapus -->
                        <div class="modal fade" id="hapusModal<?= $row['id_detail']; ?>" tabindex="-1" aria-labelledby="hapusModalLabel<?= $row['id_detail']; ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="hapusModalLabel<?= $row['id_detail']; ?>">Konfirmasi
                                            Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Anda yakin ingin menghapus data ini?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal
                                        </button>
                                        <a href="koneksi.php?id_detail=<?= $row['id_detail']; ?>" class="btn btn-danger">Hapus</a>
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
                        <label for="id_detail" class="form-label">ID Detail Transaksi</label>
                        <input type="number" name="id_detail" class="form-control" id="id_detail" required>
                    </div>
                    <div class="mb-3">
                        <label for="transaksi_id" class="form-label">ID Transaksi</label>
                        <select name="transaksi_id" class="form-control" id="transaksi_id" required>
                            <?php
                            // Ambil data transaksi dari database
                            $hasil_transaksi = $koneksi->query("SELECT * FROM transaksi");

                            // Tampilkan opsi untuk setiap transaksi
                            while ($row_transaksi = $hasil_transaksi->fetch_assoc()) {
                                $selected = ($row_transaksi['id_transaksi'] == $row['transaksi_id']) ? 'selected' : '';
                                echo '<option value="' . $row_transaksi['id_transaksi'] . '" ' . $selected . '>' . $row_transaksi['id_transaksi'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="paket_id" class="form-label">Nama Paket</label>
                        <select name="paket_id" class="form-control" id="paket_id" required>
                            <?php
                            // Ambil data paket dari database
                            $hasil_paket = $koneksi->query("SELECT * FROM paket");

                            // Tampilkan opsi untuk setiap paket
                            while ($row_paket = $hasil_paket->fetch_assoc()) {
                                $selected = ($row_paket['id_paket'] == $row['paket_id']) ? 'selected' : '';
                                echo '<option value="' . $row_paket['id_paket'] . '" ' . $selected . '>' . $row_paket['nama_paket'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="qty" class="form-label">Jumlah</label>
                        <input type="number" name="qty" class="form-control" id="qty" required>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" id="keterangan" required></textarea>
                    </div>
                    <button type="submit" name="simpan_detail" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>