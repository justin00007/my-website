<?php
session_start();
include('connection.php');  // Include database connection file

// Debugging message to confirm script is running
echo "Script started.<br>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get product details from the form
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_quantity = $_POST['product_quantity'];
    $product_details = $_POST['product_details'];

    // Debugging output to check the POST data
    echo "Product details received:<br>";
    echo "Name: $product_name<br>";
    echo "Price: $product_price<br>";
    echo "Quantity: $product_quantity<br>";
    echo "Details: $product_details<br>";

    // Handle the file upload
    $product_image = $_FILES['product_image'];

    try {
        // Check if an image is uploaded
        echo "Checking if image is uploaded...<br>";
        if ($product_image['error'] == 0) {
            // Validate image type (Allow only JPEG, PNG, or GIF)
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            echo "Uploaded image type: " . $product_image['type'] . "<br>";
            if (!in_array($product_image['type'], $allowed_types)) {
                throw new Exception("Invalid image type. Only JPG, PNG, or GIF are allowed.");
            }

            // Validate image size (Limit to 5MB)
            $max_size = 5 * 1024 * 1024; // 5MB
            echo "Uploaded image size: " . $product_image['size'] . "<br>";
            if ($product_image['size'] > $max_size) {
                throw new Exception("Image size exceeds the maximum limit of 5MB.");
            }

            // Set the upload directory and file path
            $upload_dir = 'uploads/';
            $image_path = $upload_dir . basename($product_image['name']);
            echo "Image path: $image_path<br>";

            // Move the uploaded file to the server's directory
            if (move_uploaded_file($product_image['tmp_name'], $image_path)) {
                echo "Image uploaded successfully.<br>";
                // Insert product data into the database
                $query = "INSERT INTO product (product_name, product_price, product_quantity, product_details, product_image) 
                          VALUES (?, ?, ?, ?, ?)";
                echo "Prepared query: $query<br>";
                $stmt = $conn->prepare($query);

                // Check for errors with the prepared statement
                if ($stmt === false) {
                    throw new Exception("Failed to prepare the database statement.");
                }

                $stmt->bind_param("sssss", $product_name, $product_price, $product_quantity, $product_details, $image_path);
                echo "Parameters bound.<br>";

                // Execute the query and check if it was successful
                if ($stmt->execute()) {
                    // Success message
                    $_SESSION['success_message'] = "Product uploaded successfully!";
                    echo "Product uploaded to the database.<br>";
                } else {
                    throw new Exception("Failed to execute the statement: " . $stmt->error);
                }
                $stmt->close();
            } else {
                throw new Exception("Failed to upload image.");
            }
        } else {
            throw new Exception("No image uploaded.");
        }
    } catch (Exception $e) {
        // Catch any exceptions and set the error message
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
        echo "Error: " . $e->getMessage() . "<br>";
    }

    // Redirect back to the form
    header('Location: product.php');
    exit();
}
?>
