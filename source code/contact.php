<?php
include('includes/connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center text-info mb-4">Contact Us</h2>
        <form action="contact.php" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Your Name:</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Your Email:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message:</label>
                <textarea name="message" id="message" rows="5" class="form-control" required></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-info text-white">Send Message</button>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $name = mysqli_real_escape_string($con, $_POST['name']);
            $email = mysqli_real_escape_string($con, $_POST['email']);
            $message = mysqli_real_escape_string($con, $_POST['message']);

            $query = "INSERT INTO contact_messages (name, email, message, date_sent) VALUES ('$name', '$email', '$message', NOW())";
            if (mysqli_query($con, $query)) {
                echo "<div class='alert alert-success mt-3'>Message sent successfully!</div>";
            } else {
                echo "<div class='alert alert-danger mt-3'>Failed to send message. Try again.</div>";
            }
        }
        ?>
    </div>
</body>
</html>
