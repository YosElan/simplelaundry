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
    <h2 class="text-center">Transaksi</h2>
    <div class="d-flex justify-content-end mb-3">
        <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#tambahDataModal"><i class="fa fa-plus"></i>
            Buat Transaksi
        </button>
        <button type="button" class="btn btn-success" onClick="window.print()"><i class="fa fa-print"></i>
            Print
        </button>
    </div>
    <?php
        if (isset($_SESSION['simpanTransaksi'])) {
            echo '<div class="alert alert-success" role="alert">'
                . $_SESSION['simpanTransaksi'] .
                '</div>';
            unset($_SESSION['simpanTransaksi']);
        } elseif (isset($_SESSION['deleteTransaksi'])) {
            echo '<div class="alert alert-danger" role="alert">'
                . $_SESSION['deleteTransaksi'] .
                '</div>';
            unset($_SESSION['deleteTransaksi']);
        } elseif (isset($_SESSION['editTransaksi'])) {
            echo '<div class="alert alert-warning" role="alert">'
                . $_SESSION['editTransaksi'] .
                '</div>';
            unset($_SESSION['editTransaksi']);
        }
        //  elseif (isset($_SESSION['deleteTransaksiError'])) {
        //     echo '<div class="alert alert-danger" role="alert">'
        //     . $_SESSION['deleteTransaksiError'] .
        //     '</div>';
        // }
        ?>

    <table class="table mt-4" id="tableData">
        <thead class="table-info">
            <tr>
                <th scope="col">No</th>
                <th scope="col">ID Transaksi</th>
                <th scope="col">Nama Outlet</th>
                <th scope="col">Kode Invoice</th>
                <th scope="col">Nama Member</th>
                <th scope="col">Tanggal</th>
                <!-- <th scope="col">Batas Waktu</th> -->
                <th scope="col">Tanggal Pembayaran</th>
                <!-- <th scope="col">Biaya Tambahan</th> -->
                <!-- <th scope="col">Diskon</th> -->
                <!-- <th scope="col">Pajak</th> -->
                <th scope="col">Status</th>
                <th scope="col">Status Bayar</th>
                <th scope="col">Nama Petugas</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $hasil = $koneksi->query("SELECT transaksi.*, outlet.nama_outlet, member.nama_member, users.nama_user 
                            FROM transaksi 
                            JOIN outlet ON transaksi.outlet_id = outlet.id_outlet
                            JOIN member ON transaksi.member_id = member.id_member
                            JOIN users ON transaksi.user_id = users.id_user");

            while ($row = $hasil->fetch_assoc()) {
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['id_transaksi']; ?></td>
                    <td><?= $row['nama_outlet']; ?></td>
                    <td><?= $row['kode_invoice']; ?></td>
                    <td><?= $row['nama_member']; ?></td>
                    <td><?= $row['tgl']; ?></td>
                    <td><?= $row['tgl_pembayaran']; ?></td>
                    <td><?= $row['status']; ?></td>
                    <td><?= $row['status_bayar']; ?></td>
                    <td><?= $row['nama_user']; ?></td>
                    <td>
                        <!-- Tombol Edit Data -->
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id_transaksi']; ?> "><i class="fa fa-pencil"></i>
                            Edit
                        </button>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal<?= $row['id_transaksi']; ?>" tabindex="-1" aria-labelledby="editModal<?= $row['id_transaksi']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel<?= $row['id_transaksi']; ?>">Edit Transaksi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Form edit data -->
                                        <form method="POST" action="koneksi.php">
                                            <input type="hidden" name="id_transaksi" value="<?= $row['id_transaksi']; ?>">
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
                                            <div class="mb-3">
                                                <label for="kode_invoice" class="form-label">Kode_Invoice</label>
                                                <input type="text" name="kode_invoice" class="form-control" id="kode_invoice" value="<?= $row['kode_invoice']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="member_id" class="form-label">Nama Member</label>
                                                <select name="member_id" class="form-control" id="member_id" required>
                                                    <?php
                                                    // Ambil data outlet dari database
                                                    $hasil_member = $koneksi->query("SELECT * FROM member");

                                                    // Tampilkan opsi untuk setiap outlet
                                                    while ($row_member = $hasil_member->fetch_assoc()) {
                                                        $selected = ($row_member['id_member'] == $row['member_id']) ? 'selected' : '';
                                                        echo '<option value="' . $row_member['id_member'] . '" ' . $selected . '>' . $row_member['nama_member'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tgl" class="form-label">Tanggal</label>
                                                <input type="date" name="tgl" class="form-control" id="tgl" value="<?= $row['tgl']; ?>" required>
                                                <?php echo "Tanggal Sebelumnya: " . $row['tgl']; ?>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="tgl_pembayaran" class="form-label">Tanggal Pembayaran</label>
                                                <input type="date" name="tgl_pembayaran" class="form-control" id="tgl_pembayaran" value="<?= $row['tgl_pembayaran']; ?>" required>
                                                <?php echo "Tanggal Sebelumnya: " . $row['tgl_pembayaran']; ?>
                                            </div>
                                            
                                            
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <select name="status[]" class="form-control" id="status" required>
                                                    <option value="baru" <?= ($row['status'] == 'baru') ? 'selected' : ''; ?>>Baru</option>
                                                    <option value="proses" <?= ($row['status'] == 'proses') ? 'selected' : ''; ?>>Proses</option>
                                                    <option value="selesai" <?= ($row['status'] == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                                                    <option value="diambil" <?= ($row['status'] == 'diambil') ? 'selected' : ''; ?>>Diambil</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="status_bayar" class="form-label">Status_bayar</label>
                                                <select name="status_bayar[]" class="form-control" id="status_bayar" required>
                                                    <option value="dibayar" <?= ($row['status_bayar'] == 'dibayar') ? 'selected' : ''; ?>>dibayar</option>
                                                    <option value="belum" <?= ($row['status_bayar'] == 'belum') ? 'selected' : ''; ?>>belum</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="user_id" class="form-label">Nama Petugas</label>
                                                <select name="user_id" class="form-control" id="user_id" required>
                                                    <?php
                                                    // Ambil data outlet dari database
                                                    $hasil_user = $koneksi->query("SELECT * FROM users");

                                                    // Tampilkan opsi untuk setiap outlet
                                                    while ($row_user = $hasil_user->fetch_assoc()) {
                                                        $selected = ($row_user['id_user'] == $row['user_id']) ? 'selected' : '';
                                                        echo '<option value="' . $row_user['id_user'] . '" ' . $selected . '>' . $row_user['nama_user'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <button type="submit" name="edit_transaksi" class="btn btn-primary" value="edit">Edit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br />
                        <!-- Tombol Hapus Data -->
                        <button type="button" class="btn btn-danger btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#hapusModal<?= $row['id_transaksi']; ?>"><i class="fa fa-trash"></i>
                            Hapus
                        </button>

                        <!-- Modal Hapus -->
                        <div class="modal fade" id="hapusModal<?= $row['id_transaksi']; ?>" tabindex="-1" aria-labelledby="hapusModalLabel<?= $row['id_transaksi']; ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="hapusModalLabel<?= $row['id_transaksi']; ?>">Konfirmasi
                                            Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Anda yakin ingin menghapus data ini?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal
                                        </button>
                                        <a href="koneksi.php?id_transaksi=<?= $row['id_transaksi']; ?>" class="btn btn-danger">Hapus</a>
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
                <h5 class="modal-title" id="tambahDataModalLabel">Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form tambah data -->
                <form method="POST" action="koneksi.php">
                    <div class="mb-3">
                        <label for="id_transaksi" class="form-label">ID Transaksi</label>
                        <input type="number" name="id_transaksi" class="form-control" id="id_transaksi" required>
                    </div>
                    <div class="mb-3">
                        <label for="outlet_id" class="form-label">Nama Outlet</label>
                        <select name="outlet_id" class="form-control" id="outlet_id" required>
                            <?php
                            $hasil_outlet = $koneksi->query("SELECT * FROM outlet");
                            while ($row_outlet = $hasil_outlet->fetch_assoc()) {
                                $selected = ($row_outlet['id_outlet'] == $row['outlet_id']) ? 'selected' : '';
                                echo '<option value="' . $row_outlet['id_outlet'] . '" ' . $selected . '>' . $row_outlet['nama_outlet'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kode_invoice" class="form-label">Kode_Invoice</label>
                        <input type="text" name="kode_invoice" class="form-control" id="kode_invoice" value="DRY" required>
                    </div>
                    <div class="mb-3">
                        <label for="member_id" class="form-label">Nama Member</label>
                        <select name="member_id" class="form-control" id="member_id" required>
                            <?php
                            // Ambil data outlet dari database
                            $hasil_member = $koneksi->query("SELECT * FROM member");

                            // Tampilkan opsi untuk setiap outlet
                            while ($row_member = $hasil_member->fetch_assoc()) {
                                $selected = ($row_member['id_member'] == $row['member_id']) ? 'selected' : '';
                                echo '<option value="' . $row_member['id_member'] . '" ' . $selected . '>' . $row_member['nama_member'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tgl" class="form-label">Tanggal</label>
                        <input type="date" name="tgl" class="form-control" id="tgl" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="tgl_pembayaran" class="form-label">Tanggal Pembayaran</label>
                        <input type="date" name="tgl_pembayaran" class="form-control" id="tgl_pembayaran" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status[]" class="form-control" id="status" required>
                            <option value="baru" <?= ($row['status'] ?? 'baru') == 'baru' ? 'selected' : ''; ?>>Baru</option>
                            <option value="proses" <?= ($row['status'] ?? 'proses') == 'proses' ? 'selected' : ''; ?>>Proses</option>
                            <option value="selesai" <?= ($row['status'] ?? 'selesai') == 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                            <option value="diambil" <?= ($row['status'] ?? 'diambil') == 'diambil' ? 'selected' : ''; ?>>Diambil</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status_bayar" class="form-label">Status_bayar</label>
                        <select name="status_bayar[]" class="form-control" id="status_bayar" required>
                            <option value="dibayar" <?php echo (isset($row['status_bayar']) && $row['status_bayar'] == 'dibayar') ? 'selected' : ''; ?>>dibayar</option>
                            <option value="belum" <?php echo (isset($row['status_bayar']) && $row['status_bayar'] == 'belum') ? 'selected' : ''; ?>>belum</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Nama Petugas</label>
                        <select name="user_id" class="form-control" id="user_id" required>
                            <?php
                            // Ambil data outlet dari database
                            $hasil_user = $koneksi->query("SELECT * FROM users");

                            // Tampilkan opsi untuk setiap outlet
                            while ($row_user = $hasil_user->fetch_assoc()) {
                                $selected = ($row_user['id_user'] == $row['user_id']) ? 'selected' : '';
                                echo '<option value="' . $row_user['id_user'] . '" ' . $selected . '>' . $row_user['nama_user'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" name="simpan_transaksi" class="btn btn-primary">Simpan</button>
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