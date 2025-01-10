<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Data Produk</h1>

        <?php
        // Koneksi ke database
        $host = 'localhost';
        $user = 'root';
        $password = '';
        $database = 'bootcamp';

        $conn = new mysqli($host, $user, $password, $database);

        // Cek koneksi
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // Ambil kategori produk jika ada
        $kategori = $_GET['kategori'] ?? '';

        // Query untuk mengambil data produk
        $query = "SELECT * FROM products";
        if (!empty($kategori)) {
            $query .= " WHERE kategori = '" . $conn->real_escape_string($kategori) . "'";
        }

        $result = $conn->query($query);

        // Ambil semua kategori untuk filter
        $kategori_result = $conn->query("SELECT DISTINCT kategori FROM products");
        ?>

        <!-- Filter Kategori -->
        <div class="mb-4">
            <form method="GET" class="d-flex align-items-center gap-2">
                <label for="kategori" class="form-label mb-0">Filter Kategori:</label>
                <select name="kategori" id="kategori" class="form-select w-auto">
                    <option value="">Semua</option>
                    <?php while ($row = $kategori_result->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($row['kategori']) ?>" <?= $kategori === $row['kategori'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['kategori']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>

        <!-- Tabel Produk -->
        <div class="row">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="<?= htmlspecialchars($row['image']) ?>" height="300" class="card-img-top object-fit-contain" alt="<?= htmlspecialchars($row['nama']) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($row['nama']) ?></h5>
                                <p class="card-text">Harga: Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>
                                <p class="card-text">Deskripsi: <?= htmlspecialchars($row['deskripsi']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">Tidak ada data produk.</p>
            <?php endif; ?>
        </div>

        <?php
        // Tutup koneksi
        $conn->close();
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
