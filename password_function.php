<?php
// Include PHPMailer library
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Autoload the Composer packages
require 'vendor/autoload.php';

// Function to generate a random 6-digit password
function generateRandomPassword() {
    return str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT); // Ensure 6 digits
}

// Function to send password reset email
function sendPasswordEmail($toEmail, $newPassword) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Set the SMTP server to Gmail
        $mail->SMTPAuth = true;
        $mail->Username = 'banlam65@gmail.com';  // SMTP username
        $mail->Password = 'thzj inxs kixw mjto';  // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('banlam65@gmail.com', 'Test Login');
        $mail->addAddress($toEmail);  // Add recipient

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Notification';
        $mail->Body    = "Your new password is: <strong>$newPassword</strong>";

        $mail->send();
        echo "Password reset email has been sent!";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Function to reset the password in the database
function resetPassword($email) {
    // Database connection
    include "connection.php";

    // Check if the email exists in the student table
    $stmt = $conn->prepare("SELECT email FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Generate a new random 6-digit password
        $newPassword = generateRandomPassword();
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT); // Hash the password

        // Update the password in the database
        $updateStmt = $conn->prepare("UPDATE user SET password = ? WHERE email = ?");
        $updateStmt->bind_param("ss", $hashedPassword, $email);
        $updateStmt->execute();

        if ($updateStmt->affected_rows > 0) {
            echo "Password for $email has been reset successfully!<br>";
            // Send the password reset email
            sendPasswordEmail($email, $newPassword);
        } else {
            echo "Error updating password.";
        }

        $updateStmt->close();
    } else {
        echo "Email not found in the database.";
    }

    $stmt->close();
    $conn->close();
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    if (!empty($email)) {
        resetPassword($email);
    } else {
        echo "Please enter a valid email address.";
    }
}
?>
