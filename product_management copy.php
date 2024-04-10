<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add/Edit Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Your CSS styles */
    </style>
</head>
<body>

<div class="container">
    <h2>Add/Edit Product</h2>
    <?php
    // Start session
    session_start();

    // Include common database connection
    require ("includes/common.php");

    // Check if the form is submitted for adding/editing product
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['action']) && $_POST['action'] == 'add') {
            // Add product
            addProduct($conn);
        } elseif(isset($_POST['action']) && $_POST['action'] == 'edit') {
            // Edit product
            editProduct($conn);
        }
    }

    // Function to add a product
    function addProduct($conn) {
        // Retrieve form data
        $name = $_POST['name'];
        $category = $_POST['category'];
        $price = $_POST['price'];

        // File upload handling
        $targetDir = "uploads/";
        $fileName = basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            // Allow certain file formats
            $allowTypes = array('jpg','png','jpeg','gif');
            if(in_array($fileType, $allowTypes)) {
                // Upload file to server
                if(move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                    // Insert product details into database
                    $sql = "INSERT INTO products (name, category, price, image) VALUES ('$name', '$category', '$price', '$fileName')";
                    if(mysqli_query($conn, $sql)) {
                        echo "<div class='alert alert-success' role='alert'>Product added successfully.</div>";
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>Error: " . $sql . "<br>" . mysqli_error($conn) . "</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Sorry, there was an error uploading your file.</div>";
                }
            } else {
                echo "<div class='alert alert-danger' role='alert'>Sorry, only JPG, JPEG, PNG, GIF files are allowed.</div>";
            }
        } else {
            echo "<div class='alert alert-danger' role='alert'>File is not an image.</div>";
        }
    }

    // Function to edit a product
    function editProduct($conn) {
        // Retrieve form data
        $id = $_POST['id'];
        $name = $_POST['name'];
        $category = $_POST['category'];
        $price = $_POST['price'];

        // Update product details in the database
        $sql = "UPDATE products SET name='$name', category='$category', price='$price' WHERE id=$id";
        if(mysqli_query($conn, $sql)) {
            echo "<div class='alert alert-success' role='alert'>Product updated successfully.</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error updating product: " . mysqli_error($conn) . "</div>";
        }
    }
    ?>

    <!-- Add/Edit Product Form -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="add"> <!-- Hidden field to indicate adding/editing product -->
        <input type="hidden" name="id" value="<?php echo isset($_GET['edit']) ? $_GET['edit'] : ''; ?>"> <!-- Hidden field for product ID when editing -->

        <div class="form-group">
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" class="form-control" value="<?php echo isset($_GET['edit']) ? getProductInfo($conn)['name'] : ''; ?>" required>
        </div>

        <div class="form-group">
    <label for="category">Category:</label>
    <select id="category" name="category" class="form-control" required>
        <option value="">Select category</option>
        <?php $productInfo = getProductInfo($conn); ?>
        <option value="watches" <?php echo (isset($_GET['edit']) && isset($productInfo['category']) && $productInfo['category'] == 'watches') ? 'selected' : ''; ?>>Watches</option>
        <option value="headwear" <?php echo (isset($_GET['edit']) && isset($productInfo['category']) && $productInfo['category'] == 'headwear') ? 'selected' : ''; ?>>Headwear</option>
        <option value="shoes" <?php echo (isset($_GET['edit']) && isset($productInfo['category']) && $productInfo['category'] == 'shoes') ? 'selected' : ''; ?>>Shoes</option>
        <option value="clothing" <?php echo (isset($_GET['edit']) && isset($productInfo['category']) && $productInfo['category'] == 'clothing') ? 'selected' : ''; ?>>Clothing</option>
    </select>
</div>


        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" class="form-control" value="<?php echo isset($_GET['edit']) ? getProductInfo($conn)['price'] : ''; ?>" required step="0.01">
        </div>

        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" id="image" name="image" class="form-control-file" accept="image/*" <?php echo isset($_GET['edit']) ? '' : 'required'; ?>>
        </div>

        <input type="submit" value="<?php echo isset($_GET['edit']) ? 'Edit Product' : 'Add Product'; ?>" class="btn btn-primary">
    </form>

    <!-- Display All Products -->
    <h2>All Products</h2>
    <div class="row">
    <?php
    $sql = "SELECT * FROM products";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo '<div class="col-md-4">';
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>'; // Use htmlspecialchars to escape special characters
            echo '<p class="card-text">Category: ' . htmlspecialchars($row['Category']) . '<br>price: RM' . htmlspecialchars($row['price']) . '</p>'; // Use htmlspecialchars to escape special characters
            // Display the image if it exists
            if (file_exists('uploads/' . $row['image'])) {
                echo '<img src="uploads/' . $row['image'] . '" class="card-img-top" alt="Product Image">';
            } else {
                echo '<img src="placeholder-image.jpg" class="card-img-top" alt="Product Image">'; // Use a placeholder image if the image file doesn't exist
            }
            echo '<a href="?edit=' . $row['id'] . '" class="btn btn-primary">Edit</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<div class="col-md-12">';
        echo '<div class="alert alert-warning" role="alert">No products found.</div>';
        echo '</div>';
    }
    ?>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Function to get product information by ID
function getProductInfo($conn) {
    if(isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $sql = "SELECT * FROM products WHERE id=$id";
        $result = mysqli_query($conn, $sql);
        return mysqli_fetch_assoc($result);
    }
}
?>
