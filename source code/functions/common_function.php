<?php

    //include connect file 
    include($_SERVER['DOCUMENT_ROOT'] . '/E_Commerce_Website/includes/connect.php');

    //products function
    function getproducts($con) {
        global $con;

        //condition to check isset or not
        if(!isset($_GET["category"])){
            if(!isset($_GET["brand"])){
                $select_query = "SELECT * FROM `products` ORDER BY RAND() LIMIT 0,9";
                $result_query = mysqli_query($con, $select_query);
                while ($row = mysqli_fetch_array($result_query)) {
                    $product_id = $row["product_id"];
                    $product_title = $row["product_title"];
                    $product_description = $row["product_description"];
                    $product_keywords = $row["product_keywords"];
                    $product_image1 = $row["product_image1"];
                    $product_price = $row["product_price"];
                    $category_id = $row["category_id"];
                    $brand_id = $row["brand_id"];
                    echo "
                    <div class='col-md-4 mb-4'>
                      <div class='card h-100'>
                        <img src='./admin/product_images/$product_image1' class='card-img-top' alt='Product Image' style='height: 250px; object-fit: cover;'>
                        <div class='card-body'>
                          <h5 class='card-title'>$product_title</h5>
                          <p class='card-text'>$product_description</p>  
                          <p class='card-text'><strong>Price:</strong> $product_price/-</p>
                          <div class='d-flex justify-content-center gap-2'>
                            <a href='index.php?add_to_cart=$product_id' class='btn btn-info'>Add to Cart</a>
                            <a href='product_details.php?product_id=$product_id' class='btn btn-secondary'>View Details</a>
                          </div>
                        </div>
                      </div>
                    </div>";
                }
            }
        }
    }

    //getting all products  
    function get_all_products( $con ) {
        global $con;

        //condition to check isset or not
        if(!isset($_GET["category"])){
            if(!isset($_GET["brand"])){
                $select_query = "SELECT * FROM `products` ORDER BY RAND()";
                $result_query = mysqli_query($con, $select_query);
                while ($row = mysqli_fetch_array($result_query)) {
                    $product_id = $row["product_id"];
                    $product_title = $row["product_title"];
                    $product_description = $row["product_description"];
                    $product_keywords = $row["product_keywords"];
                    $product_image1 = $row["product_image1"];
                    $product_price = $row["product_price"];
                    $category_id = $row["category_id"];
                    $brand_id = $row["brand_id"];
                    echo "
                    <div class='col-md-4 mb-4'>
                      <div class='card h-100'>
                        <img src='./admin/product_images/$product_image1' class='card-img-top' alt='Product Image' style='height: 250px; object-fit: cover;'>
                        <div class='card-body'>
                          <h5 class='card-title'>$product_title</h5>
                          <p class='card-text'>$product_description</p>
                          <p class='card-text'><strong>Price:</strong> $product_price/-</p>
                          <div class='d-flex justify-content-center gap-2'>
                             <a href='index.php?add_to_cart=$product_id' class='btn btn-info'>Add to Cart</a>
                            <a href='product_details.php?product_id=$product_id' class='btn btn-secondary'>View Details</a>
                          </div>
                        </div>
                      </div>
                    </div>";
                }
            }
        }
    }

    //getting unique categories
    function get_unique_categories($con) {
        global $con;

        //condition to check isset or not
        if(isset($_GET["category"])){
            $category_id = $_GET["category"];
            $select_query = "SELECT * FROM `products` WHERE category_id = $category_id";
        $result_query = mysqli_query($con, $select_query);
        $num_of_rows = mysqli_num_rows($result_query);
        if($num_of_rows == 0){
            echo "<h2 class='text-center text-danger'>No products found in this category</h2>";
        }
        while ($row = mysqli_fetch_array($result_query)) {
            $product_id = $row["product_id"];
            $product_title = $row["product_title"];
            $product_description = $row["product_description"];
            $product_keywords = $row["product_keywords"];
            $product_image1 = $row["product_image1"];
            $product_price = $row["product_price"];
            $category_id = $row["category_id"];
            $brand_id = $row["brand_id"];
            echo "
            <div class='col-md-4 mb-4'>
              <div class='card h-100'>
                <img src='./admin/product_images/$product_image1' class='card-img-top' alt='$product_title' style='height: 250px; object-fit: cover;'>
                <div class='card-body'>
                  <h5 class='card-title'>$product_title</h5>
                  <p class='card-text'>$product_description</p>
                  <p class='card-text'><strong>Price:</strong> $product_price/-</p>
                  <div class='d-flex justify-content-center gap-2'>
                     <a href='index.php?add_to_cart=$product_id' class='btn btn-info'>Add to Cart</a>
                    <a href='product_details.php?product_id=$product_id' class='btn btn-secondary'>View Details</a>
                  </div>
                </div>
              </div>
            </div>";
        }
    }
}

    //getting unique brands
     function get_unique_brands($con) {
        global $con;

        //condition to check isset or not
        if (isset($_GET["brand"])) {
            $brand_id = $_GET["brand"];
            $select_query = "SELECT * FROM `products` WHERE brand_id = $brand_id";
            $result_query = mysqli_query($con, $select_query);

            // Debugging: Check for query execution errors
            if (!$result_query) {
                die("Query Failed: " . mysqli_error($con)); // Display error message
            }

            $num_of_rows = mysqli_num_rows($result_query); // Fixed syntax error
            if ($num_of_rows == 0) {
                echo "<h2 class='text-center text-danger'>No products found in this brand</h2>";
            }
            while ($row = mysqli_fetch_array($result_query)) {
                $product_id = $row["product_id"];
                $product_title = $row["product_title"];
                $product_description = $row["product_description"];
                $product_keywords = $row["product_keywords"];
                $product_image1 = $row["product_image1"];
                $product_price = $row["product_price"];
                $category_id = $row["category_id"];
                $brand_id = $row["brand_id"];
                echo "
                <div class='col-md-4 mb-4'>
                  <div class='card h-100'>
                    <img src='./admin/product_images/$product_image1' class='card-img-top' alt='$product_title' style='height: 250px; object-fit: cover;'>
                    <div class='card-body'>
                      <h5 class='card-title'>$product_title</h5>
                      <p class='card-text'>$product_description</p>
                      <p class='card-text'><strong>Price:</strong> $product_price/-</p>
                      <div class='d-flex justify-content-center gap-2'>
                         <a href='index.php?add_to_cart=$product_id' class='btn btn-info'>Add to Cart</a>
                        <a href='#' class='btn btn-secondary'>View Details</a>
                      </div>
                    </div>
                  </div>
                </div>";
            }
        }
    } // Added missing closing brace for the function

    //brand sidenav function
    function getbrands($con){
        global $con;
        $select_brands = "SELECT * FROM `brands`";
        $result_brands = mysqli_query($con, $select_brands);
        while ($row_data = mysqli_fetch_array($result_brands)) {
          $brand_title = $row_data['brand_title'];
          $brand_id = $row_data['brand_id'];
          echo "<li class='nav-item'>
                  <a href='index.php?brand=$brand_id' class='nav-link text-light'><h4>$brand_title</h4></a>
                </li>";
        }
    }

    //category sidenav function
    function getcategories($con){
        global $con;
        $select_categories = "SELECT * FROM `categories`";
        $result_categories = mysqli_query($con, $select_categories);
        while ($row_data = mysqli_fetch_array($result_categories)) {
          $category_title = $row_data['category_title'];
          $category_id = $row_data['category_id'];
          echo "<li class='nav-item'>
                  <a href='index.php?category=$category_id' class='nav-link text-light'><h4>$category_title</h4></a>
                </li>";
        }
    }

    // search products function
    function search_product($con) {
        if (isset($_GET['search_data_product'])) {
            $search_data = mysqli_real_escape_string($con, $_GET['search_data']); // Sanitize input

            // Corrected SQL query
            $query = "SELECT * FROM products WHERE product_title LIKE '%$search_data%' OR product_keywords LIKE '%$search_data%' OR product_description LIKE '%$search_data%'";
            $result = mysqli_query($con, $query);

            if (!$result) {
                die("Query Failed: " . mysqli_error($con)); // Debugging aid
            }

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $product_title = $row['product_title'];
                    $product_price = $row['product_price'];
                    $product_image1 = $row['product_image1'];
                    $product_id = $row['product_id'];

                    // Updated image path
                    echo "
                    <div class='col-md-4 mb-3'>
                        <div class='card'>
                            <img src='./admin/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                            <div class='card-body'>
                                <h5 class='card-title'>$product_title</h5>
                                <p class='card-text'>Price: $product_price/-</p>
                                <a href='product_details.php?product_id=$product_id' class='btn btn-primary'>View Details</a>
                            </div>
                        </div>
                    </div>";
                }
            } else {
                echo "<h5 class='text-center text-danger'>No results found for '$search_data'</h5>";
            }
        }
    }
    
    //view details function
    function view_details($con){
      global $con;

        //condition to check isset or not
        if(isset($_GET["product_id"])){
        if(!isset($_GET["category"])){
            if(!isset($_GET["brand"])){
                $product_id = $_GET["product_id"];
                $select_query = "SELECT * FROM `products` where product_id = $product_id";
                $result_query = mysqli_query($con, $select_query);
                while ($row = mysqli_fetch_array($result_query)) {
                    $product_id = $row["product_id"];
                    $product_title = $row["product_title"];
                    $product_description = $row["product_description"];
                    $product_keywords = $row["product_keywords"];
                    $product_image1 = $row["product_image1"];
                    $product_image2 = $row["product_image2"];
                    $product_image3 = $row["product_image3"];
                    $product_price = $row["product_price"];
                    $category_id = $row["category_id"];
                    $brand_id = $row["brand_id"];
                    echo "
                    <div class='col-md-4 mb-4'>
                      <div class='card h-100'>
                        <img src='./admin/product_images/$product_image1' class='card-img-top' alt='$product_title' style='height: 250px; object-fit: cover;'>
                        <div class='card-body'>
                          <h5 class='card-title'>$product_title</h5>
                          <p class='card-text'>$product_description</p>
                          <p class='card-text'><strong>Price:</strong> $product_price/-</p>
                          <div class='d-flex justify-content-center gap-2'>
                             <a href='index.php?add_to_cart=$product_id' class='btn btn-info'>Add to Cart</a>
                            <a href='product_details.php?product_id=$product_id' class='btn btn-secondary'>View Details</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                     <div class='col-md-8'>
        <div class='row'>
            <div class='col-md-12'>
                <h4 class='text-center text-info mb-5>Related Products</h4>
            </div>
            <div class='col-md-6'>
                <img src='./admin/product_images/$product_image2' class='card-img-top' alt='$product_title' style='height: 250px; object-fit: cover;'>
            </div>
            <div class='col-md-6'>
                <img src='./admin/product_images/$product_image3' class='card-img-top' alt='$product_title' style='height: 250px; object-fit: cover;'>
            </div>
        </div>
    </div>";
                }
            }
        }
    }

  }

  // get ip address function
function getIPAddress() {  
  //whether ip is from the share internet  
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  
      $get_ip_add = $_SERVER['HTTP_CLIENT_IP'];  
  }  
  //whether ip is from the proxy  
  elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
      $get_ip_add = $_SERVER['HTTP_X_FORWARDED_FOR'];  
  }  
  //whether ip is from the remote address  
  else {  
      $get_ip_add = $_SERVER['REMOTE_ADDR'];  
  }  
  return $get_ip_add;  
} 


// cart function
function cart() {
  if (isset($_GET['add_to_cart'])) {
      global $con;
      $get_ip_add = getIPAddress(); // Call without arguments
      $get_product_id = $_GET['add_to_cart'];

      // Check if the product is already in the cart
      $select_query = "SELECT * FROM `cart_details` WHERE `ip_address` = '$get_ip_add' AND `product_id` = $get_product_id";
      $result_query = mysqli_query($con, $select_query);

      if (!$result_query) {
          die("Error in SELECT query: " . mysqli_error($con)); // Debugging aid
      }

      $num_of_rows = mysqli_num_rows($result_query);

      if ($num_of_rows > 0) {
          // Item already exists in the cart
          echo "<script>alert('This item is already present in the cart')</script>";
          echo "<script>window.open('index.php', '_self')</script>";
      } else {
          // Add the item to the cart
          $insert_query = "INSERT INTO `cart_details` (`product_id`, `ip_address`, `quantity`) VALUES ($get_product_id, '$get_ip_add', 1)";
          $insert_result = mysqli_query($con, $insert_query);

          if (!$insert_result) {
              die("Error in INSERT query: " . mysqli_error($con)); // Debugging aid
          }

          echo "<script>alert('Item added to cart')</script>";
          echo "<script>window.open('index.php', '_self')</script>";
      }
  }
}
//function to get item numbers
function cart_item(){
  if(isset($_GET['add_to_cart'])){
    global $con;
    $get_ip_add = getIPAddress();
    
    $select_query="select * from `cart_details` where ip_address='$get_ip_add'"; 
   
    $result_query = mysqli_query($con, $select_query);
    $count_cart_items = mysqli_num_rows($result_query); 
  
  }else{
    global $con;
    $get_ip_add = getIPAddress();
    
    $select_query="select * from `cart_details` where ip_address='$get_ip_add'"; 
   
    $result_query = mysqli_query($con, $select_query);
    $count_cart_items = mysqli_num_rows($result_query); 
    }

    echo $count_cart_items;


  }

//total price function
function total_cart_price(){
  global $con;
  $get_ip_add = getIPAddress();
  $total_price=0;
  $cart_query="Select * from`cart_details` where ip_address='$get_ip_add'";
  $result=mysqli_query($con,$cart_query);
  while($row=mysqli_fetch_array($result)){
    $product_id=$row['product_id'];
    $select_products="Select * from `products` where product_id='$product_id'";
    $result_products=mysqli_query($con,$select_products);
    while($row_product_price=mysqli_fetch_array($result_products)){
  $product_price=array ($row_product_price['product_price']);
  $product_values=array_sum ($product_price);
  $total_price+= $product_values;


     }
  }
  echo $total_price;
}
?> 

