<?php
session_start();
include("./includes/connect.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Update user details in database
    $query = "UPDATE users SET username = '$username', email = '$email', phone = '$phone' WHERE user_id = '$user_id'";
    mysqli_query($con, $query);

    echo "<script>alert('Profile updated successfully'); window.location.href='user_dashboard.php';</script>";
}
?>
