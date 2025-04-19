<?php
include('../includes/connect.php');

// Delete logic
if (isset($_GET['delete_product'])) {
    $delete_id = $_GET['delete_product'];

    $get_img_query = mysqli_query($con, "SELECT product_image1 FROM products WHERE product_id = $delete_id");
    $img_data = mysqli_fetch_assoc($get_img_query);
    $image_path = "../admin/product_images/" . $img_data['product_image1'];
    if (file_exists($image_path)) {
        unlink($image_path);
    }

    $delete_query = "DELETE FROM products WHERE product_id = $delete_id";
    $run_delete = mysqli_query($con, $delete_query);

    if ($run_delete) {
        echo "<script>alert('Product deleted successfully'); window.location='index.php';</script>";
        exit();
    }
}

$query = "SELECT * FROM products";
$result = mysqli_query($con, $query);
?>

<h3 class="text-center">All Products</h3>
<table class="table table-bordered table-striped text-center mt-3">
    <thead class="table-info">
        <tr>
            <th>#</th>
            <th>Product Title</th>
            <th>Image</th>
            <th>Price</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            $product_id = $row['product_id'];
            echo "<tr>
                <td>{$i}</td>
                <td>{$row['product_title']}</td>
                <td><img src='../admin/product_images/{$row['product_image1']}' width='70'></td>
                <td>Tk {$row['product_price']}</td>
                <td>" . ucfirst($row['status']) . "</td>
                <td>
                    <a href='view_products.php?delete_product=$product_id' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this product?');\">
                        <i class='fas fa-trash-alt'></i> Delete
                    </a>
                </td>
            </tr>";
            $i++;
        }
        ?>
    </tbody>
</table>
