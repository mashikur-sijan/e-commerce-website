<?php
include('../includes/connect.php');
include('../functions/common_function.php'); // Ensure getIPAddress() is defined here

if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['user_registration'])) {
    $user_username = mysqli_real_escape_string($con, $_POST['user_username']);
    $user_email = mysqli_real_escape_string($con, $_POST['user_email']);
    $user_password = $_POST['user_password'];
    $confirm_user_password = $_POST['confirm_user_password'];
    $user_address = mysqli_real_escape_string($con, $_POST['user_address']);
    $user_contact = mysqli_real_escape_string($con, $_POST['user_contact']);
    $user_type = $_POST['user_type'];
    $user_ip = getIPAddress();

    $user_image = $_FILES['user_image']['name'];
    $user_image_tmp = $_FILES['user_image']['tmp_name'];
    $image_path = "./user_images/$user_image";

    // Validate password match
    if ($user_password !== $confirm_user_password) {
        echo "<script>alert('Passwords do not match!')</script>";
        exit();
    }

    // Check if username or email already exists
    $check_query = "SELECT * FROM `user_table` WHERE username='$user_username' OR user_email='$user_email'";
    $check_result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Username or Email already exists!')</script>";
    } else {
        $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

        // Move image to folder
        move_uploaded_file($user_image_tmp, $image_path);

        // Insert user
        $insert_query = "INSERT INTO `user_table` 
            (username, user_email, userpassword, user_image, user_ip, user_address, user_mobile, user_type) 
            VALUES ('$user_username', '$user_email', '$hashed_password', '$user_image', '$user_ip', '$user_address', '$user_contact', '$user_type')";

        if (mysqli_query($con, $insert_query)) {
            echo "<script>alert('Registration successful!')</script>";

            // Check for cart items
            $cart_query = "SELECT * FROM `cart_details` WHERE ip_address='$user_ip'";
            $cart_result = mysqli_query($con, $cart_query);
            $cart_count = mysqli_num_rows($cart_result);

            if ($cart_count > 0) {
                echo "<script>window.open('checkout.php','_self')</script>";
            } else {
                echo "<script>window.open('user_login.php','_self')</script>";
            }
        } else {
            echo "<script>alert('Registration failed!')</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2 class="text-center mb-4">New User Registration</h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="user_username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="user_username" required>
                    </div>
                    <div class="mb-3">
                        <label for="user_email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="user_email" required>
                    </div>
                    <div class="mb-3">
                        <label for="user_image" class="form-label">User Image</label>
                        <input type="file" class="form-control" name="user_image" required>
                    </div>
                    <div class="mb-3">
                        <label for="user_password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="user_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_user_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="confirm_user_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="user_address" class="form-label">Address</label>
                        <input type="text" class="form-control" name="user_address" required>
                    </div>
                    <div class="mb-3">
                        <label for="user_contact" class="form-label">Contact</label>
                        <input type="text" class="form-control" name="user_contact" required>
                    </div>
                    <div class="mb-3">
                        <label for="user_type" class="form-label">User Type</label>
                        <select class="form-select" name="user_type" required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="d-grid">
                        <input type="submit" name="user_registration" class="btn btn-info" value="Register">
                    </div>
                    <p class="text-center mt-3">Already have an account? <a href="user_login.php" class="link-danger">Login</a></p>
                </form>
            </div>
        </div>
    </div>

    <?php include('../includes/footer.php'); ?>
</body>
</html>
