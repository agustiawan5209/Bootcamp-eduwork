<?php
session_start();

function addToCart($itemId, $items) {
    // Check if the cart session variable exists
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if the item is already in the cart
    if (isset($_SESSION['cart'][$itemId])) {
        // Update the items if the item is already in the cart
        $_SESSION['cart'][$itemId] = $items;
    } else {
        // Add the item to the cart with the specified items
        $_SESSION['cart'][$itemId] = $items;
    }
}

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $itemId = $_POST['id'];
    $items = [
        'nama' => $_POST['nama'],
        'image' => $_POST['image'],
        'kategori' => $_POST['kategori'],
        'harga' => $_POST['harga'],
        'quantity' => $_POST['quantity'],
    ];

    addToCart($itemId, $items);
    header('location:cart_page.php');
}

?>