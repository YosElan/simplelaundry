<?php

$koneksi = new mysqli('localhost', 'root', '', 'laundry') or die(mysqli_error($koneksi));


if (isset($_POST['simpan'])) {
    $id_outlet = isset($_POST['id_outlet']) ? $_POST['id_outlet'] : "";
    $nama_outlet = $_POST['nama_outlet'];
    $alamat_outlet = $_POST['alamat_outlet'];
    $telp_outlet = $_POST['telp_outlet'];
    $koneksi->query("INSERT INTO outlet (id_outlet, nama_outlet, alamat_outlet, telp_outlet) VALUES ('$id_outlet', '$nama_outlet', '$alamat_outlet', '$telp_outlet')");

    session_start();
    $_SESSION["simpan"] = "Data berhasil dismpan";
    header("location:data.php");
}

if (isset($_GET['id_outlet'])) {
    $id = $_GET['id_outlet'];
    $koneksi->query("DELETE FROM outlet WHERE id_outlet = '$id'");

    session_start();
    $_SESSION["delete"] = "Data berhasil dihapus";
    header("location:data.php");
}

if (isset($_POST['edit_outlet'])) {
    $id_outlet = isset($_POST['id_outlet']) ? $_POST['id_outlet'] : "";
    $nama_outlet = $_POST['nama_outlet'];
    $alamat_outlet = $_POST['alamat_outlet'];
    $telp_outlet = $_POST['telp_outlet'];
    $koneksi->query("UPDATE outlet SET nama_outlet='$nama_outlet', alamat_outlet='$alamat_outlet', telp_outlet='$telp_outlet' WHERE id_outlet='$id_outlet'");

    session_start();
    $_SESSION["edit"] = "Data berhasil Edit";
    header("location:data.php");
}

  //===============================================================================//

  if (isset($_POST['simpan_member'])) {
    $id_member = isset($_POST['id_member']) ? $_POST['id_member'] : "";
    $nama_member = $_POST['nama_member'];
    $alamat_member = $_POST['alamat_member'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $telp_member = $_POST['telp_member'];
    $koneksi->query("INSERT INTO member (id_member, nama_member, alamat_member, jenis_kelamin, telp_member) VALUES ('$id_member', '$nama_member', '$alamat_member', '$jenis_kelamin', '$telp_member')");

    session_start();
    $_SESSION["simpanMember"] = "Data berhasil Ditambahkan";
    header("location:member.php");
}
if (isset($_POST['edit_member'])) {
    $id_member = isset($_POST['id_member']) ? $_POST['id_member'] : "";
    $nama_member = $_POST['nama_member'];
    $alamat_member = $_POST['alamat_member'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $telp_member = $_POST['telp_member'];

    $koneksi->query("UPDATE member SET nama_member='$nama_member', alamat_member='$alamat_member', jenis_kelamin='$jenis_kelamin', telp_member='$telp_member' WHERE id_member='$id_member'");

    session_start();
    $_SESSION["editMember"] = "Data berhasil Di Edit";
    header("location: member.php");
}
if (isset($_GET['id_member'])) {
    $id_member = $_GET['id_member'];
    $koneksi->query("DELETE FROM member WHERE id_member = '$id_member'");

    session_start();
    $_SESSION["deleteMember"] = "Data berhasil dihapus";
    header("location: member.php");
}

//===============================================================================//

if (isset($_POST['simpan_paket'])) {
    $id_paket = isset($_POST['id_paket']) ? $_POST['id_paket'] : "";
    $jenis_paket = $_POST['jenis_paket'];
    $nama_paket = $_POST['nama_paket'];
    $harga = $_POST['harga'];
    $outlet_id = $_POST['outlet_id'];  
    $koneksi->query("INSERT INTO paket (id_paket, jenis_paket, nama_paket, harga, outlet_id) VALUES ('$id_paket', '$jenis_paket', '$nama_paket', '$harga', '$outlet_id')");

    session_start();
    $_SESSION["simpanPaket"] = "Data berhasil dismpan";
    header("location:paket.php");
}

if (isset($_POST['edit_paket'])) {
    $id_paket = isset($_POST['id_paket']) ? $_POST['id_paket'] : "";
    $jenis_paket = implode(",", $_POST['jenis_paket']);
    $nama_paket = $_POST['nama_paket'];
    $harga = $_POST['harga'];
    $outlet_id = $_POST['outlet_id']; 

    session_start();
    $koneksi->query("UPDATE paket SET jenis_paket='$jenis_paket', nama_paket='$nama_paket', harga='$harga', outlet_id='$outlet_id' WHERE id_paket='$id_paket'");
    $_SESSION["editPaket"] = "Data berhasil di edit";
    header("location: paket.php");
}

if (isset($_GET['id_paket'])) {
    $id_paket = $_GET['id_paket'];
    $koneksi->query("DELETE FROM paket WHERE id_paket = '$id_paket'");

    session_start();
    $_SESSION["deletePaket"] = "Data berhasil di hapus";
    header("location: paket.php");
}

//=====================================================================================================================//
if (isset($_POST['simpan_transaksi'])) {
    $id_transaksi = isset($_POST['id_transaksi']) ? $_POST['id_transaksi'] : "";
    $outlet_id = $_POST['outlet_id'];
    $kode_invoice = $_POST['kode_invoice'];
    $member_id = $_POST['member_id'];
    $tgl = $_POST['tgl'];
    // $batas_waktu = $_POST['batas_waktu'];
    $tgl_pembayaran = $_POST['tgl_pembayaran'];
    // $biaya_tambahan = $_POST['biaya_tambahan'];
    // $diskon = $_POST['diskon'];
    // $pajak = $_POST['pajak'];
    $status = isset($_POST['status']) ? $_POST['status'][0] : "";
    $status_bayar = isset($_POST['status_bayar']) ? $_POST['status_bayar'][0] : "";
    $user_id = $_POST['user_id'];
    
    $koneksi->query("INSERT INTO transaksi (id_transaksi, outlet_id, kode_invoice, member_id, tgl, tgl_pembayaran, status, status_bayar, user_id) 
                    VALUES ('$id_transaksi', '$outlet_id', '$kode_invoice', '$member_id', '$tgl', '$tgl_pembayaran', '$status', '$status_bayar', '$user_id')");

session_start();
$_SESSION["simpanTransaksi"] = "Data berhasil dismpan";
    header("location:transaksi.php");
}


if (isset($_POST['edit_transaksi'])) {
    $id_transaksi = isset($_POST['id_transaksi']) ? $_POST['id_transaksi'] : "";
    $outlet_id = $_POST['outlet_id'];
    $kode_invoice = $_POST['kode_invoice'];
    $member_id = $_POST['member_id'];
    $tgl = $_POST['tgl'];
    // $batas_waktu = $_POST['batas_waktu'];
    $tgl_pembayaran = isset($_POST['tgl_pembayaran']) ? $_POST['tgl_pembayaran'] : null;
    // $biaya_tambahan = $_POST['biaya_tambahan'];
    // $diskon = $_POST['diskon'];
    // $pajak = $_POST['pajak'];

    // Process 'status' as an array
    $statusArray = isset($_POST['status']) ? $_POST['status'] : [];
    $status = implode(',', array_map('mysqli_real_escape_string', array_fill(0, count($statusArray), $koneksi), $statusArray));

    $status_bayarArray = isset($_POST['status_bayar']) ? $_POST['status_bayar'] : [];
    $status_bayar = implode(',', array_map('mysqli_real_escape_string', array_fill(0, count($status_bayarArray), $koneksi), $status_bayarArray));

    $user_id = $_POST['user_id'];

    // Handle the case when 'tgl_pembayaran' is not set in the $_POST array
    // Convert null to an appropriate value based on your database field type
    if ($tgl_pembayaran === null) {
        $tgl_pembayaran = 'NULL'; // or you can set it to a default date, e.g., '1970-01-01'
    } else {
        $tgl_pembayaran = "'$tgl_pembayaran'";
    }

    // Sesuaikan query UPDATE dengan struktur tabel 'transaksi'
    $koneksi->query("UPDATE transaksi SET outlet_id='$outlet_id', kode_invoice='$kode_invoice', 
                    member_id='$member_id', tgl='$tgl', 
                    tgl_pembayaran=$tgl_pembayaran, status='$status', status_bayar='$status_bayar', user_id='$user_id' 
                    WHERE id_transaksi='$id_transaksi'");

    session_start();
    $_SESSION["editTransaksi"] = "Data berhasil di edit";
    header("location: transaksi.php");
}


if (isset($_GET['id_transaksi'])) {
    $id_transaksi = $_GET['id_transaksi'];
    $koneksi->query("DELETE FROM transaksi WHERE id_transaksi = '$id_transaksi'");

    session_start();
    $_SESSION["deleteTransaksi"] = "Data berhasil di hapus";
    header("location: transaksi.php");
}

// if (isset($_GET['id_transaksi'])) {
//     $id_transaksi = $_GET['id_transaksi'];

//     // Check if ID transaksi is used in another table (replace 'other_table' with the actual table name)
//     $other_table_query = "SELECT * FROM other_table WHERE id_transaksi = '$id_transaksi'";
//     $other_table_result = mysqli_query($koneksi, $other_table_query);

//     if (mysqli_num_rows($other_table_result) > 0) {
//         // ID transaksi is used in another table, display error message
//         $_SESSION["deleteTransaksiError"] = "ID transaksi tidak dapat dihapus";
//     } else {
//         // ID transaksi is not used in another table, delete transaksi
//         $koneksi->query("DELETE FROM transaksi WHERE id_transaksi = '$id_transaksi'");
//         $_SESSION["deleteTransaksi"] = "Data berhasil di hapus";
//     }

//     header("location: transaksi.php");
// }

//=====================================================================================================================//

// Insert User
if (isset($_POST['simpan_user'])) {
    $id_user = isset($_POST['id_user']) ? $_POST['id_user'] : "";
    $nama_user = $_POST['nama_user'];
    $username = $_POST['username'];
    $plain_password = $_POST['password']; // Get the plain password
    $outlet_id = $_POST['outlet_id'];
    $role = $_POST['role'];

    // Hash the password using bcrypt
    $hashed_password = password_hash($plain_password, PASSWORD_BCRYPT);

    $koneksi->query("INSERT INTO users (id_user, nama_user, username, password, outlet_id, role) VALUES ('$id_user', '$nama_user', '$username', '$hashed_password', '$outlet_id', '$role')");

    session_start();
    $_SESSION["simpanUser"] = "Data berhasil Ditambahkan";
    header("location:user.php");
}

// Delete User
if (isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];
    $koneksi->query("DELETE FROM users WHERE id_user = '$id_user'");

    session_start();
    $_SESSION["deleteUser"] = "Data berhasil Dihapus";
    header("location:user.php");
}

// Update User

if (isset($_POST['edit_user'])) {
    $id_user = isset($_POST['id_user']) ? $_POST['id_user'] : "";
    $nama_user = $_POST['nama_user'];
    $username = $_POST['username'];
    $plain_password = $_POST['password']; // Get the plain password
    $outlet_id = $_POST['outlet_id'];
    $role = $_POST['role'];

    // Hash the password using bcrypt
    $hashed_password = password_hash($plain_password, PASSWORD_BCRYPT);

    $koneksi->query("UPDATE users SET nama_user='$nama_user', username='$username', password='$hashed_password', outlet_id='$outlet_id', role='$role' WHERE id_user='$id_user'");
    
    session_start();
    $_SESSION["editUser"] = "Data berhasil Edit";
    header("location:user.php");
}
//===================================================================================================================//
if (isset($_POST['simpan_detail'])) {
    $id_detail = isset($_POST['id_detail']) ? $_POST['id_detail'] : "";
    $transaksi_id = $_POST['transaksi_id'];
    $paket_id = $_POST['paket_id'];
    $qty = $_POST['qty'];
    $keterangan = $_POST['keterangan'];
    $koneksi->query("INSERT INTO detail_transaksi (id_detail, transaksi_id, paket_id, qty, keterangan) VALUES ('$id_detail', '$transaksi_id', '$paket_id', '$qty', '$keterangan')");

    session_start();
    $_SESSION["simpanDetail"] = "Data berhasil dismpan";
    header("location:detailtransaksi.php");

}

if (isset($_GET['id_detail'])) {
    $id_detail = $_GET['id_detail'];
    $koneksi->query("DELETE FROM detail_transaksi WHERE id_detail = '$id_detail'");

    session_start();
    $_SESSION["deleteDetail"] = "Data berhasil dihapus";
    header("location:detailtransaksi.php");
}

if (isset($_POST['edit_detail'])) {
    $id_detail = isset($_POST['id_detail']) ? $_POST['id_detail'] : "";
    $transaksi_id = $_POST['transaksi_id'];
    $paket_id = $_POST['paket_id'];
    $qty = $_POST['qty'];
    $keterangan = $_POST['keterangan'];
    $koneksi->query("UPDATE detail_transaksi SET transaksi_id='$transaksi_id', paket_id='$paket_id', qty='$qty', keterangan='$keterangan' WHERE id_detail='$id_detail'");

    session_start();
    $_SESSION["editDetail"] = "Data berhasil di edit";
    header("location:detailtransaksi.php");
}

?>

