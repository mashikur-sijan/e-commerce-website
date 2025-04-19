<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: users_area/user_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Success</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5 text-center">
        <h2 class="text-success">✅ Payment Successful!</h2>
        <p>Your order has been submitted and is under processing. Once approved by admin, it will show as <strong>Paid</strong>.</p>
        <a href="index.php" class="btn btn-primary mt-3">Back to Home</a>
    </div>
</body>
</html>
