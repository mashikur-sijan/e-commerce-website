<?php
session_start();
include('../includes/connect.php');

// Check if the login form is submitted
if (isset($_POST['user_login'])) {
    $user_username = mysqli_real_escape_string($con, $_POST['user_username']);
    $user_password = $_POST['user_password'];

    // Use prepared statements for security
    $select_query = "SELECT * FROM `user_table` WHERE username=?";
    $stmt = mysqli_prepare($con, $select_query);
    mysqli_stmt_bind_param($stmt, "s", $user_username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row_count = mysqli_num_rows($result);

    if ($row_count == 1) {
        $row_data = mysqli_fetch_assoc($result);

        // Verify the password using password_verify
        if (password_verify($user_password, $row_data['userpassword'])) {
            // Store user data in session
            $_SESSION['username'] = $user_username;
            $_SESSION['user_id'] = $row_data['user_id']; // Store user ID in session (if applicable)
            $_SESSION['usertype'] = $row_data['user_type']; // Store user type (user/admin) in session

            // Redirect based on user type
            if ($row_data['user_type'] === 'admin') {
                // Redirect to admin dashboard directly if admin
                echo "<script>window.location.href = '../admin/index.php';</script>";
                exit(); // Make sure to exit after the redirect
            } else {
                // Redirect to user homepage if not admin
                echo "<script>window.location.href = '../index.php';</script>";
                exit(); // Make sure to exit after the redirect
            }
        } else {
            echo "<script>alert('Invalid password!')</script>";
        }
    } else {
        echo "<script>alert('Invalid username!')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        .content {
            flex: 1;
        }
        footer {
            background-color: #17a2b8;
            color: white;
            text-align: center;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <!-- Main Content -->
    <div class="content">
        <div class="container my-5">
            <h2 class="text-center mb-4">User Login</h2>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="user_username" class="form-label">Username</label>
                            <input type="text" id="user_username" class="form-control" name="user_username" required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="user_password" class="form-label">Password</label>
                            <input type="password" id="user_password" class="form-control" name="user_password" required autocomplete="off">
                        </div>
                        <div class="d-grid">
                            <input type="submit" value="Login" class="btn btn-info" name="user_login">
                        </div>
                        <p class="text-center small fw-bold mt-3">Don't have an account? 
                            <a href="user_registration.php" class="link-danger">Register</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Footer -->
    <?php include('../includes/footer.php'); ?>
</body>
</html>
