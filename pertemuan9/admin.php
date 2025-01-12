<?php include('header.php') ?>

<section class="container">
    <a href="add_product.php">
        <button type="button" class="btn btn-primary">Tambah Data</button>
    </a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Kategori</th>
                <th>Deskripsi</th>
                <th>#Aksi</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $query = $conn->query('SELECT * FROM products');
            $no = 1;
            while ($row = $query->fetch_assoc()) {
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><img src="<?= htmlspecialchars($row['image']) ?>" height="100" class="card-img-top object-fit-contain" alt="<?= htmlspecialchars($row['nama']) ?>"></td>
                    <td><?= $row['nama'] ?></td>
                    <td><?= "Rp." . number_format($row['harga'], 0, 2) ?></td>
                    <td><?= $row['stok'] ?></td>
                    <td><?= $row['kategori'] ?></td>
                    <td><?= $row['deskripsi'] ?></td>
                    <td>
                        <a href="delete_products.php?id=<?= $row['id'] ?>" onclick="return confirmDelete(event)" class="text-danger">Delete</a>
                        <a href="edit_product.php?id=<?= $row['id'] ?>" class="text-primary">Edit</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

    <script>
        
        function confirmDelete(event) {
            // Show a confirmation dialog
            if (!confirm('Apakah anda yakin ingin menghapus data ini?')) {
                // If the user cancels, prevent the default link action
                event.preventDefault();
            }
        }
    </script>
</section>
<?php include('footer.php') ?>