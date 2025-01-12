<?php
session_start();
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="cart_page.php">Keranjang</a>
                    </li>
                </ul>
                <a href="login.php">
                    <button class="btn btn-outline-success" type="submit">Masuk</button>

                </a>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h1 class="mb-4">Shopping Cart</h1>
        <?php if (empty($cart)): ?>
            <div class="alert alert-warning">Your cart is empty.</div>
        <?php else: ?>
            <table class="table table-bordered align-middle text-center">
                <colgroup>
                    <col>
                    <col style="width: 200px;">
                    <col>
                    <col>
                    <col>
                </colgroup>
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Nama</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Total</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $index => $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nama']); ?> </td>
                            <td>
                                <div class="input-group justify-content-center">
                                    <button class="btn btn-danger btn-sm" onclick="updateQuantity(<?= $index ?>, 'decrease')">-</button>
                                    <input type="number"
                                        id="quantity<?= $index ?>"
                                        class="form-control text-center w-25"
                                        value="<?= htmlspecialchars($item['quantity']); ?>"
                                        min="1"
                                        readonly
                                        data-price="<?= htmlspecialchars($item['harga']); ?>">
                                    <button class="btn btn-success btn-sm" onclick="updateQuantity(<?= $index ?>, 'increase')">+</button>
                                </div>
                            </td>
                            <td>Rp <?= number_format($item['harga'], 0, ',', '.'); ?></td>
                            <td>Rp <span id="total<?= $index ?>"><?= number_format($item['quantity'] * $item['harga'], 0, ',', '.'); ?></span></td>
                            <td>
                                <button class="btn btn-danger btn-sm" onclick="removeItem(<?= $index ?>)">Hapus</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <script>
        function updateQuantity(index, action) {
            const quantityInput = document.getElementById('quantity' + index);
            const totalElement = document.getElementById('total' + index);

            let currentQuantity = parseInt(quantityInput.value);
            if (action === 'increase') {
                currentQuantity++;
            } else if (action === 'decrease' && currentQuantity > 1) {
                currentQuantity--;
            }

            // Update quantity in input field
            quantityInput.value = currentQuantity;

            // Get item price from data-price attribute
            const itemPrice = parseFloat(quantityInput.dataset.price);

            // Update total price
            totalElement.textContent = new Intl.NumberFormat('id-ID').format(currentQuantity * itemPrice);
        }


        function removeItem(index) {
            if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                // Send a request to the server to remove the item
                fetch(`remove_cart_item.php?index=${index}`)
                    .then(() => location.reload());

                alert('Fitur hapus item belum terintegrasi ke server.');
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>