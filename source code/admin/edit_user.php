<!-- edit_user.php -->
<?php
include('../includes/connect.php');

if (isset($_GET['edit_user'])) {
    $user_id = $_GET['edit_user'];
    $query = "SELECT * FROM user_table WHERE user_id=$user_id";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        echo "<h4 class='text-danger'>User not found!</h4>";
        return;
    }

    if (isset($_POST['update_user'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $type = $_POST['user_type'];
        $address = $_POST['address'];
        $mobile = $_POST['mobile'];

        mysqli_query($con, "UPDATE user_table SET username='$username', user_email='$email', user_type='$type', user_address='$address', user_mobile='$mobile' WHERE user_id=$user_id");
        echo "<script>alert('User updated successfully'); window.location='index.php?view_users';</script>";
    }
?>
<div class="container my-5">
    <h3 class="text-center mb-4 text-primary">Edit User</h3>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="<?= $row['username'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= $row['user_email'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">User Type</label>
            <select name="user_type" class="form-select">
                <option value="user" <?= $row['user_type'] == 'user' ? 'selected' : '' ?>>User</option>
                <option value="admin" <?= $row['user_type'] == 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="form-control" value="<?= $row['user_address'] ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Contact</label>
            <input type="text" name="mobile" class="form-control" value="<?= $row['user_mobile'] ?>">
        </div>
        <button type="submit" name="update_user" class="btn btn-success">Update</button>
    </form>
</div>
<?php } ?>