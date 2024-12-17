<?php
// Start session
session_start();
include('connection.php');

// Fetch products from the database
$sql = "SELECT * FROM product";
$result = $conn->query($sql);

// Initialize the cart session if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if a product is being added to the cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = (float)$_POST['product_price'];
    $quantity = (int)$_POST['quantity'];

    if ($quantity > 0) {
        $product_exists = false;

        // Check if the product is already in the cart
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $product_id) {
                $item['quantity'] += $quantity;
                $product_exists = true;
                break;
            }
        }

        // If the product is not in the cart, add it
        if (!$product_exists) {
            $_SESSION['cart'][] = [
                'id' => $product_id,
                'name' => $product_name,
                'price' => $product_price,
                'quantity' => $quantity
            ];
        }
    }

    // Redirect back to prevent form resubmission
    header('Location: home.php');
    exit();
}
?>

