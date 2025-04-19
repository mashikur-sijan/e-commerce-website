<!-- view_users.php -->
<?php
// Save this as view_users.php inside admin folder
include('../includes/connect.php');

echo "<h3 class='text-center text-success my-4'>All Registered Users</h3>";
$query = "SELECT * FROM user_table";
$result = mysqli_query($con, $query);

echo "<table class='table table-bordered text-center'>
<tr class='bg-info text-white'>
<th>User ID</th>
<th>Username</th>
<th>Email</th>
<th>Type</th>
<th>Status</th>
<th>Image</th>
<th>Address</th>
<th>Contact</th>
<th>Actions</th>
</tr>";

while ($row = mysqli_fetch_assoc($result)) {
    $status = $row['status'] ?? 'active';
    $buttonText = $status === 'blocked' ? 'Unblock' : 'Block';
    $buttonColor = $status === 'blocked' ? 'success' : 'warning';
    echo "<tr>
    <td>{$row['user_id']}</td>
    <td>{$row['username']}</td>
    <td>{$row['user_email']}</td>
    <td>{$row['user_type']}</td>
    <td><span class='badge bg-" . ($status === 'blocked' ? 'danger' : 'success') . "'>$status</span></td>
    <td><img src='../users_area/user_images/{$row['user_image']}' width='60'></td>
    <td>{$row['user_address']}</td>
    <td>{$row['user_mobile']}</td>
    <td>
        <a href='index.php?edit_user={$row['user_id']}' class='btn btn-primary btn-sm mb-1'>Edit</a><br>
        <a href='index.php?delete_user={$row['user_id']}' class='btn btn-danger btn-sm mb-1' onclick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a><br>
        <a href='index.php?toggle_block={$row['user_id']}' class='btn btn-$buttonColor btn-sm'>$buttonText</a>
    </td>
    </tr>";
}
echo "</table>";
?>