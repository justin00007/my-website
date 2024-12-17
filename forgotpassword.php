<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/forgotpassword.css">
</head>
<style>
    body {
    background: url("img.jpg") no-repeat center center/cover;
    font-family: "Arial", sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    color: #fff;
}

.container {
    width: 100%;
    max-width: 400px;
    padding: 25px;
    background: transparent; /* Dark solid background */
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(10px); /* Adds a frosted-glass effect */ /* Consistent shadow */
    color: #fff; /* White text color for better readability */
    
}

h2 {
    text-align: center;
    color: #fff;
    font-weight: bold;
    font-size: 1.8em;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    font-size: 14px;
    color: #fff;
    font-weight: bold;
}

.form-group input {
    width: 90%;
    padding: 12px 10px;
    background: rgba(255, 255, 255, 0.1); /* Semi-transparent dark input background */
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    font-size: 1em;
    color: #fff;
    outline: none;
    transition: background 0.3s ease, border 0.3s ease;
}

.form-group input:focus {
    background: rgba(255, 255, 255, 0.2); /* Highlight on focus */
    border: 1px solid #374151; /* Subtle focus accent */
}

.form-group input[type="submit"] {
    background: linear-gradient(to right, #1e293b, #374151); /* Matching button gradient */
    color: #fff;
    font-size: 1.1em;
    border: none;
    cursor: pointer;
    border-radius: 20px;
    width: 90%;
    padding: 12px 19px;
    font-weight: bold;
    transition: background 0.3s ease, transform 0.2s ease;
}

.form-group input[type="submit"]:hover {
    background: linear-gradient(to right, #374151, #4b5563); /* Hover gradient */
    transform: scale(1.05); /* Slight enlargement on hover */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Add hover shadow */
}

.message {
    text-align: center;
    color: #e94560; /* Accent color for error messages */
    font-size: 14px;
    margin-top: 15px;
}

.success {
    color: #4CAF50; /* Green for success messages */
}

</style>
<body>

    <div class="container">
        <h2>Forgot Password</h2>

        <!-- <?php if ($error_message): ?>
            <div class="message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <div class="message success"><?php echo $success_message; ?></div>
        <?php endif; ?> -->

        <form method="POST" action="password_function.php">
            <div class="form-group">
                <label for="email">Enter your email address:</label>
                <input type="email" id="email" name="email" value="" placeholder="Enter your email id" require>
            </div>
            <div class="form-group">
                <input type="submit" value="Send Reset Link">
            </div>
        </form>
    </div>

</body>
</html>
