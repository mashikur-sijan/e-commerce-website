<?php
session_start();
include("./includes/connect.php");
include("./functions/common_function.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

// Fetch user details
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM user_table WHERE user_id = '$user_id'";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
        <a class="navbar-brand" href="#">Welcome, <?php echo $user['username']; ?></a>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="user_logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="container mt-4">
        <!-- Dashboard Sidebar -->
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <button class="list-group-item list-group-item-action" id="view-profile">View Profile</button>
                    <button class="list-group-item list-group-item-action" id="update-profile">Update Profile</button>
                    <button class="list-group-item list-group-item-action" id="confirm-payment">Confirm Payment</button>
                    <button class="list-group-item list-group-item-action" id="delete-account">Delete Account</button>
                </div>
            </div>

            <!-- Content Area -->
            <div class="col-md-9" id="dashboard-content">
                <!-- Dynamic Content Will Be Loaded Here -->
                <h3>Welcome to your Dashboard</h3>
                <p>Select an option from the sidebar to begin.</p>
                <!-- Back Button -->
                <br><a href="index.php" class="btn btn-secondary">Back to Homepage</a>
            </div>
        </div>
    </div>

    <script>
        // Function to load the user profile and dynamic content
        function loadContent(action) {
            $.ajax({
                url: 'user_dashboard_content.php',
                method: 'GET',
                data: { action: action },
                success: function(response) {
                    $('#dashboard-content').html(response);
                    // Add Back Button to each content
                    $('#dashboard-content').append('<br><a href="index.php" class="btn btn-secondary">Back to Homepage</a>');
                }
            });
        }

        // Event listeners for sidebar buttons
        $('#view-profile').on('click', function() {
            loadContent('view-profile');
        });

        $('#update-profile').on('click', function() {
            loadContent('update-profile');
        });

        $('#confirm-payment').on('click', function() {
            loadContent('confirm-payment');
        });

        $('#delete-account').on('click', function() {
            loadContent('delete-account');
        });
    </script>
</body>
</html>
