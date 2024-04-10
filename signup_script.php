<?php
require "includes/common.php";
session_start();

$email = $_POST['eMail'];
$email = mysqli_real_escape_string($conn, $email);

$pass = $_POST['password'];
$pass = mysqli_real_escape_string($conn, $pass);
$pass = md5($pass);

$first = $_POST['firstName'];
$first = mysqli_real_escape_string($conn, $first);

$last = $_POST['lastName'];
$last = mysqli_real_escape_string($conn, $last);

$query = "SELECT * from users where email_id='$email'";
$result = mysqli_query($conn, $query);
$num = mysqli_num_rows($result);
if ($num != 0) {

    $m = "Email Already Exists";
    header('location: index.php?error=' . $m);

} else {
    $quer = "INSERT INTO users(email_id,first_name,last_name,password) values('$email','$first','$last','$pass')";
    mysqli_query($conn, $quer);

    echo "New record has id: " . mysqli_insert_id($conn);
    $user_id = mysqli_insert_id($conn);
    $_SESSION['email'] = $email;
    $_SESSION['user_id'] = $user_id;
    header('location:products.php');
}
?>