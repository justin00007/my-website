<?php
session_start();
// Include database connection
include 'connection.php';

function login($email, $password) {
    global $conn; // Use the connection object from connection.php

    // Sanitize input
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // SQL query to fetch the password for the given email
    $query = "SELECT id, name, password FROM admin WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Compare the plain password
        if ($password === $user['password']) { // Direct string comparison
            // Password matches, start a session and redirect
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];

            // Redirect to home.php
            header("Location: adminhome.php");
            exit(); // Ensure no further code is executed after redirect
        } else {
            // Incorrect password, set session error message
            
            $_SESSION['error_message'] = 'Password incorrect!';
            header("Location: login.php"); // Redirect back to the login page
            exit(); // Ensure no further code is executed after redirect
        }
    } else {
        // Email not found, set session error message
        
        $_SESSION['error_message'] = 'Email incorrect!';
        header("Location: login.php"); // Redirect back to the login page
        exit(); // Ensure no further code is executed after redirect
    }
}

// Example usage
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    login($email, $password); // Call the login function
}
?>
