<?php
session_start();
include('connection.php');

// Stripe API keys
\Stripe\Stripe::setApiKey('your_secret_key_here'); // Replace with your Stripe Secret Key

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect the total amount for the checkout (from session or database)
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;
    }

    // Convert the total to the smallest currency unit (e.g., cents for USD)
    $amount = $total * 100; // For USD, $10 would be 1000 cents

    try {
        // Create a Payment Intent with the total amount
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'usd', // Change currency if needed
            'description' => 'Your Cart Total',
        ]);

        // Send client secret to the front end to complete the payment
        $clientSecret = $paymentIntent->client_secret;
    } catch (Exception $e) {
        // Handle error
        echo 'Error: ' . $e->getMessage();
    }
} else {
    // If no POST request, redirect to the cart
    header('Location: cart.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .checkout-container {
            width: 500px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .total {
            font-size: 1.2rem;
            font-weight: bold;
        }
        .btn {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 20px;
            width: 100%;
        }
        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="checkout-container">
        <h1>Checkout</h1>
        <p class="total">Total: $<?php echo number_format($total, 2); ?></p>

        <form id="payment-form" action="complete_payment.php" method="POST">
            <!-- Hidden input to store the Stripe client secret -->
            <input type="hidden" id="clientSecret" name="clientSecret" value="<?php echo $clientSecret; ?>">

            <!-- Stripe Elements Container -->
            <div id="card-element"></div>

            <button id="submit" class="btn">Pay Now</button>
        </form>
    </div>

    <script>
        var stripe = Stripe('your_publishable_key_here'); // Replace with your Stripe Publishable Key
        var clientSecret = document.getElementById('clientSecret').value;

        var elements = stripe.elements();
        var card = elements.create('card');
        card.mount('#card-element');

        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: card,
                    billing_details: {
                        name: 'Your Name' // You can add more fields if needed
                    }
                }
            }).then(function(result) {
                if (result.error) {
                    alert('Payment failed: ' + result.error.message);
                } else {
                    if (result.paymentIntent.status === 'succeeded') {
                        form.submit(); // Redirect to complete_payment.php after successful payment
                    }
                }
            });
        });
    </script>
</body>
</html>
