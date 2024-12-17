<?php
session_start();
include 'connection.php'; // Include database connection

// Fetch data from the database
$query = "SELECT * FROM product";
$result = mysqli_query($conn, $query);

// Handle Delete Request
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    // Fetch the product image filename
    $fetchImageQuery = "SELECT product_image FROM product WHERE id = $id";
    $imageResult = mysqli_query($conn, $fetchImageQuery);
    $imageRow = mysqli_fetch_assoc($imageResult);

    if ($imageRow) {
        $imagePath = '../product/' . $imageRow['product_image']; // Adjust the path as necessary

        // Attempt to delete the record from the database
        $deleteQuery = "DELETE FROM product WHERE id = $id";
        if (mysqli_query($conn, $deleteQuery)) {
            // Unlink the image file if it exists
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $_SESSION['message'] = "Record deleted successfully.";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['message'] = "Failed to delete record.";
            $_SESSION['msg_type'] = "danger";
        }
    } else {
        $_SESSION['message'] = "Record not found.";
        $_SESSION['msg_type'] = "warning";
    }

    header("Location: " . $_SERVER['PHP_SELF']); // Refresh the page
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/userlist.css">
</head>
<style>
    body{
        background: linear-gradient(to right, #1a1a2e, #16213e, #0f3460);
    }
    td, th{
        color: white;
    }
    .mb-4{
        color: white;
    }
</style>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Product Records</h2>

        <!-- Display Session Message -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['msg_type']; ?> alert-dismissible fade show" role="alert">
                <?php 
                    echo $_SESSION['message'];
                    unset($_SESSION['message']); // Clear message
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Product Quantity</th>
                    <th>Product Details</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['product_price']; ?></td>
                        <td><?php echo $row['product_quantity']; ?></td>
                        <td><?php echo $row['product_details']; ?></td>
                        <td><?php echo $row['product_image']; ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>">Edit</button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $row['id']; ?>">Delete</button>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="updateproduct.php" enctype="multipart/form-data">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <div class="mb-3">
                                            <label for="product_name" class="form-label">Product Name</label>
                                            <input type="text" class="form-control" name="product_name" value="<?php echo $row['product_name']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="product_price" class="form-label">Product Price</label>
                                            <input type="text" class="form-control" name="product_price" value="<?php echo $row['product_price']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="product_quantity" class="form-label">Product Quantity</label>
                                            <input type="text" class="form-control" name="product_quantity" value="<?php echo $row['product_quantity']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="product_details" class="form-label">Product Details</label>
                                            <textarea class="form-control" name="product_details" rows="3" required><?php echo $row['product_details']; ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="product_image" class="form-label">Product Image</label>
                                            <input type="file" class="form-control" name="product_image" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" name="edit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Delete Product</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete this record?</p>
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
