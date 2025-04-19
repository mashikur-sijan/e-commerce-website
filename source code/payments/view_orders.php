<?php
include('../includes/connect.php');
session_start();

// ✅ Admin authentication
if (!isset($_SESSION['username']) || $_SESSION['usertype'] !== 'admin') {
    echo "<script>alert('You must be logged in as admin'); window.location='../users_area/user_login.php';</script>";
    exit();
}

// ✅ Delete payment if requested
if (isset($_GET['delete_payment'])) {
    $payment_id = $_GET['delete_payment'];
    $delete_query = "DELETE FROM payments WHERE payment_id = $payment_id";
    $delete_result = mysqli_query($con, $delete_query);

    if ($delete_result) {
        echo "<script>alert('Payment deleted successfully'); window.location='view_orders.php';</script>";
    } else {
        echo "<script>alert('Failed to delete payment');</script>";
    }
}

// ✅ Fetch and display payments
$query = "SELECT payments.*, user_table.username 
          FROM payments 
          JOIN user_table ON payments.user_id = user_table.user_id 
          ORDER BY payments.payment_date DESC";

$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Payment Orders</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center mb-4">All Payment Orders</h2>
    <table class="table table-bordered table-striped text-center">
        <thead class="table-info">
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Order ID</th>
                <th>Amount</th>
                <th>Payment Mode</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $i++;
                echo "<tr>
                    <td>{$i}</td>
                    <td>{$row['username']}</td>
                    <td>{$row['order_id']}</td>
                    <td>Tk {$row['amount']}</td>
                    <td>{$row['payment_method']}</td>
                    <td>{$row['status']}</td>
                    <td>{$row['payment_date']}</td>
                    <td>
                        <a href='view_orders.php?delete_payment={$row['payment_id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this payment?')\">Delete</a>
                    </td>
                </tr>";
            }

            if ($i === 0) {
                echo "<tr><td colspan='8'>No payments found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
