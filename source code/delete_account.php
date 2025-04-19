<?php
session_start();
include("./includes/connect.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Delete user account from database
    $query = "DELETE FROM user_table WHERE user_id = '$user_id'";
    mysqli_query($con, $query);

    // Destroy session and log the user out
    session_destroy();
    echo "<script>alert('Account deleted successfully'); window.location.href='index.php';</script>";
}
?>
