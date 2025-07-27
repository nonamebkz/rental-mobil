<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');
ini_set('display_startup_errors', 'On');

require 'koneksi.php';
if ($_GET['id'] == 'login') {
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $row = $koneksi->prepare("SELECT * FROM login WHERE username = ? AND password = md5(?)");

    $row->execute(array($user, $pass));

    $hitung = $row->rowCount();

    if ($hitung > 0) {

        session_start();
        $hasil = $row->fetch();

        $_SESSION['USER'] = $hasil;

        if ($_SESSION['USER']['level'] == 'admin') {
            echo '<script>alert("Login Sukses");window.location="../admin/index.php";</script>';
        } else {
            echo '<script>alert("Login Sukses");window.location="../index.php";</script>';
        }
    } else {
        echo '<script>alert("Login Gagal");window.location="../index.php";</script>';
    }
}

if ($_GET['id'] == 'daftar') {
    $data[] = $_POST['nama'];
    $data[] = $_POST['user'];
    $data[] = md5($_POST['pass']);
    $data[] = 'pengguna';

    $row = $koneksi->prepare("SELECT * FROM login WHERE username = ?");

    $row->execute(array($_POST['user']));

    $hitung = $row->rowCount();

    if ($hitung > 0) {
        echo '<script>alert("Daftar Gagal, Username Sudah digunakan ");window.location="../index.php";</script>';
    } else {

        $sql = "INSERT INTO `login`(`nama_pengguna`, `username`, `password`, `level`)
                VALUES (?,?,?,?)";
        $row = $koneksi->prepare($sql);
        $row->execute($data);

        echo '<script>alert("Daftar Sukses Silahkan Login");window.location="../index.php";</script>';
    }
}

if ($_GET['id'] == 'booking') {
    // Debugging values
    $total = $_POST['total_harga'] * $_POST['lama_sewa'];
    $unik  = random_int(100, 999);
    $total_harga = $total + $unik;

    $data[] = time();
    $data[] = $_POST['id_login'];
    $data[] = $_POST['id_mobil'];
    $data[] = $_POST['nik'];
    // Handle KTP file upload
    $ktp_file = ''; // Initialize with empty string
    if (isset($_FILES['ktp_file']) && $_FILES['ktp_file']['error'] == UPLOAD_ERR_OK) {
        $ktp_file = $_FILES['ktp_file']['name'];
        $tmp_name = $_FILES['ktp_file']['tmp_name'];
        $upload_dir = '../assets/image/';
        move_uploaded_file($tmp_name, $upload_dir . $ktp_file);
    }
    $data[] = $ktp_file; // Add KTP filename to data

    // Handle NPWP file upload
    $npwp_file = ''; // Initialize with empty string
    if (isset($_FILES['npwp_file']) && $_FILES['npwp_file']['error'] == UPLOAD_ERR_OK) {
        $npwp_file = $_FILES['npwp_file']['name'];
        $tmp_name_npwp = $_FILES['npwp_file']['tmp_name'];
        $upload_dir_npwp = '../assets/image/';
        move_uploaded_file($tmp_name_npwp, $upload_dir_npwp . $npwp_file);
    }
    $data[] = $npwp_file; // Add NPWP filename to data

    $data[] = $_POST['nama'];
    $data[] = $_POST['alamat'];
    $data[] = $_POST['no_tlp'];
    $data[] = $_POST['tanggal'];
    $data[] = $_POST['lama_sewa'];
    $data[] = $total_harga;
    $data[] = "Belum Bayar";
    $data[] = date('Y-m-d');

    $sql = "INSERT INTO booking (kode_booking, 
    id_login, 
    id_mobil, 
    ktp, 
    ktp_file, 
    npwp_file, 
    nama, 
    alamat, 
    no_tlp, 
    tanggal, lama_sewa, total_harga, konfirmasi_pembayaran, tgl_input) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $row = $koneksi->prepare($sql);
    if (!$row) {
        die("Prepare failed: " . $koneksi->errorInfo());
    }
    // Construct the debug SQL with values
    $debug_sql = $sql;
    $i = 0;
    foreach ($data as $value) {
        if (is_string($value)) {
            $value = "'" . $value . "'"; // Quote string values
        }
        $debug_sql = preg_replace('/\?/', $value, $debug_sql, 1); // Replace one at a time
        $i++;
    }


    $row->execute($data);

    echo '<script>alert("Anda Sukses Booking silahkan Melakukan Pembayaran");
    window.location="../bayar.php?id=' . time() . '";</script>';
}

if ($_GET['id'] == 'konfirmasi') {
error_reporting(E_ALL);
ini_set('display_errors', 'On');
    $data[] = $_POST['id_booking'];
    $data[] = $_POST['no_rekening'];
    $data[] = $_POST['nama'];
    $data[] = $_POST['nominal'];
    $data[] = $_POST['tgl'];
    // Handle bukti_bayar file upload
    $bukti_bayar_file = ''; // Initialize with empty string
    if (isset($_FILES['bukti_bayar']) && $_FILES['bukti_bayar']['error'] == UPLOAD_ERR_OK) {
        $bukti_bayar_file = $_FILES['bukti_bayar']['name'];
        $tmp_name_bukti_bayar = $_FILES['bukti_bayar']['tmp_name'];
        $upload_dir_bukti_bayar = '../uploads/';
        move_uploaded_file($tmp_name_bukti_bayar, $upload_dir_bukti_bayar . $bukti_bayar_file);
    }
    $data[] = $bukti_bayar_file; // Add bukti_bayar filename to data

    $sql = "INSERT INTO `pembayaran`(`id_booking`, 
    `no_rekening`, `nama_rekening`, `nominal`, `tanggal`, `bukti_bayar`) 
    VALUES (?,?,?,?,?,?)";
    $row = $koneksi->prepare($sql);
    if (!$row) {
        die("Prepare failed: " . $koneksi->errorInfo());
    }
    if (!$row->execute($data)) {
        die("Execute failed: " . $row->errorInfo());
    }

    $data2[] = 'Sedang di proses';
    $data2[] = $_POST['id_booking'];
    $sql2 = "UPDATE `booking` SET `konfirmasi_pembayaran`=? WHERE id_booking=?";
    $row2 = $koneksi->prepare($sql2);
    if (!$row2) {
        die("Prepare failed: " . $koneksi->errorInfo());
    }
    if (!$row2->execute($data2)) {
        die("Execute failed: " . $row->errorInfo());
    }

    echo '<script>alert("Kirim Sukses , Pembayaran anda sedang diproses");history.go(-2);</script>';
}
