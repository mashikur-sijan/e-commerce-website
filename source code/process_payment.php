<?php
session_start();
include("./includes/connect.php");
include("./functions/common_function.php");

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Please login to proceed to payment.'); window.location='users_area/user_login.php';</script>";
    exit();
}

$username = $_SESSION['username'];
$get_user = mysqli_query($con, "SELECT * FROM user_table WHERE username='$username'");
$user_data = mysqli_fetch_assoc($get_user);
$user_id = $user_data['user_id'];

$ip_address = getIPAddress();

// Check if payment method is set
if (!isset($_POST['payment_method'])) {
    echo "<script>alert('Payment data missing.'); window.location='checkout.php';</script>";
    exit();
}
$payment_method = $_POST['payment_method'];

// Calculate total amount from cart (by IP)
$total_query = "SELECT SUM(p.product_price * c.quantity) AS total 
                FROM cart_details c 
                JOIN products p ON c.product_id = p.product_id 
                WHERE c.ip_address = ?";
$stmt = mysqli_prepare($con, $total_query);
mysqli_stmt_bind_param($stmt, "s", $ip_address);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $total_amount);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if ($total_amount <= 0 || $total_amount === null) {
    echo "<script>alert('Your cart is empty.'); window.location='cart.php';</script>";
    exit();
}

// Process specific payment methods (for mock/demo only)
if ($payment_method == 'card') {
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];
    // Add validation or real API if needed
} elseif ($payment_method == 'bkash') {
    $bkash_number = $_POST['bkash_number'];
    // Add validation or real API if needed
} elseif ($payment_method == 'paypal') {
    // Proceed with PayPal flow if needed
}

// Insert payment info
$status = 'processing';
$insert = "INSERT INTO payments (user_id, amount, payment_method, status) VALUES (?, ?, ?, ?)";
$stmt_insert = mysqli_prepare($con, $insert);
mysqli_stmt_bind_param($stmt_insert, "idss", $user_id, $total_amount, $payment_method, $status);
$executed = mysqli_stmt_execute($stmt_insert);
mysqli_stmt_close($stmt_insert);

// Clear the cart
if ($executed) {
    $clear_cart = "DELETE FROM cart_details WHERE ip_address = ?";
    $stmt_clear = mysqli_prepare($con, $clear_cart);
    mysqli_stmt_bind_param($stmt_clear, "s", $ip_address);
    mysqli_stmt_execute($stmt_clear);
    mysqli_stmt_close($stmt_clear);

    echo "<script>alert('Payment submitted for admin approval.'); window.location='order_success.php';</script>";
} else {
    echo "<script>alert('Something went wrong. Please try again.'); window.location='checkout.php';</script>";
}
?>
