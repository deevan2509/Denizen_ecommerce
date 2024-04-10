<?php
require("includes/common.php");

// Start session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract and sanitize input data
    $email = $_POST['lemail'];
    $email = mysqli_real_escape_string($conn, $email);

    $password = $_POST['lpassword'];
    $password = mysqli_real_escape_string($conn, $password);
    $password = md5($password);

    // Perform database query to authenticate user
    $query = "SELECT id, email_id, password, account_type FROM users WHERE email_id = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $query);
    $num = mysqli_num_rows($result);

    // Check if user exists and password is correct
    if ($num == 0) {
        // Redirect with error message if authentication fails
        $m = "Please enter correct E-mail id and Password";
        header('location: index.php?errorl=' . $m);
        exit;
    } else {
        // User authenticated successfully
        $row = mysqli_fetch_array($result);
        $_SESSION['email'] = $row['email_id'];
        $_SESSION['user_id'] = $row['id'];

        // Check the account type
        $account_type = $row['account_type'];
        if ($account_type == 'admin') {
            // Redirect to admin dashboard if user is admin
            $_SESSION['admin_logged_in'] = true;
            header('location: admin_dashboard.php');
            exit;
        } else {
            // Redirect to customer page for non-admin users
            header('location: products.php');
            exit;
        }
    }
}
?>
