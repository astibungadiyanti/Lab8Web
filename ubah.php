
<?php
include_once 'koneksi.php';

$id = (int) $_GET['id'];

$sql = "SELECT * FROM data_barang WHERE id_barang = $id";
$result = mysqli_query($conn, $sql);

$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data barang tidak ditemukan.");
}

if (isset($_POST['submit'])) {

    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $harga_jual = (float) $_POST['harga_jual'];
    $harga_beli = (float) $_POST['harga_beli'];
    $stok = (int) $_POST['stok'];

    $gambar = $data['gambar'];

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

    $sql = "UPDATE data_barang SET
        nama = '$nama',
        kategori = '$kategori',
        harga_jual = '$harga_jual',
        harga_beli = '$harga_beli',
        stok = '$stok',
        gambar = '$gambar'
        WHERE id_barang = $id";

    if (mysqli_query($conn, $sql)) {
        header('Location: index.php');
        exit;
    } else {
        echo "Gagal mengubah data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Barang</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1>Ubah Barang</h1>

    <form method="post" action="ubah.php?id=<?php echo $id; ?>"
          enctype="multipart/form-data">

        <div class="input">
            <label>Nama Barang</label>
            <input type="text" name="nama"
                value="<?php echo htmlspecialchars($data['nama']); ?>"
                required>
        </div>

        <div class="input">
            <label>Kategori</label>
            <select name="kategori">
                <?php
                $kategori_list = ['Komputer', 'Elektronik', 'Hand Phone'];

                foreach ($kategori_list as $kategori):
                ?>
                    <option value="<?php echo $kategori; ?>"
                    <?php if ($data['kategori'] == $kategori) echo 'selected'; ?>>
                        <?php echo $kategori; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="input">
            <label>Harga Jual</label>
            <input type="number" name="harga_jual"
                value="<?php echo $data['harga_jual']; ?>" required>
        </div>

        <div class="input">
            <label>Harga Beli</label>
            <input type="number" name="harga_beli"
                value="<?php echo $data['harga_beli']; ?>" required>
        </div>

        <div class="input">
            <label>Stok</label>
            <input type="number" name="stok"
                value="<?php echo $data['stok']; ?>" required>
        </div>

        <div class="input">
            <label>Ganti Gambar (Opsional)</label>
            <input type="file" name="file_gambar" accept="image/*">
        </div>

        <div class="submit">
            <input type="submit" name="submit" value="Simpan Perubahan">
        </div>

    </form>

    <br>
    <a href="index.php">Kembali</a>
</div>

</body>
</html>