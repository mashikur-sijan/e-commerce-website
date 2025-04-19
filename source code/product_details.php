<?php
session_start();
include("./includes/connect.php");
include("./functions/common_function.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Product Details</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Navbar -->
<div class="container-fluid p-0">
  <nav class="navbar navbar-expand-lg navbar-light bg-info">
    <div class="container-fluid">
      <img src="./images/logo.png" alt="" class="logo">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
      </button>
      
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="display_all.php">Products</a></li>

          <?php if (!isset($_SESSION['username'])): ?>
            <li class="nav-item"><a class="nav-link" href="users_area/user_registration.php">Register</a></li>
            <li class="nav-item"><a class="nav-link" href="users_area/user_login.php">Login</a></li>
          <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="user_logout.php">Logout</a></li>
          <?php endif; ?>

          <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
          <li class="nav-item">
            <a class="nav-link" href="cart.php">
              <i class="bi bi-cart-dash-fill"></i>
              <sup><?php cart_item(); ?></sup>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Total Price: <?php total_cart_price(); ?>/-</a>
          </li>
        </ul>
        <form class="d-flex" action="search_product.php" method="get">
          <input class="form-control me-2" type="search" placeholder="Search" name="search_data" required>
          <input type="submit" value="Search" class="btn btn-outline-light" name="search_data_product">
        </form>
      </div>
    </div>
  </nav>

  <?php cart($con); ?>

  <!-- Welcome Bar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
    <ul class="navbar-nav me-auto">
      <li class="nav-item">
        <a class="nav-link" href="#">
          Welcome <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?>
        </a>
      </li>
    </ul>
  </nav>

  <!-- Header -->
  <div class="bg-light">
    <h3 class="text-center">Auto World Ltd</h3>
    <p class="text-center">Welcome to the Auto World Ltd</p>
  </div>

  <!-- Main Content -->
  <div class="row px-3">
    <!-- Product Section -->
    <div class="col-md-10">
      <div class="row">
        <?php
        // Show product details
        view_details($con, true); // 'true' disables the 'View Details' button
        ?>
      </div>
    </div>

    <!-- Sidebar -->
    <div class="col-md-2 bg-secondary p-0">
      <ul class="navbar-nav me-auto text-center">
        <li class="nav-item bg-info">
          <a href="#" class="nav-link text-light"><h4>JDM Brands</h4></a>
        </li>
        <?php getbrands($con); ?>
      </ul>

      <ul class="navbar-nav me-auto text-center">
        <li class="nav-item bg-info">
          <a href="#" class="nav-link text-light"><h4>Categories</h4></a>
        </li>
        <?php getcategories($con); ?>
      </ul>
    </div>
  </div>

  <!-- Footer -->
  <?php include("./includes/footer.php"); ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
