<?php
session_start();
include("./includes/connect.php");
include("./functions/common_function.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart Details - Auto World</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="style.css">

  <style>
    .cart_img {
      width: 80px;
      height: 80px;
      object-fit: contain;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<div class="container-fluid p-0">
  <nav class="navbar navbar-expand-lg navbar-light bg-info">
    <div class="container-fluid">
      <img src="./images/logo.png" alt="Logo" class="logo">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="display_all.php">Products</a></li>
          <?php if (!isset($_SESSION['user_id'])): ?>
            <li class="nav-item"><a class="nav-link" href="users_area/user_registration.php">Register</a></li>
          <?php endif; ?>
          <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
          <li class="nav-item">
            <a class="nav-link" href="cart.php"><i class="bi bi-cart-dash-fill"></i><sup><?php cart_item(); ?></sup></a>
          </li>
        </ul>
        <ul class="navbar-nav">
          <?php if (isset($_SESSION['user_id'])): ?>
            <li class="nav-item"><a class="nav-link" href="#">Welcome <?= $_SESSION['username']; ?></a></li>
            <li class="nav-item"><a class="nav-link" href="user_logout.php">Logout</a></li>
          <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="users_area/user_login.php">Login</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Cart function -->
  <?php cart($con); ?>

  <!-- Cart Display -->
  <div class="bg-light">
    <h3 class="text-center">Auto World Ltd</h3>
    <p class="text-center">Welcome to Auto World Ltd - Your Car Accessories Destination!</p>
  </div>

  <div class="container">
    <form action="" method="post">
      <table class="table table-bordered text-center">
        <?php
        global $con;
        $get_ip_add = getIPAddress();
        $total_price = 0;
        $cart_query = "SELECT * FROM cart_details WHERE ip_address='$get_ip_add'";
        $result = mysqli_query($con, $cart_query);
        $result_count = mysqli_num_rows($result);

        if ($result_count > 0) {
          echo "<thead>
                  <tr>
                    <th>Product Title</th>
                    <th>Product Image</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Remove</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>";

          while ($row = mysqli_fetch_array($result)) {
            $product_id = $row['product_id'];
            $quantity = $row['quantity'];
            $select_product = "SELECT * FROM products WHERE product_id = '$product_id'";
            $product_result = mysqli_query($con, $select_product);
            $product = mysqli_fetch_assoc($product_result);

            $price = floatval($product['product_price']);
              $qty = intval($quantity);
              if ($qty <= 0) $qty = 1;
              $subtotal = $price * $qty;
              $total_price += $subtotal;


            echo "<tr>
                    <td>{$product['product_title']}</td>
                    <td><img src='./images/{$product['product_image1']}' class='cart_img'></td>
                    <td><input type='number' name='qty[{$product_id}]' value='{$quantity}' min='1' class='form-control w-50 mx-auto'></td>
                    <td>{$subtotal}/-</td>
                    <td><input type='checkbox' name='removeitem[]' value='{$product_id}'></td>
                    <td>
                      <input type='submit' name='update_cart' value='Update Cart' class='btn btn-info btn-sm mb-2'>
                      <input type='submit' name='remove_cart' value='Remove Selected' class='btn btn-danger btn-sm'>
                    </td>
                  </tr>";
          }

          echo "</tbody>";
        } else {
          echo "<h2 class='text-center text-danger'>Cart is empty</h2>";
        }
        ?>
      </table>

      <!-- Subtotal -->
      <div class="d-flex mb-4">
        <?php if ($result_count > 0): ?>
          <h4 class="px-3">Subtotal: <strong class="text-info"><?= $total_price ?>/-</strong></h4>
          <input type="submit" value="Continue Shopping" name="continue_shopping" class="btn btn-info mx-2">
          <a href="checkout.php" class="btn btn-secondary text-light">Checkout</a>
        <?php else: ?>
          <input type="submit" value="Continue Shopping" name="continue_shopping" class="btn btn-info">
        <?php endif; ?>
      </div>
    </form>
  </div>

  <!-- Update Quantity Logic -->
  <?php
  if (isset($_POST['update_cart']) && !empty($_POST['qty'])) {
    foreach ($_POST['qty'] as $pid => $qty) {
      $pid = intval($pid);
      $qty = intval($qty);
      if ($qty > 0) {
        $update_qty = "UPDATE cart_details SET quantity = $qty WHERE product_id = $pid AND ip_address = '$get_ip_add'";
        mysqli_query($con, $update_qty);
      }
    }
    echo "<script>window.location.href='cart.php';</script>";
  }
  ?>

  <!-- Remove Cart Items -->
  <?php
  if (isset($_POST['remove_cart'])) {
    if (!empty($_POST['removeitem'])) {
      foreach ($_POST['removeitem'] as $remove_id) {
        $delete_query = "DELETE FROM cart_details WHERE product_id = $remove_id AND ip_address = '$get_ip_add'";
        mysqli_query($con, $delete_query);
      }
      echo "<script>alert('Selected item(s) removed from cart.'); window.location.href='cart.php';</script>";
    } else {
      echo "<script>alert('Please select at least one item to remove.');</script>";
    }
  }

  if (isset($_POST['continue_shopping'])) {
    echo "<script>window.location.href='index.php';</script>";
  }
  ?>

  <?php include("./includes/footer.php"); ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
