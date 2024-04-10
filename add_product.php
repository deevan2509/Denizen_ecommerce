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

// Define variables and initialize with empty values
$name = $price = $category = "";
$name_err = $price_err = $category_err = "";

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate product name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter the product name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate price
    if (empty(trim($_POST["price"]))) {
        $price_err = "Please enter the product price.";
    } elseif (!is_numeric(trim($_POST["price"]))) {
        $price_err = "Please enter a valid price.";
    } else {
        $price = trim($_POST["price"]);
    }

    // Validate category
    if (empty(trim($_POST["category"]))) {
        $category_err = "Please select a category.";
    } else {
        $category = trim($_POST["category"]);
    }

    // Check input errors before inserting into database
    if (empty($name_err) && empty($price_err) && empty($category_err)) {
        // Upload image
        $targetDir = "images/";
        $fileName = basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            // Allow certain file formats
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
            if (in_array($fileType, $allowTypes)) {
                // Upload file to server
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                    // Insert product details into database
                    $sql = "INSERT INTO products (name, category, price, image) VALUES (?, ?, ?, ?)";
                    if ($stmt = mysqli_prepare($conn, $sql)) {
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "ssds", $param_name, $param_category, $param_price, $param_image);

                        // Set parameters
                        $param_name = $name;
                        $param_category = $category;
                        $param_price = $price;
                        $param_image = $fileName;

                        // Attempt to execute the prepared statement
                        if (mysqli_stmt_execute($stmt)) {
                            // Product added successfully
                            header("location: list_product.php");
                            exit;
                        } else {
                            echo "Oops! Something went wrong. Please try again later.";
                        }

                        // Close statement
                        mysqli_stmt_close($stmt);
                    }
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                echo "Sorry, only JPG, JPEG, PNG, GIF files are allowed.";
            }
        } else {
            echo "File is not an image.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

        /* Adjust the font for form elements */
        form {
            font-family: 'Andika', sans-serif;
        }   

        /* Adjust the position of the form */
        .add-product-form {
            margin-top: 50px;
        }
    </style>
</head>
<body>
<br>
<br>
<br>
<div class="container">
    <h2>Add Product</h2>

    <!-- Add Product Form -->
    <form class="add-product-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" class="form-control" value="<?php echo $name; ?>" required>
            <span class="text-danger"><?php echo $name_err; ?></span>
        </div>

        <div class="form-group">
            <label for="category">Category:</label>
            <select id="category" name="category" class="form-control" required>
                <option value="" disabled selected>Select category</option>
                <option value="watches">Watches</option>
                <option value="headphones">headphones</option>
                <option value="shoes">Shoes</option>
                <option value="clothing">Clothing</option>
            </select>
            <span class="text-danger"><?php echo $category_err; ?></span>
        </div>

        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" class="form-control" value="<?php echo $price; ?>" required step="0.01">
            <span class="text-danger"><?php echo $price_err; ?></span>
        </div>

        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" id="image" name="image" class="form-control-file" accept="image/*" required>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Add Product">
            <a href="admin_dashboard.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
