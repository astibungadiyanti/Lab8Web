
<?php
include("koneksi.php");

// Mengambil data barang dari database
$sql = "SELECT * FROM data_barang";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Barang</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1>Data Barang</h1>

    <a href="tambah.php" class="tambah">+ Tambah Barang</a>

    <div class="main">
        <table>
            <tr>
                <th>Gambar</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Harga Jual</th>
                <th>Harga Beli</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>

            <?php if ($result): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td>
                        <img src="gambar/<?php echo htmlspecialchars($row['gambar']); ?>"
                             alt="Gambar Barang" width="70">
                    </td>
                    <td><?php echo htmlspecialchars($row['nama']); ?></td>
                    <td><?php echo htmlspecialchars($row['kategori']); ?></td>
                    <td>Rp <?php echo number_format($row['harga_jual']); ?></td>
                    <td>Rp <?php echo number_format($row['harga_beli']); ?></td>
                    <td><?php echo $row['stok']; ?></td>
                    <td>
                        <a href="ubah.php?id=<?php echo $row['id_barang']; ?>">Ubah</a>
                        |
                        <a href="hapus.php?id=<?php echo $row['id_barang']; ?>"
                           onclick="return confirm('Yakin ingin menghapus barang ini?')">
                           Hapus
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Belum ada data barang.</td>
                </tr>
            <?php endif; ?>

        </table>
    </div>
</div>

</body>
</html>