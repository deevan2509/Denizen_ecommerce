<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Delius Swash Caps' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Andika' rel='stylesheet'>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Andika', sans-serif;
            margin-bottom: 200px;
        }

        .container {
            max-width: 800px;
        }

        .card {
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease-in-out;
            border-radius: 10px;
        }

        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }

        .card-text {
            font-size: 1.2rem;
            color: #555;
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
?>
<br>
<br>
<!-- Admin Dashboard -->
<div class="container mt-5">
    <h2>Welcome, Admin!</h2>
    <br>
    <div class="row">
        <!-- Product Management -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Product Management</h5>
                    <p class="card-text">Add, edit, and delete products. Manage categories and inventory.</p>
                    <a href="product_management.php" class="btn btn-primary">Go to Product Management</a>
                </div>
            </div>
        </div>

        <!-- Order Management -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Order Management</h5>
                    <p class="card-text">View and process orders. Manage order fulfillment and returns.</p>
                    <a href="order_management.php" class="btn btn-primary">Go to Order Management</a>
                </div>
            </div>
        </div>

        <!-- Customer Management -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Customer Management</h5>
                    <p class="card-text">Manage customer accounts and communicate with customers.</p>
                    <a href="customer_management.php" class="btn btn-primary">Go to Customer Management</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Include footer
include("includes/footer.php");
?>

</body>
</html>
