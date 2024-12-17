<?php
include 'connection.php'; // Include your connection file

$query = "SELECT id, product_name, product_price, product_quantity, product_details,product_image FROM product";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo '<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">';
    while ($row = $result->fetch_assoc()) {
        echo '<div style="border: 1px solid #ddd; border-radius: 8px; padding: 15px; text-align: center;">';
        echo '<img src="' . $row['product_image'] . '" alt="' . $row['product_name'] . '" style="width: 100%; height: auto; border-radius: 8px;">';
        echo '<h3 style="margin: 10px 0;">' . $row['product_name'] . '</h3>';
        echo '<p style="color: #555;">' . $row['product_details'] . '</p>';
        echo '<p><strong>Price:</strong> $' . number_format($row['product_price'], 2) . '</p>';
        echo '<p><strong>Quantity:</strong> ' . $row['product_quantity'] . '</p>';
        echo '<button style="padding: 10px 20px; background-color: #28a745; color: #fff; border: none; border-radius: 4px; cursor: pointer;">Add to Cart</button>';
        echo '</div>';
    }
    echo '</div>';
} else {
    echo "No products available.";
}

$conn->close();
?>
