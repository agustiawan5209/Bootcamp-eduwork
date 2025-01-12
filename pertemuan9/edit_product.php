<?php include('header.php') ?>
<?php 

if(isset($_GET['id'])){
    $query_produk = 'SELECT * FROM products';

    $stmt = $conn->query($query_produk);
    $product = $stmt->fetch_assoc();
}else{
    echo "<script>alert('Gagal Mengambil data')</script>";
    header('location:admin.php');

}

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];

    if(empty($nama) && empty($deskripsi) && empty($stok) && empty($harga) && empty($kategori)){
        echo "<script>alert('Maaf Kolom Harus Di isi')</script>";
    }
    $image = "";

    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
        // Folder untuk upload
        $target_dir = 'produk/';
        // nama file image
        $target_name = basename($_FILES['image']['name']);
        // gabung direktori folder upload dengan nama file 
        $target_file = $target_dir . $target_name;
        // pindahkan file ke folder upload
        if(move_uploaded_file($_FILES['image']['tmp_name'], $target_file)){
            $image = $target_file;
        } else {
            echo "<script>alert('Gagal mengupload gambar')</script>";
        }
    } else {
        $image = $product['image'];
    }

    $sql = "UPDATE products SET image = ?, nama = ?, stok = ?, deskripsi = ?, harga = ?, kategori = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisdsi", $image, $nama, $stok, $deskripsi, $harga, $kategori, $_GET['id']);

    if($stmt->execute()){
        header('location:admin.php');
    }else{
        echo "<script>alert('Gagal Menyimpan data')</script>";

    }

}

?>
    <div class="container mt-5">
        <h2>Update Data Product</h2>
       <div class="card">
        <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group mb-2">
                <label for="image">Produk Image</label>
                <input type="file" class="form-control" id="image" name="image" >
            </div>
            <div class="form-group mb-2">
                <label for="nama">Produk nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required value="<?= $product['nama'] ?>" >
            </div>
            <div class="form-group mb-2">
                <label for="stok">stok</label>
                <input type="number" class="form-control" id="stok" name="stok" required value="<?= $product['stok'] ?>">
            </div>
            <div class="form-group mb-2">
                <label for="deskripsi">deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required ><?= $product['deskripsi'] ?></textarea>
            </div>
            <div class="form-group mb-2">
                <label for="harga">harga</label>
                <input type="number" class="form-control" id="harga" name="harga" required value="<?= $product['harga'] ?>">
            </div>
            <div class="form-group mb-2">
            <label for="kategori" class="form-label mb-0">Kategori:</label>
                <select name="kategori" id="kategori" class="form-select w-full" required>
                    <option value="">-----</option>
                    <option <?= strtolower($product['kategori']) == "pakaian" ? 'selected' : '' ?> value="pakaian">pakaian</option>
                    <option <?= strtolower($product['kategori']) == "elektronik" ? 'selected' : '' ?> value="elektronik">elektronik</option>
                    <option <?= strtolower($product['kategori']) == "sepatu" ? 'selected' : '' ?> value="sepatu">sepatu</option>
                    <option <?= strtolower($product['kategori']) == "rumah tangga" ? 'selected' : '' ?> value="rumah tangga">rumah tangga</option>
                </select>
            </div>

            <br><br>
            <button type="submit" class="btn btn-primary">Update Produk</button>
        </form>
        </div>
       </div>
    </div>
    <?php include('footer.php')?>
