<?php include('header.php') ?>
<?php 
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

    if(isset($_FILES['image'])){
        // Folder untuk upload
        $target_dir = 'produk/';
        // nama file image
        $target_name = basename($_FILES['image']['name']);
        // Ekstensi dari file
        // $target_ext = pathinfo($target_name, PATHINFO_EXTENSION);

        // gabung direktori folder upload dengan nama file 
        $target_file = $target_dir . $target_name;
        // pindahkan file ke folder upload
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file); 

        $image = $target_file;
    }

    $sql = "INSERT INTO products (image,nama, stok,deskripsi,harga,kategori) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisds", $image,$nama,$stok,$deskripsi,$harga,$kategori);

    if($stmt->execute()){
        header('location:admin.php');
    }else{
        echo "<script>alert('Gagal Menyimpan data')</script>";

    }

}

?>
    <div class="container mt-5">
        <h2>Tambah Data Product</h2>
       <div class="card">
        <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group mb-2">
                <label for="image">Produk Image</label>
                <input type="file" class="form-control" id="image" name="image" required>
            </div>
            <div class="form-group mb-2">
                <label for="nama">Produk nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="form-group mb-2">
                <label for="stok">stok</label>
                <input type="number" class="form-control" id="stok" name="stok" required>
            </div>
            <div class="form-group mb-2">
                <label for="deskripsi">deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
            </div>
            <div class="form-group mb-2">
                <label for="harga">harga</label>
                <input type="number" class="form-control" id="harga" name="harga" required>
            </div>
            <div class="form-group mb-2">
            <label for="kategori" class="form-label mb-0">Kategori:</label>
                <select name="kategori" id="kategori" class="form-select w-full" required>
                    <option value="">-----</option>
                    <option value="pakaian">pakaian</option>
                    <option value="elektronik">elektronik</option>
                    <option value="sepatu">sepatu</option>
                    <option value="rumah tangga">rumah tangga</option>
                </select>
            </div>

            <br><br>
            <button type="submit" class="btn btn-primary">tambah Produk</button>
        </form>
        </div>
       </div>
    </div>
    <?php include('footer.php')?>
