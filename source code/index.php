<?php
session_start(); // Ensure session is started
include("./includes/connect.php"); // Ensure the correct relative path
include("./functions/common_function.php"); // Ensure this file defines getproducts
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!---Required meta tags--->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Website using PHP & MySQL</title>
    <!---Bootstrap CSS--->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!---Font Awesome--->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!---Bootstrap Icons--->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!---Custom CSS--->
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!---Navbar--->
    <div class="container-fluid p-0">

    <!---First Child (Navbar)--->
    <nav class="navbar navbar-expand-lg navbar-light bg-info">
      <div class="container-fluid">
        <img src="./images/logo.png" alt="" class="logo">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="display_all.php">Products</a>
            </li>
            <!-- Show Register and Login if user is NOT logged in -->
            <?php if (!isset($_SESSION['user_id'])): ?>
              <li class="nav-item">
                <a class="nav-link" href="users_area\user_registration.php">Register</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="users_area\user_login.php">Login</a>
              </li>
            <?php else: ?>
              <!-- If logged in, show the Logout button -->
              <li class="nav-item">
                <a class="nav-link" href="user_dashboard.php">Dashboard</a> <!-- Dashboard button -->
              </li>
              <li class="nav-item">
                <a class="nav-link" href="user_logout.php">Logout</a> <!-- Logout button -->
              </li>
            <?php endif; ?>
            <li class="nav-item">
              <a class="nav-link" href="contact.php">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="cart.php"><i class="bi bi-cart-dash-fill"></i><sup><?php cart_item();?></sup></a>  
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Total Price: <?php total_cart_price(); ?>/-</a>
            </li>
          </ul>
          <form class="d-flex" action="search_product.php" method="get">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data">
            <input type="submit" value="Search" class="btn btn-outline-light" name="search_data_product">
          </form>
        </div>
      </div>
    </nav>
    <!-- Calling cart function -->
    <?php cart($con); ?>

    <!---Second Child (Navbar with Welcome Message)--->
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <!-- Welcome message, display the username if logged in -->
          <a class="nav-link" href="#">Welcome <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'User'; ?></a>
        </li>
      </ul>
    </nav>

    <!---Third Child (Main Heading)--->
    <div class="bg-light">
      <h3 class="text-center">Auto World Ltd</h3>
      <p class="text-center">Welcome to the Auto World Ltd</p>
    </div>

    <!---Fourth Child (Main Content)--->
    <div class="row px-3">
      <!-- Main Content -->
      <div class="col-md-10">
        <!---Products--->
        <div class="row">
          <?php
          // Calling product display functions            
          getproducts($con); // Default product listing
          get_unique_categories($con);
          get_unique_brands($con);
          ?>
        </div>
      </div>
      <!-- Sidebar -->
      <div class="col-md-2 bg-secondary p-0">
        <!---Brands--->
        <ul class="navbar-nav me-auto text-center">
          <li class="nav-item bg-info">
            <a href="#" class="nav-link text-light"><h4>JDM Brands</h4></a>
          </li>
          <?php getbrands($con); ?>
        </ul>
        <!---Categories--->
        <ul class="navbar-nav me-auto text-center">
          <li class="nav-item bg-info">
            <a href="#" class="nav-link text-light"><h4>Categories</h4></a>
          </li>
          <?php getcategories($con); ?>
        </ul>
      </div>
    </div>

    <!---Last Child (Footer)--->
    <?php include("./includes/footer.php"); // Ensure the correct relative path ?>

    <!---Bootstrap JS--->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  </body>
</html>
