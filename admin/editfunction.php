<?php
session_start();
include 'connection.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $student_name = mysqli_real_escape_string($conn, $_POST['Student_name']);
    $gender = mysqli_real_escape_string($conn, $_POST['Gender']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['Phone_number']);
    $email = mysqli_real_escape_string($conn, $_POST['Email']);
    $class = mysqli_real_escape_string($conn, $_POST['Class']);
    $reg_number = mysqli_real_escape_string($conn, $_POST['Reg_number']);

    // Update query
    $query = "UPDATE student SET 
              Student_name = '$student_name', 
              Gender = '$gender', 
              Phone_number = '$phone_number', 
              Email = '$email', 
              Class = '$class', 
              Reg_number = '$reg_number' 
              WHERE ID = $id";

    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Student details updated successfully!";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Error updating record: " . mysqli_error($conn);
        $_SESSION['msg_type'] = "danger";
    }

    header("Location: userlist.php"); // Redirect to the main page
    exit();
}
?>
