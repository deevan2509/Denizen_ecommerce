<?php
require "includes/common.php";
session_start();
if (!isset($_SESSION['email'])) {
    header('location: index.php');
    exit(); // Add exit to stop further execution
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['checkout'])) {
    $user_id = $_SESSION['user_id'];

    // Retrieve cart items from session
    $cart_items = $_SESSION['cart'];

    // Loop through cart items and insert into database
    foreach ($cart_items as $item_id => $quantity) {
        $item_id = mysqli_real_escape_string($conn, $item_id);
        $quantity = mysqli_real_escape_string($conn, $quantity);
        
        // Insert the order into users_products table
        $insert_query = "INSERT INTO users_products (user_id, item_id, quantity, order_date, order_time) VALUES ('$user_id', '$item_id', '$quantity', CURRENT_DATE(), CURRENT_TIME())";
        mysqli_query($conn, $insert_query) or die(mysqli_error($conn));
    }
    
    // Clear the cart session after successful checkout
    unset($_SESSION['cart']);
    
    // Redirect to success page after checkout
    header('location: success.php');
    exit; // Added exit to prevent further execution
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DENIZEN | Online Shopping Site for Men</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Delius Swash Caps' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Andika' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'includes/header_menu.php'; ?>
<div class="d-flex justify-content-center">
    <div class="col-md-8 my-5 table-responsive p-5">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Item Number</th>
                    <th>Item Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $user_id = $_SESSION['user_id'];
                $query = "SELECT users_products.quantity, products.price AS Price, products.id, products.name AS Name FROM users_products JOIN products ON users_products.item_id = products.id WHERE users_products.user_id='$user_id' AND status='Added To Cart'";
                $result = mysqli_query($conn, $query);
                $total_price = 0;
                while ($row = mysqli_fetch_array($result)) {
                    $total = $row['Price'] * $row['quantity'];
                    $total_price += $total;
                    ?>
                    <tr>
                        <td><?php echo "#" . $row["id"]; ?></td>
                        <td><?php echo $row["Name"]; ?></td>
                        <td>RM <?php echo $row["Price"]; ?></td>
                        <td>
                            <!-- Dropdown menu to select quantity -->
                            <select onchange="updateQuantity(<?php echo $row['id']; ?>, this.value)">
                                <?php
                                // Display options for quantity selection
                                for ($i = 1; $i <= 10; $i++) {
                                    echo '<option value="' . $i . '"';
                                    if ($i == $row['quantity']) {
                                        echo ' selected';
                                    }
                                    echo '>' . $i . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                        <td>RM <?php echo $total; ?></td>
                        <td>
                            <a href="cart-remove.php?id=<?php echo $row['id']; ?>" class="remove_item_link">Remove</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan="4">Total</td>
                    <td>RM <?php echo $total_price; ?></td>
                    <td>
                        <!-- Changed form action to POST method -->
                        <form method="post" action="">
                            <button type="submit" name="checkout" class="btn btn-primary">Checkout</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- JavaScript to handle AJAX requests for updating quantity -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script>
function updateQuantity(itemId, newQuantity) {
    $.ajax({
        url: 'update_quantity.php', // Replace with your update quantity PHP script
        method: 'POST',
        data: { id: itemId, quantity: newQuantity },
        success: function(response) {
            // Handle success
            // You may update the UI if needed
            console.log('Quantity updated successfully.');
        },
        error: function(xhr, status, error) {
            // Handle error
            console.error('Error updating quantity:', error);
        }
    });
}
</script>

<?php include 'includes/footer.php'; ?>
</body>
</html>
