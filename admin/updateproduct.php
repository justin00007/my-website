<?php
session_start();
include 'connection.php';

if (isset($_POST['edit'])) {
    $id = intval($_POST['id']); // Ensure ID is an integer
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_price = mysqli_real_escape_string($conn, $_POST['product_price']);
    $product_quantity = mysqli_real_escape_string($conn, $_POST['product_quantity']);
    $product_details = mysqli_real_escape_string($conn, $_POST['product_details']);

    $new_image = null;

    // Check if a new image is uploaded
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $image_name = $_FILES['product_image']['name'];
        $image_tmp_name = $_FILES['product_image']['tmp_name'];
        $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($image_ext, $allowed_extensions)) {
            $new_image = uniqid() . '.' . $image_ext;
            $upload_path = '../product/' . $new_image;

            if (!move_uploaded_file($image_tmp_name, $upload_path)) {
                $_SESSION['message'] = "Failed to upload the new image.";
                $_SESSION['msg_type'] = "danger";
                header("Location: deleteproduct.php");
                exit();
            }
        } else {
            $_SESSION['message'] = "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
            $_SESSION['msg_type'] = "danger";
            header("Location: deleteproduct.php");
            exit();
        }
    }

    // Fetch the old image
    $fetchImageQuery = "SELECT product_image FROM product WHERE id = $id";
    $imageResult = mysqli_query($conn, $fetchImageQuery);

    if ($imageResult && mysqli_num_rows($imageResult) > 0) {
        $imageRow = mysqli_fetch_assoc($imageResult);
        $old_image = $imageRow['product_image'];
        $old_image_path = '../product/' . $old_image;

        if ($new_image) {
            // Delete the old image file if it exists
            if ($old_image && file_exists($old_image_path)) {
                unlink($old_image_path);
            }

            // Update query with the new image
            $updateQuery = "UPDATE product SET 
                            product_name = '$product_name', 
                            product_price = '$product_price', 
                            product_quantity = '$product_quantity', 
                            product_details = '$product_details', 
                            product_image = '$new_image' 
                            WHERE id = $id";
        } else {
            // Update query without changing the image
            $updateQuery = "UPDATE product SET 
                            product_name = '$product_name', 
                            product_price = '$product_price', 
                            product_quantity = '$product_quantity', 
                            product_details = '$product_details' 
                            WHERE id = $id";
        }

        if (mysqli_query($conn, $updateQuery)) {
            $_SESSION['message'] = "Product updated successfully.";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['message'] = "Failed to update product: " . mysqli_error($conn);
            $_SESSION['msg_type'] = "danger";
        }
    } else {
        $_SESSION['message'] = "Product not found.";
        $_SESSION['msg_type'] = "danger";
    }

    header("Location: deleteproduct.php");
    exit();
}
?>
