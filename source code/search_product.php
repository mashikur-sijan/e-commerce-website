<!---connect file--->
<?php
  session_start();
  include("./includes/connect.php"); // Ensure the correct relative path
  include("./functions/common_function.php"); // Ensure this file defines getproducts
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <!---Required meta tags--->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E Commerce Website using PHP & MySQL</title>
    <!---Bootstrap CSS--->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!---font awesome--->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!---Bootstrap Icons--->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!---Custom CSS--->
    <link rel="stylesheet" href="style.css">

</head>
<body>

    <!---navbar--->
    <div class="container-fluid p-0">

    <!---first child--->
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
          <li class="nav-item">
          <a class="nav-link" href="users_area\user_registration.php">Register</a>
          </li>   
          <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"><i class="bi bi-cart-dash-fill"></i><sup><?php cart_item();?></sup></a>
            <li class="nav-item">
            <a class="nav-link" href="#">Total Price: <?php total_cart_price(); ?>/-</a>
          </li>
          </li>
      </ul>
      <form class="d-flex" action="" method="get">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data">
        <input type="submit" value="Search" class="btn btn-outline-light" name="search_data_product">
      </form>
    </div>
  </div>
</nav>
<!-- calling cart function-->
<?php
  cart($con);
  ?>
    <!---second child--->
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="#">Welcome User</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="users_area\user_login.php">Login</a>
        </li>
      </ul>
    </nav>

    <!---third child--->
    <div class="bg-light">
      <h3 class="text-center">Auto World Ltd</h3>
        <p class="text-center">Welcome to the Auto World Ltd</p>
    </div>

    <!---fourth child--->
    <div class="row px-3">

    <!-- Main Content -->
    <div class="col-md-10">

    <!---products--->
    <div class="row">
      <?php
        //call getproducts function
          search_product($con); // Ensure $con is defined in connect.php
          get_unique_categories($con); // Ensure $con is defined in connect.php
          get_unique_brands($con); // Ensure $con is defined in connect.php
        ?>
        <!---row end--->
        </div>
        <!---col end--->
        </div>

    <!-- Sidebar -->
    <div class="col-md-2 bg-secondary p-0">

    <!---Brands---> 
    <ul class="navbar-nav me-auto text-center">
      <li class="nav-item bg-info">
        <a href="#" class="nav-link text-light"><h4>JDM Brands</h4></a>
      </li>
          <?php
           getbrands($con); // Ensure $con is defined in connect.php
          ?>
        </ul>

    <!---Categories--->
    <ul class="navbar-nav me-auto text-center">
      <li class="nav-item bg-info">
        <a href="#" class="nav-link text-light"><h4>Categories</h4></a>
      </li>
          <?php
            getcategories($con); // Ensure $con is defined in connect.php
          ?>
        </ul>
      </div>
    </div>

    <!---last child--->
    <div class="bg-info p-3 text-center">
      <p>All right reserved ©- Designed by Group 6-2025</p>
    </div>

    <!---Bootstrap JS--->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
  </body>
</html>

<?php
include("./includes/connect.php"); // Ensure the database connection is included

if (isset($_GET['search_data_product'])) {
    $search_data = mysqli_real_escape_string($con, $_GET['search_data']); // Sanitize input

    // Query to search for products matching the search term
    $query = "SELECT * FROM products WHERE product_title LIKE '%$search_data%' OR product_description LIKE '%$search_data%'";
    $result = mysqli_query($con, $query);

    echo "<div class='container mt-5'>";
    echo "<h3 class='text-center'>Search Results for '$search_data'</h3>";

    if (mysqli_num_rows($result) > 0) {
        echo "<div class='row'>";
        while ($row = mysqli_fetch_assoc($result)) {
            $product_title = $row['product_title'];
            $product_price = $row['product_price'];
            $product_image = $row['product_image'];
            $product_id = $row['product_id'];

            echo "
            <div class='col-md-4 mb-3'>
                <div class='card'>
                    <img src='./images/$product_image' class='card-img-top' alt='$product_title'>
                    <div class='card-body'>
                        <h5 class='card-title'>$product_title</h5>
                        <p class='card-text'>Price: $product_price/-</p>
                        <a href='product_details.php?product_id=$product_id' class='btn btn-primary'>View Details</a>
                    </div>
                </div>
            </div>";
        }
        echo "</div>";
    } else {
        echo "<h5 class='text-center text-danger'>No results found for '$search_data'</h5>";
    }
    echo "</div>";
}
?>