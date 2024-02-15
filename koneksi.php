<?php

$koneksi = new mysqli('localhost', 'root', '', 'laundry') or die(mysqli_error($koneksi));

// Crud Laundry

if (isset($_POST['simpan'])) {
    $id_outlet = isset($_POST['id_outlet']) ? $_POST['id_outlet'] : "";
    $nama_outlet = $_POST['nama_outlet'];
    $alamat_outlet = $_POST['alamat_outlet'];
    $telp_outlet = $_POST['telp_outlet'];
    $koneksi->query("INSERT INTO outlet (id_outlet, nama_outlet, alamat_outlet, telp_outlet) VALUES ('$id_outlet', '$nama_outlet', '$alamat_outlet', '$telp_outlet')");

    header("location:data.php");

}

if (isset($_GET['id_outlet'])) {
    $id = $_GET['id_outlet'];
    $koneksi->query("DELETE FROM outlet WHERE id_outlet = '$id'");
    header("location:data.php");
}

if (isset($_POST['edit_outlet'])) {
    $id_outlet = isset($_POST['id_outlet']) ? $_POST['id_outlet'] : "";
    $nama_outlet = $_POST['nama_outlet'];
    $alamat_outlet = $_POST['alamat_outlet'];
    $telp_outlet = $_POST['telp_outlet'];
    $koneksi->query("UPDATE outlet SET nama_outlet='$nama_outlet', alamat_outlet='$alamat_outlet', telp_outlet='$telp_outlet' WHERE id_outlet='$id_outlet'");
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

    header("location:member.php");
}
if (isset($_POST['edit_member'])) {
    $id_member = isset($_POST['id_member']) ? $_POST['id_member'] : "";
    $nama_member = $_POST['nama_member'];
    $alamat_member = $_POST['alamat_member'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $telp_member = $_POST['telp_member'];

    $koneksi->query("UPDATE member SET nama_member='$nama_member', alamat_member='$alamat_member', jenis_kelamin='$jenis_kelamin', telp_member='$telp_member' WHERE id_member='$id_member'");
    header("location: member.php");
}
if (isset($_GET['id_member'])) {
    $id_member = $_GET['id_member'];
    $koneksi->query("DELETE FROM member WHERE id_member = '$id_member'");
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

    header("location:paket.php");
}

if (isset($_POST['edit_paket'])) {
    $id_paket = isset($_POST['id_paket']) ? $_POST['id_paket'] : "";
    $jenis_paket = implode(",", $_POST['jenis_paket']);
    $nama_paket = $_POST['nama_paket'];
    $harga = $_POST['harga'];
    $outlet_id = $_POST['outlet_id']; 

    $koneksi->query("UPDATE paket SET jenis_paket='$jenis_paket', nama_paket='$nama_paket', harga='$harga', outlet_id='$outlet_id' WHERE id_paket='$id_paket'");
    header("location: paket.php");
}

if (isset($_GET['id_paket'])) {
    $id_paket = $_GET['id_paket'];
    $koneksi->query("DELETE FROM paket WHERE id_paket = '$id_paket'");
    header("location: paket.php");
}

//=====================================================================================================================//
if (isset($_POST['simpan_transaksi'])) {
    $id_transaksi = isset($_POST['id_transaksi']) ? $_POST['id_transaksi'] : "";
    $outlet_id = $_POST['outlet_id'];
    $kode_invoice = $_POST['kode_invoice'];
    $member_id = $_POST['member_id'];
    $tgl = $_POST['tgl'];
    $batas_waktu = $_POST['batas_waktu'];
    $tgl_pembayaran = $_POST['tgl_pembayaran'];
    $status = isset($_POST['status']) ? $_POST['status'][0] : ""; // Extract the selected value from the $status array
    $user_id = $_POST['user_id'];
    
    $koneksi->query("INSERT INTO transaksi (id_transaksi, outlet_id, kode_invoice, member_id, tgl, batas_waktu, tgl_pembayaran, status, user_id) 
                    VALUES ('$id_transaksi', '$outlet_id', '$kode_invoice', '$member_id', '$tgl', '$batas_waktu', '$tgl_pembayaran', '$status', '$user_id')");

    header("location:transaksi.php");
}


if (isset($_POST['edit_transaksi'])) {
    $id_transaksi = isset($_POST['id_transaksi']) ? $_POST['id_transaksi'] : "";
    $outlet_id = $_POST['outlet_id'];
    $kode_invoice = $_POST['kode_invoice'];
    $member_id = $_POST['member_id'];
    $tgl = $_POST['tgl'];
    $batas_waktu = $_POST['batas_waktu'];
    $tgl_pembayaran = isset($_POST['tgl_pembayaran']) ? $_POST['tgl_pembayaran'] : null;

    // Process 'status' as an array
    $statusArray = isset($_POST['status']) ? $_POST['status'] : [];
    $status = implode(',', array_map('mysqli_real_escape_string', array_fill(0, count($statusArray), $koneksi), $statusArray));

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
                    member_id='$member_id', tgl='$tgl', batas_waktu='$batas_waktu', 
                    tgl_pembayaran=$tgl_pembayaran, status='$status', user_id='$user_id' 
                    WHERE id_transaksi='$id_transaksi'");
    
    header("location: transaksi.php");
}


if (isset($_GET['id_transaksi'])) {
    $id_transaksi = $_GET['id_transaksi'];
    $koneksi->query("DELETE FROM transaksi WHERE id_transaksi = '$id_transaksi'");
    header("location: transaksi.php");
}

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

    header("location:user.php");
}

// Delete User
if (isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];
    $koneksi->query("DELETE FROM users WHERE id_user = '$id_user'");
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

    header("location:detailtransaksi.php");

}

if (isset($_GET['id_detail'])) {
    $id_detail = $_GET['id_detail'];
    $koneksi->query("DELETE FROM detail_transaksi WHERE id_detail = '$id_detail'");
    header("location:detailtransaksi.php");
}

if (isset($_POST['edit_detail'])) {
    $id_detail = isset($_POST['id_detail']) ? $_POST['id_detail'] : "";
    $transaksi_id = $_POST['transaksi_id'];
    $paket_id = $_POST['paket_id'];
    $qty = $_POST['qty'];
    $keterangan = $_POST['keterangan'];
    $koneksi->query("UPDATE detail_transaksi SET transaksi_id='$transaksi_id', paket_id='$paket_id', qty='$qty', keterangan='$keterangan' WHERE id_detail='$id_detail'");
    header("location:detailtransaksi.php");
}

?>

