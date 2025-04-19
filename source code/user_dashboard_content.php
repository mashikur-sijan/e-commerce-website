<?php
session_start();
include("./includes/connect.php");

if (!isset($_SESSION['user_id'])) {
    echo "Please log in to access your dashboard.";
    exit();
}

$user_id = $_SESSION['user_id'];
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'view-profile':
        // Fetch user details
        $query = "SELECT * FROM user_table WHERE user_id = '$user_id'";
        $result = mysqli_query($con, $query);
        $user = mysqli_fetch_assoc($result);
        echo "<h3>Profile Information</h3>";
        echo "<p><strong>Name:</strong> " . $user['username'] . "</p>";
        echo "<p><strong>Email:</strong> " . $user['user_email'] . "</p>";
        echo "<p><strong>Phone:</strong> " . $user['user_mobile'] . "</p>";
        break;

    case 'update-profile':
        echo '<h3>Update Profile</h3>';
        echo '<form method="POST" action="update_profile.php">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>';
        break;

    case 'confirm-payment':
        echo '<h3>Confirm Payment</h3>';
        echo '<form method="POST" action="confirm_payment.php">
                <div class="mb-3">
                    <label for="payment-method" class="form-label">Payment Method</label>
                    <select class="form-select" id="payment-method" name="payment_method" required>
                        <option value="credit-card">Credit Card</option>
                        <option value="paypal">PayPal</option>
                        <option value="bank-transfer">Bank Transfer</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Confirm Payment</button>
            </form>';
        break;

    case 'delete-account':
        echo '<h3>Delete Account</h3>';
        echo '<form method="POST" action="delete_account.php">
                <p>Are you sure you want to delete your account? This action cannot be undone.</p>
                <button type="submit" class="btn btn-danger">Delete Account</button>
            </form>';
        break;

    case 'view-purchases':
        // Fetch purchase history
        $order_query = "SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY order_date DESC";
        $order_result = mysqli_query($con, $order_query);
        
        if (mysqli_num_rows($order_result) > 0) {
            echo "<h3>Your Purchase History</h3>";
            echo "<table class='table table-bordered'>";
            echo "<thead><tr><th>Order ID</th><th>Amount</th><th>Payment Status</th><th>Payment Method</th><th>Date</th><th>Action</th></tr></thead><tbody>";

            while ($order = mysqli_fetch_assoc($order_result)) {
                echo "<tr>";
                echo "<td>" . $order['order_id'] . "</td>";
                echo "<td>₹" . number_format($order['amount'], 2) . "</td>";

                // Display payment status as a badge
                $payment_status = $order['payment_status'];
                if ($payment_status == 'paid') {
                    echo "<td><span class='badge bg-success'>Paid</span></td>";
                } elseif ($payment_status == 'pending') {
                    echo "<td><span class='badge bg-warning'>Pending</span></td>";
                } elseif ($payment_status == 'declined') {
                    echo "<td><span class='badge bg-danger'>Declined</span></td>";
                }

                // Display payment method
                echo "<td>" . ucfirst($order['payment_method']) . "</td>";

                // Display order date
                echo "<td>" . date("d-m-Y", strtotime($order['order_date'])) . "</td>";

                // Action for pending or declined payments
                if ($payment_status == 'pending' || $payment_status == 'declined') {
                    echo "<td><a href='payment_page.php?order_id=" . $order['order_id'] . "' class='btn btn-info btn-sm'>Pay Again</a></td>";
                } else {
                    echo "<td>-</td>";
                }

                echo "</tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<p>You have no purchase history.</p>";
        }
        break;

    default:
        echo "<h3>Welcome to your Dashboard</h3><p>Select an option from the sidebar to begin.</p>";
        break;
}
?>
