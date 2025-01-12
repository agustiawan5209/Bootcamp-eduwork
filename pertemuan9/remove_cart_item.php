<?php
session_start();

if (isset($_GET['index'])) {
    $index = $_GET['index'];

    // Check if the cart session exists
    if (isset($_SESSION['cart'])) {
        // Loop through the cart items
        foreach ($_SESSION['cart'] as $key => $item) {
            // If the item ID matches, remove it from the cart
            if ($key == $index) {
                unset($_SESSION['cart'][$key]);
                // Re-index the array to avoid gaps
                $_SESSION['cart'] = array_values($_SESSION['cart']);
                break;
            }
        }
    }
}

// Redirect back to the cart page or any other page
header("Location: cart_page.php");
exit();
?>