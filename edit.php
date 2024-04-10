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

// Function to fetch product details by ID
function getProductDetails($conn, $productId) {
    $productId = mysqli_real_escape_string($conn, $productId);
    $sql = "SELECT * FROM products WHERE id = '$productId'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }
}

// Check if product ID is provided in the URL
if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    $productDetails = getProductDetails($conn, $productId);
    if (!$productDetails) {
        echo "<div class='alert alert-danger' role='alert'>Product not found.</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-danger' role='alert'>Product ID not provided.</div>";
    exit;
}

// Check if form is submitted for product update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    // Retrieve form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    // Update product in the database
    $sql = "UPDATE products SET name = '$name', category = '$category', price = '$price' WHERE id = '$productId'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        // Redirect to product list page
        header("Location: list_product.php");
        exit;
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error updating product.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<br>
<br>
<br>
<div class="container">
    <h2>Edit Product</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $productDetails['name']; ?>" required>
        </div>
        <div class="form-group">
            <label for="category">Category:</label>
            <input type="text" class="form-control" id="category" name="category" value="<?php echo $productDetails['category']; ?>" required>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" class="form-control" id="price" name="price" value="<?php echo $productDetails['price']; ?>" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<?php
// Include footer
include("includes/footer.php");
?>

</body>
</html>
