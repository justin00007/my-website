<?php
session_start(); // Start the session

// Check if the user is logged in
if(!isset($_SESSION['user_id'])) {
    // If no session exists, redirect to the login page
    header("Location: Login.php");
    exit(); // Stop further script execution
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Homepage</title>
    <link rel= "stylesheet" href ="../css/adminhome.css">
</head>
<style>
    body {
    background: url("img.jpg") no-repeat center center/cover;
    background-size: cover;
    background-position: center;
    color: #e4e4e4; /* Light text for contrast */
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
}

/* Navigation Menu Styling */
ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    background-color: rgba(13, 17, 23, 0.9); /* Dark semi-transparent */
    display: flex;
    justify-content: flex-end;
    box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.3);
    padding: 10px;
    position: fixed; /* Makes the navbar fixed */
    top: 0; /* Sticks it to the top of the viewport */
    width: 100%; /* Spans the full width */
    z-index: 10; /* Ensures it stays on top of other elements */
}

li {
    margin-right: 20px;
}

li a {
    color: #e4e4e4; /* Light text */
    text-decoration: none;
    font-weight: bold;
    font-size: 16px;
    padding: 10px;
    transition: background-color 0.3s, color 0.3s;
}

li a:hover {
    background-color: #21262d; /* Slightly lighter dark color on hover */
    color: #58a6ff; /* Accent blue text on hover */
    border-radius: 5px;
}

/* Header Styling */
.header {
    text-align: center;
    color: white; /* Light text */
    margin: 30px 0;
    font-size: 36px;
    font-weight: bold;
    padding-top: 60px; /* To adjust for fixed navbar height */
    
}

.school-name {
    font-size: 48px;
    font-weight: bold;
    color: #062c57; /* Futuristic blue */
    text-shadow: 0px 2px 6px rgba(16, 16, 17, 0.5); /* Subtle glow effect */
}

/* Grid Container Styling */
.grid-container {
    display: grid;
    grid-template-columns: repeat(1, 2fr); /* one columns */
    gap: 20px;
    margin: 40px;
    padding: 20px;
    background-color: #161b22; /* Dark background */
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.5);
}

/* Individual Grid Content Styling */
.grid-content {
    background-color: #1c2025; /* Slightly lighter dark */
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    transition: background-color 0.3s, transform 0.3s;
    box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.3);
}

.grid-content h1 {
    color: #58a6ff; /* Accent blue */
    font-size: 22px;
    margin-bottom: 10px;
}

.grid-content p {
    color: #c9d1d9; /* Light gray */
    font-size: 16px;
    line-height: 1.5;
}

.grid-content:hover {
    background-color: #21262d; /* Slightly lighter dark on hover */
    transform: translateY(-5px); /* Lift effect */
    cursor: pointer;
}

/* Section Title */
.section-title {
    color: #58a6ff; /* Accent blue */
    font-size: 24px;
    margin-bottom: 10px;
    font-weight: bold;
    text-shadow: 0px 2px 4px rgba(88, 166, 255, 0.5); /* Glow effect */
}

/* Form Styling */
form {
    max-width: 400px;
    margin: 20px auto;
    padding: 20px;
    background-color: #1c2025; /* Dark background */
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.5);
    color: #c9d1d9; /* Light gray text */
}

form label {
    display: block;
    margin-bottom: 5px;
    color: #e4e4e4; /* Light text */
    font-weight: bold;
}

form input,
form textarea,
form button {
    width: calc(100% - 20px);
    margin: 10px 0;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #30363d; /* Darker gray border */
    background-color: #161b22; /* Dark input background */
    color: #e4e4e4; /* Light text */
    font-size: 14px;
    transition: background-color 0.3s, border-color 0.3s;
}

form input:focus,
form textarea:focus {
    background-color: #1c2025; /* Slightly lighter dark on focus */
    border-color: #58a6ff; /* Accent blue on focus */
    outline: none;
}

form button {
    background-color: #21262d; /* Dark button */
    color: #58a6ff; /* Accent blue text */
    border: none;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s;
}

form button:hover {
    background-color: #30363d; /* Slightly lighter on hover */
}

/* Footer Styling */
.footer {
    text-align: center;
    padding: 10px;
    background-color: #161b22; /* Dark background */
    color: #e4e4e4; /* Light text */
    font-size: 14px;
    position: fixed;
    width: 100%;
    bottom: 0;
    box-shadow: 0px -2px 6px rgba(0, 0, 0, 0.3);
}
</style>
<body>
    <!-- Navigation Menu -->
    <div class="menu-container">
        <ul>
            <li><a class="active" href="adminhome.php">Home</a></li>
            <li><a href="logout.php?logout">Log out</a></li>
        </ul>
    </div>

    <!-- Header Section -->
    <div class="header">
        <?php echo $_SESSION['user_name'];   ?>
        <div class="school-name"> Admin page</div>
        <p>Empowering students for a bright future!</p>
    </div>

    <!-- Grid Section -->
    <div class="grid-container">
        <!-- About Us Section -->
        <div class="grid-content">
            <a class="section-title" href="userlist.php">Student Data</h1>
            <p>Click to update and delete student's data.</p>
        </div>

        <div class="grid-content">
            <a class="section-title" href="../product/product.php">Product</h1>
            <p>Click to add more product </p>
        </div>
        <!-- Courses Section -->
        <div class="grid-content">
            <a class="section-title" href="deleteproduct.php">Product</h1>
            <p>click to delete product</p>
        </div>

       
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; Student Homepage | All Rights Reserved</p>
    </div>
</body>

</html>
