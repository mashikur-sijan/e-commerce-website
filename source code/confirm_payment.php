<?php
session_start(); // Ensure session is started
include("./includes/connect.php"); // Ensure the correct relative path
include("./functions/common_function.php"); 
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Please login to proceed to payment.'); window.location='../users_area/user_login.php';</script>";
    exit();
}

$username = $_SESSION['username'];
$user_query = "SELECT * FROM user_table WHERE username = '$username'";
$user_result = mysqli_query($con, $user_query);
$user_data = mysqli_fetch_assoc($user_result);
$user_id = $user_data['user_id'];

// Get cart items from the database
$ip = getIPAddress();
$cart_query = "SELECT p.product_title, p.product_price, c.quantity FROM cart_details c 
               JOIN products p ON c.product_id = p.product_id 
               WHERE c.ip_address = '$ip'";
$cart_result = mysqli_query($con, $cart_query);

$total_price = 0;
$cart_items = [];
while ($row = mysqli_fetch_assoc($cart_result)) {
    $cart_items[] = $row;
    $price = preg_replace('/[^0-9.]/', '', $row['product_price']);
    $total_price += $price * $row['quantity'];
}

// Payment options (mockup for actual integration)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirm Payment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
    <h2 class="text-center mb-4">Select Payment Method</h2>
    
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
                    $price = preg_replace('/[^0-9.]/', '', $item['product_price']);
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
            <!-- Payment options -->
            <h3>Choose Your Payment Method</h3>
            <div class="payment-options">
                <button class="btn btn-success btn-lg" data-bs-toggle="modal" data-bs-target="#cardModal">Credit/Debit Card</button>
                <button class="btn btn-warning btn-lg" data-bs-toggle="modal" data-bs-target="#bkashModal">bKash Payment</button>
                <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#paypalModal">PayPal</button>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Modal for Credit/Debit Card -->
<div class="modal fade" id="cardModal" tabindex="-1" aria-labelledby="cardModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cardModalLabel">Credit/Debit Card Payment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="process_payment.php" method="POST">
            <div class="mb-3">
                <label for="cardNumber" class="form-label">Card Number</label>
                <input type="text" class="form-control" id="cardNumber" name="card_number" required>
            </div>
            <div class="mb-3">
                <label for="expiryDate" class="form-label">Expiry Date</label>
                <input type="text" class="form-control" id="expiryDate" name="expiry_date" required>
            </div>
            <div class="mb-3">
                <label for="cvv" class="form-label">CVV</label>
                <input type="text" class="form-control" id="cvv" name="cvv" required>
            </div>
            <input type="hidden" name="payment_method" value="card">
            <button type="submit" class="btn btn-success">Pay Now</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal for bKash -->
<div class="modal fade" id="bkashModal" tabindex="-1" aria-labelledby="bkashModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bkashModalLabel">bKash Payment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Please enter your bKash number for payment.</p>
        <form action="process_payment.php" method="POST">
            <div class="mb-3">
                <label for="bkashNumber" class="form-label">bKash Number</label>
                <input type="text" class="form-control" id="bkashNumber" name="bkash_number" required>
            </div>
            <input type="hidden" name="payment_method" value="bkash">
            <button type="submit" class="btn btn-warning">Pay Now</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal for PayPal -->
<div class="modal fade" id="paypalModal" tabindex="-1" aria-labelledby="paypalModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paypalModalLabel">PayPal Payment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Proceed to PayPal for payment.</p>
        <form action="process_payment.php" method="POST">
            <input type="hidden" name="payment_method" value="paypal">
            <button type="submit" class="btn btn-primary">Pay with PayPal</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
