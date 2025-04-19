<?php
session_start();
session_unset();
session_destroy();
echo "<script>alert('You have been logged out successfully!'); window.location='../users_area/user_login.php';</script>";
exit();
?>
