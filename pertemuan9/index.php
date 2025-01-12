<?php
     include("koneksi.php");
     session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                </ul>
                <a href="login.php">
                    <button class="btn btn-outline-success" type="submit">Masuk</button>

                </a>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h1 class="mb-4">Data Produk</h1>

        <?php
        // Ambil kategori produk jika ada
        $kategori = $_GET['kategori'] ?? '';

        // Query untuk mengambil data produk
        $query = "SELECT * FROM products";
        if (!empty($kategori)) {
            $query .= " WHERE kategori = '" . $conn->real_escape_string($kategori) . "'";
        }

        $result = $conn->query($query);

        // Ambil semua kategori untuk melakukan filter data pada produk
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
                                <p class="card-text">Kategori: <?= htmlspecialchars($row['kategori']) ?></p>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalproduct<?= $row['id'] ?>">
                                    Tambah Ke Keranjang
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Produk -->
                    <div class="modal fade" id="modalproduct<?= $row['id'] ?>" tabindex="-1" aria-labelledby="modalproduct<?= $row['id'] ?>Label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="modalproduct<?= $row['id'] ?>Label">Detail Produk</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                             <form action="add_to_cart.php" method="post">
                             <div class="modal-body">
                                    <div class="card">
                                        <img src="<?= htmlspecialchars($row['image']) ?>" height="300" class="card-img-top object-fit-contain" alt="<?= htmlspecialchars($row['nama']) ?>">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= htmlspecialchars($row['nama']) ?></h5>
                                            <p class="card-text">Harga: Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>
                                            <p class="card-text">Kategori: <?= htmlspecialchars($row['kategori']) ?></p>
                                            <p class="card-text">Deskripsi: <?= htmlspecialchars($row['deskripsi']) ?></p>
                                            
                                            <!-- Items -->

                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                            <input type="hidden" name="nama" value="<?= $row['nama'] ?>">
                                            <input type="hidden" name="image" value="<?= $row['image'] ?>">
                                            <input type="hidden" name="harga" value="<?= $row['harga'] ?>">
                                            <input type="hidden" name="kategori" value="<?= $row['kategori'] ?>">
                                            <!-- Quantity -->
                                            <div class="d-flex align-items-center mt-3">
                                                <button type="button" class="btn btn-danger me-2" onclick="decreaseQuantity(<?= $row['id'] ?>)">-</button>
                                                <input type="number" name="quantity" id="quantity<?= $row['id'] ?>" value="1" min="1" class="form-control text-center w-25" readonly>
                                                <button type="button" class="btn btn-success ms-2" onclick="increaseQuantity(<?= $row['id'] ?>)">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Tambahkan ke Keranjang</button>
                                </div>
                             </form>
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
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Fungsi untuk menambah quantity
        function increaseQuantity(id) {
            const quantityInput = document.getElementById('quantity' + id);
            let currentQuantity = parseInt(quantityInput.value);
            quantityInput.value = currentQuantity + 1;
        }

        // Fungsi untuk mengurangi quantity
        function decreaseQuantity(id) {
            const quantityInput = document.getElementById('quantity' + id);
            let currentQuantity = parseInt(quantityInput.value);
            if (currentQuantity > 1) { // Mencegah nilai kurang dari 1
                quantityInput.value = currentQuantity - 1;
            }
        }
    </script>
</body>

</html>