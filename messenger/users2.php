<?php
session_start();
require_once "../db_connect.php";
if(isset($_SESSION['id'])) {
    $outgoing_id = $_SESSION['id'];
} else {
    die("Session 'id' is not set");
}





$outgoing_id = mysqli_real_escape_string($connection, $outgoing_id);

$sql = "SELECT * FROM users WHERE NOT id = {$outgoing_id} ORDER BY id DESC";
$query = mysqli_query($connection, $sql);

if(!$query) {
    die("Error in the query: " . mysqli_error($connection));
}

$output = "";

if(mysqli_num_rows($query) == 0){
    $output .= "No users are available to chat";
} else {
    include_once "data.php";
}

echo $output;

?>

