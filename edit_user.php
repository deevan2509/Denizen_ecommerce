<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Delius Swash Caps' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Andika' rel='stylesheet'>
    <style>
        /* CSS styles */
        body {
            background-color: #f4f4f4;
            font-family: 'Andika', sans-serif;
            margin-bottom: 200px;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>

<?php
// Include the common.php file to connect to the database and other common functionalities
require("includes/common.php");

// Start session
session_start();

// Check if admin is logged in, redirect to login page if not
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login_script.php");
    exit;
}

// Include header
include("includes/admin_header_menu.php");

// Initialize variables to hold user details
$user_id = '';
$email_id = '';
$first_name = '';
$last_name = '';
$phone = '';
$account_type = '';

// Check if user id is provided in the URL
if (isset($_GET['id'])) {
    // Sanitize and validate the user id
    $user_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Fetch user details from the database based on user id
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        // Fetch user details
        $row = $result->fetch_assoc();
        $email_id = $row['email_id'];
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $phone = $row['phone'];
        $account_type = $row['Account_Type'];
    } else {
        // User not found, redirect to customer management page
        header("Location: customer_management.php");
        exit;
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form inputs
    $email_id = filter_var($_POST["email_id"], FILTER_SANITIZE_EMAIL);
    $first_name = filter_var($_POST["first_name"], FILTER_SANITIZE_STRING);
    $last_name = filter_var($_POST["last_name"], FILTER_SANITIZE_STRING);
    $phone = filter_var($_POST["phone"], FILTER_SANITIZE_STRING);
    $account_type = filter_var($_POST["account_type"], FILTER_SANITIZE_STRING);

    // Update user details in the database
    $query = "UPDATE users SET email_id = ?, first_name = ?, last_name = ?, phone = ?, Account_Type = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $email_id, $first_name, $last_name, $phone, $account_type, $user_id);

    if ($stmt->execute()) {
        // Redirect to customer management page after successful update
        header("Location: customer_management.php");
        exit;
    } else {
        // Error occurred during update
        echo "<div class='alert alert-danger' role='alert'>Error updating user details.</div>";
    }
}
?>

<h1>Edit User</h1>

<!-- Edit user form -->
<form method="POST">
    <div class="form-group">
        <label for="email_id">Email:</label>
        <input type="email" class="form-control" id="email_id" name="email_id" value="<?php echo $email_id; ?>" required>
    </div>
    <div class="form-group">
        <label for="first_name">First Name:</label>
        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $first_name; ?>" required>
    </div>
    <div class="form-group">
        <label for="last_name">Last Name:</label>
        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $last_name; ?>" required>
    </div>
    <div class="form-group">
        <label for="phone">Phone:</label>
        <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo $phone; ?>" required>
    </div>
    <div class="form-group">
        <label for="account_type">Account Type:</label>
        <select class="form-control" id="account_type" name="account_type" required>
            <option value="admin" <?php if ($account_type == 'admin') echo 'selected'; ?>>Admin</option>
            <option value="User" <?php if ($account_type == 'User') echo 'selected'; ?>>User</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>

<?php
// Include footer
include("includes/footer.php");
?>

</body>
</html>
