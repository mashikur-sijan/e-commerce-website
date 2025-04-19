<?php
include('../includes/connect.php');
$query = "SELECT * FROM brands";
$result = mysqli_query($con, $query);
?>

<h3 class="text-center">All Brands</h3>
<table class="table table-bordered table-striped text-center mt-3">
    <thead class="table-info">
        <tr>
            <th>#</th>
            <th>Brand Title</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>{$i}</td>
                <td>{$row['brand_title']}</td>
            </tr>";
            $i++;
        }
        ?>
    </tbody>
</table>
