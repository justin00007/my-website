
<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
</head>
<style>
    body {
    margin: 0;
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: url("img.jpg") no-repeat center center/cover;
}

.container {
    display: flex;
    flex-direction: column;
    max-width: 600px;
    width: 100%;
    border-radius: 15px;
    overflow: hidden;
    background: rgba(255, 255, 255, 0.1); /* Transparent background with a slight white tint */
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2); /* Visible shadow */
    backdrop-filter: blur(10px); /* Adds a frosted-glass effect */
    padding: 20px;
}


.left-panel {
    background: #1e293b;
    color: white;
    padding: 20px;
    text-align: center;
}

.left-panel h1 {
    font-size: 2rem;
    margin-bottom: 15px;
}

.left-panel p {
    font-size: 1rem;
    margin-bottom: 20px;
}

.right-panel {
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.right-panel h2 {
    font-size: 1.5rem;
    text-align: center;
    margin-bottom: 15px;
    color: #fff;
}

.input-group {
    display: flex;
    flex-direction: column;
}

.input-group label {
    font-weight: bold;
    margin-bottom: 5px;
    color: #fff;
}

.input-group input,
.input-group select {
    width: 96%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1rem;
}

button {
    padding: 10px;
    background: linear-gradient(to right, #1e293b, #1e293f);
    border: none;
    color: white;
    font-size: 1rem;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s ease;
}

button:hover {
    background: linear-gradient(to right, #374151, #4b5563);
}

.session-message {
    font-size: 0.9rem;
    text-align: center;
    margin-bottom: 15px;
}

.session-message.error {
    color: red;
}

.session-message.success {
    color: green;
}

.error {
    color: #e94560;
    font-size: 0.9em;
    margin-top: 5px;
}

</style>
<body>
    <div class="container">
    <div id="form">
        <form method="POST" action="product_function.php" id="productform" enctype="multipart/form-data">
            <?php  
            $errorMessage = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
            $successMessage = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
            
            // Clear messages after displaying them
            unset($_SESSION['error_message'], $_SESSION['success_message']);
            
            
            ?>
            <h1>Product</h1>
            <!-- Form Fields -->
            <div class="input-group">
                <label for="product_name">Product Name</label>
                <input type="text" name="product_name" id="product_name">
                <div class="error" id="pnameerror"></div>
            </div>

            <div class="input-group">
                <label for="product_price">Product Price</label>
                <input type="text" name="product_price" id="product_price">
                <div class="error" id="prriceerror"></div>
            </div>

            <div class="input-group">
                <label for="product_quantity">Product Quantity</label>
                <input type="text" name="product_quantity" id="product_quantity">
                <div class="error" id="quanerror"></div>
            </div>

            <div class="input-group">
                <label for="product_details">Product details</label>
                <input type="text" name="product_details" id="product_details">
                <div class="error" id="detailserror"></div>
            </div>

            <div class="input-group">
            <label for="product_image">Upload product image:</label>
            <input type="file" id="product_image" name="product_image" accept="image/*">
            </div>

            <button type="submit" id="submitbutton">Upload</button>
        </form>
</div>
    </div>
    <script src="productupload.js"></script>
</body>
</html>
