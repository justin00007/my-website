<?php
session_start(); // Start session to access session variables

// Check if there's an error message set in the session
$errorMessage = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
unset($_SESSION['error_message']); // Clear the error message after displaying it
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration Form</title>
    
    
</head>
<style>
    body{
        background: url("img.jpg") no-repeat center center/cover;
    }
    /* Form Styling */
form {
    max-width: 400px;
    margin: 50px auto;
    padding: 20px;
    background: transparent; /* Gradient background */
    border-radius: 20px;
    box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2); /* Deep shadow for a consistent look */
    color: #e4e4e4; /* Light gray text */
    backdrop-filter: blur(10px); /* Adds a frosted-glass effect */
}
h1{
    margin-left: 100px;
}
form label {
    display: block;
    margin-bottom: 10px;
    color: #ffffff; /* White text for better contrast */
    font-weight: bold;
    font-size: 16px;
}

form input,
form textarea,
form button {
    width: 95%;
    margin: 10px 0;
    padding: 12px 10px;
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.2); /* Subtle border */
    background: rgba(255, 255, 255, 0.1); /* Semi-transparent input background */
    color: #ffffff; /* White text */
    font-size: 16px;
    outline: none;
    transition: background-color 0.3s ease, border-color 0.3s ease, transform 0.2s ease;
}

form input:focus,
form textarea:focus {
    background: rgba(255, 255, 255, 0.2); /* Lighter background on focus */
    border-color: #58a6ff; /* Accent blue on focus */
}

form button {
    background: linear-gradient(to right, #1e293b, #374151); /* Gradient button background */
    color: #ffffff; /* White text */
    font-size: 16px;
    margin-left: 10px;
    font-weight: bold;
    cursor: pointer;
    border: none;
    border-radius: 10px;
    padding: 12px 10px;
    transition: background 0.3s ease, transform 0.2s ease;
}

form button:hover {
    background: linear-gradient(to right, #374151, #4b5563); /* Lighter gradient on hover */
    transform: scale(1.05); /* Slight enlargement on hover */
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3); /* Add a hover shadow */
}

form button:active {
    transform: scale(1); /* Reset scale on click */
}

form textarea {
    resize: none; /* Prevent resizing for consistent design */
}

.message {
    text-align: center;
    color: #58a6ff; /* Accent blue for messages */
    font-size: 14px;
    margin-top: 15px;
}

.success {
    color: #4CAF50; /* Green for success messages */
}

</style>
<body>
    <div class="form-container">
        <form method="POST" action="loginfunction.php" id="form">
            <h1>Admin Login</h1>

            <!-- Display session error message here -->
            <?php if ($errorMessage): ?>
                <div class="session-message"><?php echo $errorMessage; ?></div>
            <?php endif; ?>

            <div class="input-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email">
                <div class="error" id="emailerror"></div>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
                <div class="error" id="passworderror"></div>
            </div>
            
                
            <button type="submit" id="loginbutton">Login</button>
        </form>
    </div>
    <script src="js/login.js"></script>
</body>
</html>
