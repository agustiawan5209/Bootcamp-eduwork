<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Produk</title>
</head>
<body>
    <h1>Tambah Data Produk</h1>

    <?php
    // Variabel untuk menyimpan pesan error
    $error = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama = $_POST['nama'] ?? '';
        $harga = $_POST['harga'] ?? '';
        $deskripsi = $_POST['deskripsi'] ?? '';

        // Validasi input tidak boleh kosong
        if (empty($nama) || empty($harga) || empty($deskripsi)) {
            $error = "Semua kolom wajib diisi!";
        } else {
            echo "<h2>Data Produk:</h2>";
            echo "<p><strong>Nama:</strong> " . htmlspecialchars($nama) . "</p>";
            echo "<p><strong>Harga:</strong> " . htmlspecialchars($harga) . "</p>";
            echo "<p><strong>Deskripsi:</strong> " . htmlspecialchars($deskripsi) . "</p>";

            // Reset input
            $nama = $harga = $deskripsi = "";
        }
    }
    ?>

    <!-- Menampilkan pesan error jika ada -->
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>

    <!-- Form input produk -->
    <form method="POST" action="">
        <label for="nama">Nama Produk:</label><br>
        <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>" ><br><br>

        <label for="harga">Harga Produk:</label><br>
        <input type="number" id="harga" name="harga" value="<?= htmlspecialchars($_POST['harga'] ?? '') ?>" ><br><br>

        <label for="deskripsi">Deskripsi Produk:</label><br>
        <textarea id="deskripsi" name="deskripsi" ><?= htmlspecialchars($_POST['deskripsi'] ?? '') ?></textarea><br><br>

        <button type="submit">Simpan</button>
    </form>
</body>
</html>
