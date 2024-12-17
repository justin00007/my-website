<?php
session_start();
include 'connection.php';

function verifyReCaptcha($response) {
    $secretKey = "6Le0fZoqAAAAAEIRJXm-GGFVslmYO32YoCJcEZSD";
    $verifyUrl = "https://www.google.com/recaptcha/api/siteverify";

    // Send POST request to reCAPTCHA server
    $data = [
        'secret' => $secretKey,
        'response' => $response
    ];

    $options = [
        'http' => [
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($verifyUrl, false, $context);
    return json_decode($result, true);
}

function login($email, $password, $captchaResponse) {
    global $conn;

    // Verify reCAPTCHA
    $captchaValidation = verifyReCaptcha($captchaResponse);

    if (!$captchaValidation['success']) {
        $_SESSION['error_message'] = 'reCAPTCHA verification failed. Please try again.';
        header("Location: Login.php");
        exit();
    }

    // Sanitize input
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // SQL query to fetch the hashed password for the given email
    $query = "SELECT id, username, password FROM user WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password against the hashed password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['username'];
            header("Location: home.php");
            exit();
        } else {
            $_SESSION['error_message'] = 'Password incorrect!';
            header("Location: Login.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = 'Email incorrect!';
        header("Location: Login.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $captchaResponse = $_POST['g-recaptcha-response'];

    login($email, $password, $captchaResponse);
}
?>
