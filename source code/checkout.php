<?php
session_start();
include('./includes/connect.php');

// Get user IP address
function getIPAddress() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

$ip = getIPAddress();

// Redirect to login if not logged in
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Please login to proceed to checkout.'); window.location='./users_area/user_login.php';</script>";
    exit();
}

$username = $_SESSION['username'];
$user_query = "SELECT * FROM user_table WHERE username = '$username'";
$user_result = mysqli_query($con, $user_query);
$user_data = mysqli_fetch_assoc($user_result);
$user_id = $user_data['user_id'];

// Get cart items by IP
$cart_query = "SELECT p.product_title, p.product_price, c.quantity FROM cart_details c 
               JOIN products p ON c.product_id = p.product_id 
               WHERE c.ip_address = '$ip'";
$cart_result = mysqli_query($con, $cart_query);

$total_price = 0;
$cart_items = [];

while ($row = mysqli_fetch_assoc($cart_result)) {
    $cart_items[] = $row;
    
    // Clean product price to remove non-numeric characters
    $price = preg_replace('/[^0-9.]/', '', $row['product_price']); // Remove any non-numeric characters except for dots
    $total_price += $price * $row['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
    <h2 class="text-center mb-4">Checkout Summary</h2>
    <?php if (empty($cart_items)): ?>
        <p class="text-center">Your cart is empty. <a href="index.php">Continue Shopping</a></p>
    <?php else: ?>
        <table class="table table-bordered text-center">
            <thead class="bg-info text-light">
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item): 
                    $price = preg_replace('/[^0-9.]/', '', $item['product_price']); // Clean price
                    $subtotal = $price * $item['quantity']; ?>
                    <tr>
                        <td><?= $item['product_title'] ?></td>
                        <td>Tk <?= number_format($price, 2) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>Tk <?= number_format($subtotal, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                    <td><strong>Tk <?= number_format($total_price, 2) ?></strong></td>
                </tr>
            </tbody>
        </table>

        <div class="text-center">
            <a href="./confirm_payment.php" class="btn btn-success btn-lg">Confirm Order</a>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
