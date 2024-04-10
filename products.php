<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DENIZEN | Online Shopping Site for Men</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >
    <link href='https://fonts.googleapis.com/css?family=Delius Swash Caps' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Andika' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<!--header -->
 <?php
include 'includes/header_menu.php';
include 'includes/check-if-added.php';
include 'includes/common.php';
?>


    
<!--header ends -->
<div class="container" style="margin-top:65px">
         <!--jumbutron start-->
        <div class="jumbotron text-center">
            <h1>DENIZEN</h1>
            <p>We have wide range of products for you. No need to hunt around, we have all in one place</p>
        </div>
        <!--jumbutron ends-->
        <!--breadcrumb start-->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Products</li>
            </ol>
        </nav>
        <!--breadcrumb end-->
    <hr/>

  <!--menu list-->   
  
    <?php
// SQL query to select data from the "products" table
$sql = "SELECT * FROM products";

// Execute the query
$result = $conn->query($sql);

// Check if any rows were returned
if ($result->num_rows > 0) {
    // Output data of each row
    $count = 0; // Initialize product count
    while($row = $result->fetch_assoc()) {
        // Access individual fields using $row['fieldname']
        if ($count % 4 == 0) {
            // Start a new row after every 4 products
            echo '<div class="row text-center">';
        }
        echo '<div class="col-md-3 col-6 py-2">';
        echo '<div class="card">';

        // Check if 'image_url' key exists in $row array
        if (isset($row["image"])) {
            // Convert BLOB data to base64 encoded string for embedding in HTML
            $imageData = base64_encode($row["image"]);
            // Generate the data URI for embedding image
            $imageSrc = 'data:image/jpeg;base64,' . $imageData;
            echo '<img src="images/' . $row["image"] . '" alt="' . $row["name"] . '" class="img-fluid pb-1">';
        } else {
            echo '<img src="default_image.jpg" alt="' . $row["name"] . '" class="img-fluid pb-1">';
            // If 'image' is missing, use a default image or provide a fallback
        }
        echo '<div class="figure-caption">';
        echo '<h6>' . $row["name"] . '</h6>';
        echo '<h6>Price: RM' . $row["price"] . '</h6>';

        // Add to cart button logic...
        if (!isset($_SESSION['email'])) {
            echo '<p><a href="index.php#login" role="button" class="btn btn-warning  text-white ">Add To Cart</a></p>';
        } else {
            if (check_if_added_to_cart($row["id"])) {
                echo '<p><a href="#" class="btn btn-warning  text-white" disabled>Added to cart</a></p>';
            } else {
                echo '<p><a href="cart-add.php?id=' . $row["id"] . '" name="add" value="add" class="btn btn-warning  text-white">Add to cart</a><p>';
            }
        }
        
        echo '</div>'; // Close figure-caption
        echo '</div>'; // Close card
        echo '</div>'; // Close col-md-3

        $count++; // Increment product count

        if ($count % 4 == 0) {
            // Close the row after every 4 products
            echo '</div>'; // Close row
        }
    }

    // If the number of products is not a multiple of 4, close the row
    if ($count % 4 != 0) {
        echo '</div>'; // Close row
    }
} else {
    echo "0 results";
}
?>


      <!--menu list ends-->
      <!-- footer-->
        <?php include 'includes/footer.php'?>
      <!--footer ends-->
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
  $('[data-toggle="popover"]').popover();
});
</script>
<?php if (isset($_GET['error'])) {$z = $_GET['error'];
    echo "<script type='text/javascript'>
$(document).ready(function(){
$('#signup').modal('show');
});
</script>";
    echo "<script type='text/javascript'>alert('" . $z . "')</script>";}?>
<?php if (isset($_GET['errorl'])) {$z = $_GET['errorl'];
    echo "<script type='text/javascript'>
$(document).ready(function(){
$('#login').modal('show');
});
</script>";
    echo "<script type='text/javascript'>alert('" . $z . "')</script>";}?>
</html>
