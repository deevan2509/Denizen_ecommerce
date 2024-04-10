<?php
require "includes/common.php";

// Initialize response array
$response = array();

// Check if the request is made using POST method
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if item ID and quantity are provided
    if (isset($_POST['id']) && isset($_POST['quantity'])) {
        $item_id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
        $new_quantity = filter_var($_POST['quantity'], FILTER_SANITIZE_NUMBER_INT);

        // Ensure quantity is a positive integer
        if ($new_quantity > 0) {
            // Prepare the SQL statement
            $user_id = $_SESSION['user_id'];
            $query = "UPDATE users_products SET quantity=? WHERE user_id=? AND item_id=?";
            $stmt = $conn->prepare($query);

            if ($stmt) {
                // Bind the parameters
                $stmt->bind_param("iii", $new_quantity, $user_id, $item_id);

                // Execute the statement
                $result = $stmt->execute();

                if ($result) {
                    // Quantity updated successfully
                    $response['status'] = 'success';
                    $response['message'] = 'Quantity updated successfully.';
                } else {
                    // Error updating quantity
                    $response['status'] = 'error';
                    $response['message'] = 'Error updating quantity: ' . $conn->error;
                }

                // Close the statement
                $stmt->close();
            } else {
                // Error preparing the statement
                $response['status'] = 'error';
                $response['message'] = 'Error preparing the statement: ' . $conn->error;
            }
        } else {
            // Invalid quantity provided
            $response['status'] = 'error';
            $response['message'] = 'Invalid quantity provided.';
        }
    } else {
        // ID or quantity not provided
        $response['status'] = 'error';
        $response['message'] = 'Item ID or quantity not provided.';
    }
} else {
    // Request method is not POST
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
}

// Close the database connection
$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
