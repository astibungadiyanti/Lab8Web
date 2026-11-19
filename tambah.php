
<?php
include_once 'koneksi.php';

if (isset($_POST['submit'])) {

    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $harga_jual = (float) $_POST['harga_jual'];
    $harga_beli = (float) $_POST['harga_beli'];
    $stok = (int) $_POST['stok'];

    // Proses upload gambar
    $gambar = '';

    if (isset($_FILES['file_gambar']) &&
        $_FILES['file_gambar']['error'] == 0) {

        $filename = basename($_FILES['file_gambar']['name']);
        $filename = preg_replace('/[^A-Za-z0-9._-]/', '_', $filename);

        $destination = __DIR__ . '/gambar/' . $filename;

        if (move_uploaded_file(
            $_FILES['file_gambar']['tmp_name'],
            $destination
        )) {
            $gambar = $filename;
        }
    }

    // Menyimpan data ke database
    $sql = "INSERT INTO data_barang
    (nama, kategori, harga_jual, harga_beli, stok, gambar)
    VALUES
    ('$nama', '$kategori', '$harga_jual', '$harga_beli', '$stok', '$gambar')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header('Location: index.php');
        exit;
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Barang</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>

<div class="container">

    <h1>Tambah Barang</h1>

    <div class="main">

        <form method="post" action="tambah.php"
              enctype="multipart/form-data">

            <div class="input">
                <label>Nama Barang</label>
                <input type="text" name="nama" required>
            </div>

            <div class="input">
                <label>Kategori</label>
                <select name="kategori">
                    <option value="Komputer">Komputer</option>
                    <option value="Elektronik">Elektronik</option>
                    <option value="Hand Phone">Hand Phone</option>
                </select>
            </div>

            <div class="input">
                <label>Harga Jual</label>
                <input type="number" name="harga_jual" required>
            </div>

            <div class="input">
                <label>Harga Beli</label>
                <input type="number" name="harga_beli" required>
            </div>

            <div class="input">
                <label>Stok</label>
                <input type="number" name="stok" required>
            </div>

            <div class="input">
                <label>File Gambar</label>
                <input type="file" name="file_gambar"
                       accept="image/*">
            </div>

            <div class="submit">
                <input type="submit" name="submit" value="Simpan">
            </div>

        </form>

        <br>
        <a href="index.php">Kembali ke Data Barang</a>

    </div>
</div>

</body>
</html>