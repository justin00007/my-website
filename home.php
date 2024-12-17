<?php
session_start(); // Start the session
include('connection.php');
// Check if the user is logged in
if(!isset($_SESSION['user_id'])) {
    // If no session exists, redirect to the login page
    header("Location: Login.php");
    exit(); // Stop further script execution
}
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
$sql = "SELECT * FROM product";
$result = $conn->query($sql);
?>
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopForFun</title>
</head>
<style>
     * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('images/body-bg.jpg') no-repeat center center/cover; 
            color: #f0f0f0; 
            padding-top: 80px;
            transition: all 0.3s ease-in-out;
            background-attachment: fixed;
        }

        /* Navbar Styling */
        nav {
            background-color: #1a1a1a; /* Dark navbar */
            color: #f0f0f0;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
            padding: 15px 0;
            transition: all 0.3s ease-in-out;
        }

        nav .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        nav .navbar-brand {
            font-size: 2.5rem;
            font-weight: 700;
            color: #66b3ff;
            text-transform: uppercase;
        }

        nav .navbar-nav {
            display: flex;
            gap: 30px;
        }

        nav .nav-item a {
            text-decoration: none;
            color: #f0f0f0;
            font-size: 1.1rem;
            text-transform: uppercase;
            font-weight: 600;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        nav .nav-item a:hover {
            color: #66b3ff;
            transform: translateY(-2px);
        }

        nav .dropdown {
            position: relative;
        }
        

        nav .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: #1a1a1a;
            border: 1px solid #333;
            border-radius: 5px;
            display: none;
            min-width: 200px;
            z-index: 1000;
        }

        nav .dropdown-menu a {
            color: #f0f0f0;
            padding: 12px 20px;
            display: block;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 500;
        }

        nav .dropdown-menu a:hover {
            background-color: #66b3ff;
        }

        nav .dropdown:hover .dropdown-menu {
            display: block;
        }

        nav .cart-button {
            background-color: #66b3ff;
            padding: 10px 15px;
            color: white;
            border: none;
            border-radius: 5px;
            margin-left: 20px;
            cursor: pointer;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: background-color 0.3s ease;
        }

        nav .cart-button:hover {
            background-color: #3399ff;
        }

        /* Position account dropdown in the top-right corner */
        nav .navbar-nav {
            margin-left: auto;
        }

        /* Main Hero Section */
        .hero-section {
            background: url('background.jpg') center center/cover no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            position: relative;
        }

        .hero-section .hero-content {
            max-width: 800px;
            background-color: rgba(0, 0, 0, 0.7); /* Darker background */
            padding: 40px;
            border-radius: 15px;
        }

        .hero-section h1 {
            font-size: 4rem;
            margin-bottom: 20px;
            text-transform: uppercase;
            font-weight: 700;
        }

        .hero-section p {
            font-size: 1.25rem;
            margin-bottom: 30px;
        }

        .hero-section .cta-button {
            background-color: #66b3ff;
            padding: 12px 30px;
            font-size: 1.2rem;
            color: white;
            text-transform: uppercase;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .hero-section .cta-button:hover {
            background-color: #3399ff;
        }

        /* Product Grid */
        .product-section {
            padding: 80px 20px;
            text-align: center;
            background-color: #1c1c1c; /* Dark background for section */
        }

        .product-section h2 {
            font-size: 3rem;
            margin-bottom: 40px;
            color: #f0f0f0;
            text-transform: uppercase;
            font-weight: 600;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 40px;
            justify-items: center;
        }

        .product-card {
            background-color: #2d2d2d; /* Darker card background */
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            width: 100%;
            max-width: 350px;
            text-align: center;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        .product-card img {
            max-width: 100%;
            height: 220px;
            object-fit: cover;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .product-card h3 {
            font-size: 1.5rem;
            color: #f0f0f0;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .product-card .price {
            font-size: 1.25rem;
            color: #66b3ff;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .product-card button {
            background-color: #66b3ff;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1rem;
            transition: background-color 0.3s ease;
        }

        .product-card button:hover {
            background-color: #3399ff;
        }

        /* Footer */
        footer {
            background-color: #1a1a1a;
            color: #f0f0f0;
            padding: 40px;
            text-align: center;
        }

        footer p {
            font-size: 1rem;
            margin-bottom: 20px;
        }

        footer a {
            color: #66b3ff;
            text-decoration: none;
            font-weight: 600;
            margin: 0 15px;
        }

        footer a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 3rem;
            }

            .product-section h2 {
                font-size: 2.5rem;
            }
        }
</style>
<body>
<nav>
        <div class="navbar-container">
            <a href="#" class="navbar-brand">ShopForFun</a>
            <div class="navbar-nav">
                <div class="nav-item"><a href="home.php">Home</a></div>
                <div class="nav-item"><a href="#">Shop</a></div>
                <div class="nav-item"><a href="#">About</a></div>
                <div class="nav-item"><a href="#">Contact</a></div>
                

                <div class="dropdown">
                    <a href="#" class="nav-item">Account</a>
                    <div class="dropdown-menu">
                    <a href="logout.php?logout">Log out</a>
                    </div>
                </div>
            </div>
            <button class="cart-button" onclick="window.location.href='cart.php'">
                🛒 <span><?php echo count($_SESSION['cart']); ?></span>
            </button>
        </div>
    </nav>

    
    <section class="hero-section">
        <div class="hero-content">
            <h1>Welcome to ShopForFun</h1>
            <?php echo $_SESSION['user_name'];   ?>
            <p>Your one-stop online sho pping destination for the best products.</p>
            <button class="cta-button">Shop Now</button>
        </div>
    </section>

    
    <section class="product-section">
        <h2>Our Featured Products</h2>
        <div class="product-grid">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $product_name = $row['product_name'];
                    $product_price = $row['product_price'];
                    $product_details = $row['product_details'];
                    $product_image = $row['product_image'];
                    $product_id = $row['id'];
            ?>
                <div class="product-card">
                    <img src="product/<?php echo $product_image; ?>" alt="<?php echo $product_name; ?>">
                    <h3><?php echo $product_name; ?></h3>
                    <div class="price">$<?php echo $product_price; ?></div>
                    <form method="post" action="add_to_cart.php">
                    <input type="number" name="quantity" value="1" min="1" required>
                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                    <input type="hidden" name="product_name" value="<?php echo $product_name; ?>">
                    <input type="hidden" name="product_price" value="<?php echo $product_price; ?>">
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                </form>
                </div>
            <?php
                }
            } else {
                echo "<p>No products available.</p>";
            }
            ?>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; ShopForFun. All rights reserved. <br> 
            <a href="#">Privacy Policy</a> | <a href="#">Terms & Conditions</a> | <a href="#">Sitemap</a>
        </p>
    </footer>

</html>
