<?php
session_start();
include 'connection.php'; // Include database connection

// Fetch data from the database
$query = "SELECT * FROM student";
$result = mysqli_query($conn, $query);

// Handle Delete Request
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $deleteQuery = "DELETE FROM student WHERE ID = $id";
    if (mysqli_query($conn, $deleteQuery)) {
        $_SESSION['message'] = "Record deleted successfully.";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Failed to delete record.";
        $_SESSION['msg_type'] = "danger";
    }
    header("Location: ".$_SERVER['PHP_SELF']); // Refresh the page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/userlist.css">
</head>
<style>
    body{
    background: linear-gradient(to right, #1a1a2e, #16213e, #0f3460);
}
td{
    color:white;
}
th{
    color: white;
}
.mb-4{
    color: white;
}

</style>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Student Records</h2>

        <!-- Display Session Message -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['msg_type']; ?> alert-dismissible fade show" role="alert">
                <?php 
                    echo $_SESSION['message'];
                    unset($_SESSION['message']); // Clear message
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Student Name</th>
                    <th>Gender</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Class</th>
                    <th>Registration Number</th>
                    <th colspan="2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['ID']; ?></td>
                        <td><?php echo $row['Student_name']; ?></td>
                        <td><?php echo $row['Gender']; ?></td>
                        <td><?php echo $row['Phone_number']; ?></td>
                        <td><?php echo $row['Email']; ?></td>
                        <td><?php echo $row['Class']; ?></td>
                        <td><?php echo $row['Reg_number']; ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['ID']; ?>">Edit</button>
                        </td>
                        <td>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $row['ID']; ?>">Delete</button>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal<?php echo $row['ID']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="editfunction.php">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Edit Student</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
                                        <div class="mb-3">
                                            <label for="studentName" class="form-label">Student Name</label>
                                            <input type="text" class="form-control" id="studentName" name="Student_name" value="<?php echo $row['Student_name']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="gender" class="form-label">Gender</label>
                                            <input type="text" class="form-control" id="gender" name="Gender" value="<?php echo $row['Gender']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="phoneNumber" class="form-label">Phone Number</label>
                                            <input type="text" class="form-control" id="phoneNumber" name="Phone_number" value="<?php echo $row['Phone_number']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="Email" value="<?php echo $row['Email']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="class" class="form-label">Class</label>
                                            <input type="text" class="form-control" id="class" name="Class" value="<?php echo $row['Class']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="regNumber" class="form-label">Registration Number</label>
                                            <input type="text" class="form-control" id="regNumber" name="Reg_number" value="<?php echo $row['Reg_number']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="deleteModal<?php echo $row['ID']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Delete Student</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete this record?</p>
                                        <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
