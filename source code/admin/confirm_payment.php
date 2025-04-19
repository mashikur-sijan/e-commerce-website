<?php
include('../includes/connect.php');

// Admin Authentication Check
if (!isset($_SESSION['username']) || $_SESSION['usertype'] !== 'admin') {
    echo "<script>alert('You must be logged in as admin to access this page'); window.location='../users_area/user_login.php';</script>";
    exit();
}

// Handle Approve Payment
if (isset($_GET['approve_payment'])) {
    $payment_id = intval($_GET['approve_payment']);
    $update_query = "UPDATE payments SET status = 'paid' WHERE payment_id = $payment_id";
    if (mysqli_query($con, $update_query)) {
        echo "<script>alert('Payment approved successfully.'); window.location='index.php?confirm_payment';</script>";
    } else {
        echo "<script>alert('Failed to approve payment.'); window.location='index.php?confirm_payment';</script>";
    }
}

// Handle Decline Payment
if (isset($_GET['decline_payment'])) {
    $payment_id = intval($_GET['decline_payment']);
    $update_query = "UPDATE payments SET status = 'declined' WHERE payment_id = $payment_id";
    if (mysqli_query($con, $update_query)) {
        echo "<script>alert('Payment declined successfully.'); window.location='index.php?confirm_payment';</script>";
    } else {
        echo "<script>alert('Failed to decline payment.'); window.location='index.php?confirm_payment';</script>";
    }
}

// Fetch All Payments (including processing, paid, declined)
$query = "SELECT * FROM payments ORDER BY payment_id DESC";
$result = mysqli_query($con, $query);
?>

<div class="container">
    <h2>Payments to Confirm</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Payment ID</th>
                <th>User ID</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                $status = $row['status'];
                $status_class = $status === 'processing' ? 'bg-warning' : ($status === 'paid' ? 'bg-success' : 'bg-danger');
                echo "<tr>
                    <td>{$row['payment_id']}</td>
                    <td>{$row['user_id']}</td>
                    <td>Tk " . number_format($row['amount'], 2) . "</td>
                    <td><span class='badge $status_class'>" . ucfirst($status) . "</span></td>
                    <td>";
                
                // Only allow approval or decline if the payment is in 'processing' status
                if ($status === 'processing') {
                    echo "<a href='?approve_payment={$row['payment_id']}' class='btn btn-success btn-sm me-2'>Approve</a>
                          <a href='?decline_payment={$row['payment_id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to decline this payment?')\">Decline</a>";
                } else {
                    echo "<span class='text-muted'>No Actions</span>";
                }
                echo "</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
