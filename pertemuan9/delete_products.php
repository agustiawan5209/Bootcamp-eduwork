<?php
include("koneksi.php");
// Get the product ID from the request
$product_id = $_GET['id'];

// Fetch the image path from the database
$sql = "SELECT image FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$stmt->bind_result($image);
$stmt->fetch();
$stmt->close();

if (file_exists($image)) {
    unlink($image);
}

$sql = "DELETE FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$stmt->close();

$conn->close();

// Redirect to the products list page
header("Location: admin.php");
exit();
?>