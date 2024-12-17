<?php
session_start(); // Start session to access session variables

// Check if there's an error or success message set in the session
$errorMessage = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
$successMessage = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';

// Clear messages after displaying them
unset($_SESSION['error_message'], $_SESSION['success_message']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration Form</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
            background: rgba(255, 255, 255, 0.8);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
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

        .left-panel .website-link {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 1rem;
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
        }

        .input-group {
            display: flex;
            flex-direction: column;
        }

        .input-group label {
            font-weight: bold;
            margin-bottom: 5px;
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
            width: 100%;
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
</head>
<body>
    <div class="container">
        <div class="left-panel">
            <h1>User Registration</h1>
            <p>Create an account to access exclusive features.</p>
            <a href="Login.php" class="website-link">Already registered? Click here to log in</a>
        </div>
        <div class="right-panel">
            <form method="POST" action="registerfunction.php" id="registrationForm">
                <!-- Error and Success Messages -->
                <?php if ($errorMessage): ?>
                    <div class="session-message error"><?php echo htmlspecialchars($errorMessage); ?></div>
                <?php endif; ?>

                <?php if ($successMessage): ?>
                    <div class="session-message success"><?php echo htmlspecialchars($successMessage); ?></div>
                <?php endif; ?>

                <!-- Form Fields -->
                <div class="input-group">
                    <label for="username">Full Name</label>
                    <input type="text" name="username" id="username" required>
                </div>

                <div class="input-group">
                    <label for="email">Email ID</label>
                    <input type="email" name="email" id="email" required>
                </div>

                <div class="input-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" name="phone" id="phone" pattern="\d{10}" required>
                </div>

                <div class="input-group">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender" required>
                        <option value="" disabled selected>-- Select --</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="others">Others</option>
                    </select>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>

                <div class="input-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" required>
                </div>

                <div class="input-group">
                    <input type="checkbox" name="terms" id="terms" required>
                    <label for="terms">I agree with the terms and conditions</label>
                </div>

                <div class="g-recaptcha" data-sitekey="6Le0fZoqAAAAAHUKVmLuUW0bsDJQoopPZZ9l8047"></div>
                <br />
                <button type="submit">Register</button>
            </form>
        </div>
    </div>
    <script src="js/register.js"></script>
</body>
</html>
