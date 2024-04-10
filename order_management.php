<?php
// Include common.php for database connection
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

// Fetch orders from the database
$sql = "SELECT * FROM users_products";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "<div class='alert alert-danger' role='alert'>Error: Unable to fetch orders from the database.</div>";
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h2>Order Management</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Product ID</th>
                    <th>Quantity</th>
                    <th>Order Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through each order and display in the table
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['user_id'] . "</td>";
                    echo "<td>" . (isset($row['product_id']) ? $row['product_id'] : 'N/A') . "</td>";
                    echo "<td>" . (isset($row['quantity']) ? $row['quantity'] : 'N/A') . "</td>";
                    echo "<td>" . (isset($row['order_date']) ? $row['order_date'] : 'N/A') . "</td>";
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

</body>
</html>
