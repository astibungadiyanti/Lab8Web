
<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "latihan1";

// Membuat koneksi ke database
$conn = mysqli_connect($host, $user, $pass, $db);

// Memeriksa koneksi
if ($conn == false) {
    echo "Koneksi ke server gagal.";
    die();
}

// Jika berhasil
echo "Koneksi berhasil";
?>