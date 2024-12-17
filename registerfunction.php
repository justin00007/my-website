<?php
// Include the database connection file
include 'connection.php';
session_start();

// Google reCAPTCHA secret key
$recaptchaSecret = '6Le0fZoqAAAAAEIRJXm-GGFVslmYO32YoCJcEZSD';

function validateInput($input) {
    return htmlspecialchars(trim($input));
}

function checkIfEmailRegistered($email) {
    global $conn;
    $sql = "SELECT * FROM user WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
    return false;
}

function checkIfPhoneRegistered($phone) {
    global $conn;
    $sql = "SELECT * FROM user WHERE phone = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $phone);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
    return false;
}

function insertUser($username, $email, $phone, $gender, $hashedPassword, $address) {
    global $conn;
    $sql = "INSERT INTO user (username, email, phone, gender, password, address) VALUES (?, ?, ?, ?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssss", $username, $email, $phone, $gender, $hashedPassword, $address);
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Registration successful!";
            header("Location: register.php");
            exit();
        }
    }
    die("Error preparing statement: " . $conn->error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = validateInput($_POST['username']);
    $email = validateInput($_POST['email']);
    $phone = validateInput($_POST['phone']);
    $gender = validateInput($_POST['gender']);
    $password = validateInput($_POST['password']);
    $address = validateInput($_POST['address']);
    $status = "active"; // Default status for new users
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    // Validate reCAPTCHA
    $recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
    $response = file_get_contents($recaptchaUrl . "?secret=" . $recaptchaSecret . "&response=" . $recaptchaResponse);
    $responseKeys = json_decode($response, true);

    if (!$responseKeys["success"]) {
        $_SESSION['error_message'] = "Please complete the reCAPTCHA verification.";
        header("Location: register.php");
        exit();
    }

    // Validate input
    if (empty($username)) {
        $_SESSION['error_message'] = "Username is required.";
        header("Location: register.php");
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Invalid email address.";
        header("Location: register.php");
        exit();
    }
    if (empty($phone) || !preg_match('/^\d{10}$/', $phone)) {
        $_SESSION['error_message'] = "Invalid phone number.";
        header("Location: register.php");
        exit();
    }
    if (empty($gender) || !in_array($gender, ['male', 'female', 'others'])) {
        $_SESSION['error_message'] = "Invalid gender selected.";
        header("Location: register.php");
        exit();
    }
    if (empty($address)) {
        $_SESSION['error_message'] = "Address is required.";
        header("Location: register.php");
        exit();
    }

    // Check for duplicates
    if (checkIfEmailRegistered($email)) {
        $_SESSION['error_message'] = "Email is already registered.";
        header("Location: register.php");
        exit();
    }
    if (checkIfPhoneRegistered($phone)) {
        $_SESSION['error_message'] = "Phone number is already registered.";
        header("Location: register.php");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    insertUser($username, $email, $phone, $gender, $hashedPassword, $address, $status);
}

$conn->close();
?>
