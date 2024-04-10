<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
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
<!-- Product Management -->
<div class="container mt-5">
    <h2>Product Management</h2>
    <br>
    <div class="row">
        <!-- Add Product -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Add Product</h5>
                    <p class="card-text">Add a new product to the inventory.</p>
                    <a href="add_product.php" class="btn btn-primary">Add Product</a>
                </div>
            </div>
        </div>

        <!-- Edit Product -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Edit Product</h5>
                    <p class="card-text">Edit existing products in the inventory.</p>
                    <a href="list_product.php" class="btn btn-primary">Edit Product</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Include footer
include("includes/footer.php");
?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
