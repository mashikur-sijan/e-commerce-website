<?php
session_start();
include('../includes/connect.php');

// ✅ Admin Authentication Check
if (!isset($_SESSION['username']) || $_SESSION['usertype'] !== 'admin') {
    echo "<script>alert('You must be logged in as admin to access this page'); window.location='../users_area/user_login.php';</script>";
    exit();
}

// ✅ Handle Approve and Decline Payment Actions
if (isset($_GET['approve_payment'])) {
    $payment_id = $_GET['approve_payment'];
    // Approve the payment
    mysqli_query($con, "UPDATE payments SET status = 'paid' WHERE payment_id = $payment_id");
    echo "<script>alert('Payment approved successfully'); window.location='index.php?confirm_payment';</script>";
    exit(); // Ensure that we don't continue loading the rest of the page.
}

if (isset($_GET['decline_payment'])) {
    $payment_id = $_GET['decline_payment'];
    // Decline the payment
    mysqli_query($con, "UPDATE payments SET status = 'declined' WHERE payment_id = $payment_id");
    echo "<script>alert('Payment declined successfully'); window.location='index.php?confirm_payment';</script>";
    exit(); // Ensure that we don't continue loading the rest of the page.
}

// Main Dashboard Page
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        .admin-panel {
            background: #343a40;
            min-height: 100vh;
        }
        .admin-image {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
        }
        .nav-link {
            font-weight: 500;
        }
        .nav-link:hover {
            background-color: #0dcaf0;
            color: #fff !important;
        }
        .admin-buttons .btn {
            width: 100%;
            margin-bottom: 10px;
        }
        .footer {
            background-color: #17a2b8;
            color: #fff;
            font-weight: bold;
        }
        @media (min-width: 768px) {
            .admin-buttons {
                max-width: 300px;
            }
        }
    </style>
</head>
<body>
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-info">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#"><img src="../images/logo.png" alt="Logo" width="40"> Admin Panel</a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item me-3">
                    <span class="nav-link text-white">Welcome, <strong><?php echo $_SESSION['username']; ?></strong></span>
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-danger">Logout <i class="fas fa-sign-out-alt"></i></a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Admin Panel Layout -->
    <div class="container-fluid admin-panel d-flex flex-column flex-md-row">
        <!-- Sidebar -->
        <div class="bg-dark text-white p-4 admin-buttons d-flex flex-column align-items-center">
            <img src="../images/admin.png" alt="Admin" class="admin-image mb-3">
            <h5 class="text-center mb-4"><?php echo $_SESSION['username']; ?></h5>

            <a href="index.php?insert_product=true" class="btn btn-info text-white"><i class="fas fa-plus"></i> Insert Products</a>
            <a href="index.php?view_products" class="btn btn-info text-white"><i class="fas fa-boxes"></i> View Products</a>
            <a href="index.php?insert_category" class="btn btn-info text-white"><i class="fas fa-tags"></i> Insert Categories</a>
            <a href="index.php?view_categories" class="btn btn-info text-white"><i class="fas fa-list"></i> View Categories</a>
            <a href="index.php?insert_brand" class="btn btn-info text-white"><i class="fas fa-industry"></i> Insert Brands</a>
            <a href="index.php?view_brands" class="btn btn-info text-white"><i class="fas fa-eye"></i> View Brands</a>
            <a href="index.php?confirm_payment" class="btn btn-info text-white"><i class="fas fa-money-check-alt"></i> All Payments</a>
            <a href="index.php?view_users" class="btn btn-info text-white"><i class="fas fa-users"></i> List Users</a>
        </div>

        <!-- Main Content Area -->
        <div class="flex-grow-1 p-4 bg-light">
            <?php
            // Include the page corresponding to the query parameter
            if (isset($_GET['view_users'])) {
                include('view_users.php');
            } elseif (isset($_GET['view_products'])) {
                include('view_products.php');
            } elseif (isset($_GET['view_categories'])) {
                include('view_categories.php');
            } elseif (isset($_GET['view_brands'])) {
                include('view_brands.php');
            } elseif (isset($_GET['confirm_payment'])) {
                include('confirm_payment.php');
            } elseif (isset($_GET['insert_product']) && $_GET['insert_product'] == 'true') {
                include('insert_product.php'); // Include Insert Product Page
            } elseif (isset($_GET['insert_category'])) {
                include('insert_categories.php'); // Include Insert Category Page
            } elseif (isset($_GET['insert_brand'])) {
                include('insert_brands.php'); // Include Insert Brand Page
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer text-center p-3 mt-auto">
        <p>All rights reserved © Group 6 - 2025</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
