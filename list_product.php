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

// Function to delete a product
function deleteProduct($conn, $productId) {
    $productId = mysqli_real_escape_string($conn, $productId);
    $sql = "DELETE FROM products WHERE id = '$productId'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

// Check if delete action is requested
if (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['id'])) {
    $productId = $_POST['id'];
    if (deleteProduct($conn, $productId)) {
        echo "success";
        exit;
    } else {
        echo "error";
        exit;
    }
}

// Fetch products from the database
$sql = "SELECT id, name, category, price, image FROM products";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "<div class='alert alert-danger' role='alert'>Error: Unable to fetch products from the database.</div>";
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Products</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Delius Swash Caps' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Andika' rel='stylesheet'>
    <style>
        /* CSS styles */
        .product-image {
            max-width: 100px; /* Adjust the maximum width as needed */
            height: auto;
        }
    </style>
</head>
<body>

<br>
<br>
<br>
<div class="container">
    <h2>List of Products</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Action</th> <!-- New column for action buttons -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through each product and display in the table
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['category'] . "</td>";
                    echo "<td>RM" . $row['price'] . "</td>";
                    // Check if the image path is correct
                    $imagePath = 'images/' . $row['image'];
                    echo "<td><img src='$imagePath' alt='Product Image' class='img-fluid product-image'></td>";
                    // Delete and edit buttons
                    echo "<td>";
                    echo "<button class='btn btn-danger' onclick='deleteProduct(" . $row['id'] . ")'>Delete</button> ";
                    echo "<button class='btn btn-primary' onclick='editProduct(" . $row['id'] . ")'>Edit</button>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
}

// Include footer
include("includes/footer.php");
?>

<!-- jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // JavaScript function to handle product deletion
    function deleteProduct(productId) {
        if (confirm("Are you sure you want to delete this product?")) {
            // AJAX request to delete product
            $.ajax({
                type: "POST",
                url: "list_product.php",
                data: {
                    action: "delete",
                    id: productId
                },
                success: function(response) {
                    if (response === "success") {
                        // Reload the page after deletion
                        location.reload();
                    } else {
                        alert("OK");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // Log any error messages to the console
                    alert("An error occurred while processing your request. Please try again later.");
                }
            });
        }
    }

    // JavaScript function to handle product editing
    function editProduct(productId) {
        // Redirect to edit_product.php with the product ID
        window.location.href = "edit.php?id=" + productId;
    }
</script>

</body>
</html>
