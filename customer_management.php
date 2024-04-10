<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f2f2f2;
        }

        a {
            text-decoration: none;
            color: #007bff;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #0056b3;
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
$sql = "SELECT id, email_id, first_name, last_name, phone, registration_time, Account_Type FROM users";
$result = mysqli_query($conn, $sql);


if (!$result) {
    echo "<div class='alert alert-danger' role='alert'>Error: Unable to fetch products from the database.</div>";
} else {
?>
<br>
<br>
    <h1>Customer Management</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone</th>
                <th>Registration Time</th>
                <th>Account Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Include common.php to connect to the database
            require "includes/common.php";

            // Fetch user data from the database
            $query = "SELECT * FROM users";
            $result = mysqli_query($conn, $query);

            // Display user data in table rows
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['email_id'] . "</td>";
                echo "<td>" . $row['first_name'] . "</td>";
                echo "<td>" . $row['last_name'] . "</td>";
                echo "<td>" . $row['phone'] . "</td>";
                echo "<td>" . $row['registration_time'] . "</td>";
                echo "<td>" . $row['Account_Type'] . "</td>";
                echo "<td><a href='edit_user.php?id=" . $row['id'] . "'>Edit</a></td>";
                echo "</tr>";
            }

            // Close database connection
            mysqli_close($conn);
            ?>
        </tbody>
    </table>
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
