<?php
    include("../includes/connect.php");

    // Check if the database connection is successful

    if (!$con) {
        die("<script>alert('Database connection failed: " . mysqli_connect_error() . "')</script>");
    }
    if(isset($_POST['insert_product'])){
        $product_title = $_POST['product_title'];
        $product_description = $_POST['description'];
        $product_keywords = $_POST['product_keywords'];
        $category_id = $_POST['product_categories'];
        $brand_id = $_POST['product_brands'];
        $product_price = $_POST['product_price'];
        $product_image1 = $_FILES['product_image1']['name'];
        $product_image2 = $_FILES['product_image2']['name'];
        $product_image3 = $_FILES['product_image3']['name'];
        $product_image4 = $_FILES['product_image4']['name'];
        $product_image5 = $_FILES['product_image5']['name'];
        $temp_name1 = $_FILES['product_image1']['tmp_name'];
        $temp_name2 = $_FILES['product_image2']['tmp_name'];
        $temp_name3 = $_FILES['product_image3']['tmp_name'];
        $temp_name4 = $_FILES['product_image4']['tmp_name'];
        $temp_name5 = $_FILES['product_image5']['tmp_name'];
        
        // Check for empty fields

        if ($product_title == '' || $product_description == '' || $product_keywords == '' || $category_id == '' || $brand_id == '' || $product_price == '' || $product_image1 == '' || $product_image2 == '' || $product_image3 == '' || $product_image4 == '' || $product_image5 == '') {
            echo "<script>alert('Please fill all the fields')</script>";
            exit();
        } else {

            // Ensure the directory exists

            $upload_dir = "product_images/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Generate unique file names

            $product_image1 = uniqid() . "_" . $product_image1;
            $product_image2 = uniqid() . "_" . $product_image2;
            $product_image3 = uniqid() . "_" . $product_image3;
            $product_image4 = uniqid() . "_" . $product_image4;
            $product_image5 = uniqid() . "_" . $product_image5;

            // Move uploaded files

            move_uploaded_file($temp_name1, $upload_dir . $product_image1);
            move_uploaded_file($temp_name2, $upload_dir . $product_image2);
            move_uploaded_file($temp_name3, $upload_dir . $product_image3);
            move_uploaded_file($temp_name4, $upload_dir . $product_image4);
            move_uploaded_file($temp_name5, $upload_dir . $product_image5);

            $product_status = 'active'; // Define product status

            // Insert query

            $insert_query = "INSERT INTO `products` (product_title, product_description, product_keywords, category_id, brand_id, product_price, product_image1, product_image2, product_image3, product_image4, product_image5, date, status) 
                             VALUES ('$product_title', '$product_description', '$product_keywords', '$category_id', '$brand_id', '$product_price', '$product_image1', '$product_image2', '$product_image3', '$product_image4', '$product_image5', NOW(), '$product_status')";

            $result = mysqli_query($con, $insert_query);
            if ($result) {
                echo "<script>alert('Product has been inserted successfully')</script>";
            } else {

                // Display detailed error message for debugging

                die("<script>alert('Query failed: " . mysqli_error($con) . "')</script>");
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Products - Admin Dashboard</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../style.css">

</head>
<body class="bg-light">
    <div class="container mt-3">
        <h1 class="text-center">Insert Products</h1>

        <!-- Form -->
        <form action="" method="post" enctype="multipart/form-data">

            <!-- Title -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_title" class="form-label">Product Title</label>
                <input type="text" id="product_title" name="product_title" class="form-control" placeholder="Enter Product Title" autocomplete="off" required>
            </div>

            <!-- Description -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="description" class="form-label">Description</label>
                <input type="text" id="description" name="description" class="form-control" placeholder="Enter Product Description" autocomplete="off" required>
            </div>

            <!-- Keywords -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_keywords" class="form-label">Product Keywords</label>
                <input type="text" id="product_keywords" name="product_keywords" class="form-control" placeholder="Enter Product Keywords" autocomplete="off" required>
            </div>

            <!-- Categories -->
            <div class="form-outline mb-4 w-50 m-auto">
                <select name="product_categories" id="" class="form-select" required>
                    <option value="">Select a Category</option>
                    <?php
                        $select_query = "SELECT * FROM `categories`";
                        $result_query = mysqli_query($con, $select_query);
                        while ($row = mysqli_fetch_array($result_query)) {
                            $category_title = $row['category_title'];
                            $category_id = $row['category_id'];
                            echo "<option value='$category_id'>$category_title</option>";
                        }
                    ?>
                </select>
            </div>

            <!-- Brands -->
            <div class="form-outline mb-4 w-50 m-auto">
                <select name="product_brands" id="" class="form-select" required>
                    <option value="">Select a Brand</option>
                    <?php
                        $select_query = "SELECT * FROM `brands`";
                        $result_query = mysqli_query($con, $select_query);
                        while ($row = mysqli_fetch_array($result_query)) {
                            $brand_title = $row['brand_title'];
                            $brand_id = $row['brand_id'];
                            echo "<option value='$brand_id'>$brand_title</option>";
                        }
                    ?>
                </select>
            </div>

            <!-- Image 1 -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image1" class="form-label">Product Image 1</label>
                <input type="file" id="product_image1" name="product_image1" class="form-control" required>
            </div>

            <!-- Image 2 -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image2" class="form-label">Product Image 2</label>
                <input type="file" id="product_image2" name="product_image2" class="form-control" required>
            </div>

            <!-- Image 3 -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image3" class="form-label">Product Image 3</label>
                <input type="file" id="product_image3" name="product_image3" class="form-control" required>
            </div>

            <!-- Image 4 -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image4" class="form-label">Product Image 4</label>
                <input type="file" id="product_image4" name="product_image4" class="form-control" required>
            </div>

            <!-- Image 5 -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image5" class="form-label">Product Image 5</label>
                <input type="file" id="product_image5" name="product_image5" class="form-control" required>
            </div>

            <!-- Price -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_price" class="form-label">Product Price</label>
                <input type="text" id="product_price" name="product_price" class="form-control" placeholder="Enter Product Price" autocomplete="off" required>
            </div>
            
            <!-- Submit Button -->
            <div class="form-outline mb-4 w-50 m-auto text-center">
                <input type="submit" name="insert_product" class="btn btn-info mb-3 px-3" value="Insert Product">
            </div>
        </form>
    </div>
</body>
</html>