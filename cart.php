<?php
session_start();
include('connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            padding: 15px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .total {
            font-size: 1.2rem;
            font-weight: bold;
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
        .checkout-button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            font-size: 1rem;
            cursor: pointer;
            text-align: center;
            display: inline-block;
            margin-top: 20px;
        }
        .checkout-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1>Your Cart</h1>

    <?php if (!empty($_SESSION['cart'])): ?>
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $item):
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>$<?php echo number_format($subtotal, 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p class="total">Total: $<?php echo number_format($total, 2); ?></p>
        <a href="index.php">Continue Shopping</a> | 
        <a href="clear_cart.php">Clear Cart</a>
        
        <!-- Checkout Button -->
        <form action="checkout.php" method="get">
            <button type="submit" class="checkout-button">Checkout</button>
        </form>
        
    <?php else: ?>
        <p>Your cart is empty. <a href="home.php">Go shopping</a></p>
    <?php endif; ?>
</body>
</html>
