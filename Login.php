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
    <title>Welcome Page</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<style>
/* General Styles */
body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background: url("img.jpg") no-repeat center center/cover;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    color: #fff;
}

/* Container Styles */
.container {
    display: flex;
    width: 70%;
    max-width: 1200px;
    background: #fff;
    color: #333;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    
}

/* Left Panel */
.left-panel {
    background: linear-gradient(135deg, #0F2027, #203A43, #2C5364);
    flex: 1;
    color: #fff;
    padding: 40px 30px;
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.left-panel .logo {
    font-size: 2.5em;
    font-weight: bold;
    margin-bottom: 10px;
}

.left-panel h1 {
    font-size: 2.5em;
    margin-bottom: 20px;
}

.left-panel p {
    font-size: 1.1em;
    margin-bottom: 40px;
}

.left-panel .website-link {
    font-size: 1em;
    color: #fff;
    text-decoration: none;
    border-bottom: 1px solid #fff;
    padding-bottom: 2px;
}

/* Right Panel */
.right-panel {
    flex: 1;
    padding: 40px 30px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.right-panel h2 {
    font-size: 1.8em;
    margin-bottom: 20px;
    text-align: center;
}

.right-panel .input-group {
    margin-bottom: 20px;
}

.right-panel .input-group label {
    display: block;
    font-size: 0.9em;
    margin-bottom: 5px;
    color: #333;
}

.right-panel .input-group input {
    width: 100%;
    padding: 12px;
    font-size: 1em;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.right-panel .continue-btn {
    width: 100%;
    padding: 12px;
    font-size: 1em;
    font-weight: bold;
    color: #fff;
    background: linear-gradient(to right, #1e293b, #1e293f);
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-bottom: 15px;
    transition: all 0.3s ease; /* Smooth transition for all properties */
}

.right-panel .continue-btn:hover {
    background: linear-gradient(to right, #374151, #4b5563); /* Change background on hover */
    color: #e5e7eb; /* Change text color on hover */
    transform: scale(1.05); /* Slightly enlarge the button */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
}


.right-panel .or-text {
    text-align: center;
    margin: 10px 0;
    font-size: 0.9em;
    color: #666;
}

.social-buttons {
    display: flex;
    justify-content: space-between;
}

.social-buttons button {
    flex: 1;
    padding: 10px;
    font-size: 0.9em;
    border: none;
    border-radius: 5px;
    color: #fff;
    margin: 0 5px;
    cursor: pointer;
}

.social-buttons .twitter-btn {
    background: #1e293b;
}

.social-buttons .facebook-btn {
    background: #1e293b;
}
</style>
<body>
    <div class="container">
        <div class="left-panel">
            <div class="logo">User Management</div>
            <h1>Sign In Page</h1>
            <p>Sign in to continue access</p>
            <a href="index.php" class="website-link">Home</a>
        </div>
        <div class="right-panel">
            <h2>Sign In</h2>
            <form action="loginfunction.php" method="POST" id="form">
    <?php if (!empty($errorMessage)): ?>
        <div class="session-message"><?php echo $errorMessage; ?></div>
    <?php endif; ?>

    <div class="input-group">
        <label for="email">Email Address:</label>
        <input type="text" id="email" name="email" placeholder="Enter your email" required>
    </div>
    <div class="input-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
    </div>
    
    <!-- Google reCAPTCHA widget -->
    <div class="g-recaptcha" data-sitekey="6Le0fZoqAAAAAHUKVmLuUW0bsDJQoopPZZ9l8047"></div>
    <br/>

    <button type="submit" class="continue-btn" id="loginbutton">Login</button>
    <p class="or-text">Or</p>
    <div class="social-buttons">
        <a href="forgotpassword.php">
            <button type="button" class="twitter-btn">Forgot Password</button>
        </a>
        <a href="register.php">
            <button type="button" class="twitter-btn">Not registered yet?</button>
        </a>
    </div>
</form>
        </div>
    </div>
    <script src="js/login.js"></script>
</body>
</html>
