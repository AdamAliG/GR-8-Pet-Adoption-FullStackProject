<?php 
session_start();
require_once "../db_connect.php";
require_once "../public/functions.php";

if(isset($_SESSION['id'])) {
    $outgoing_id = $_SESSION['id'];
} else {
    die("Session 'id' is not set");
}
if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}

$user_id_to_chat_with = isset($_GET['id']) ? mysqli_real_escape_string($connection, $_GET['id']) : null;

if ($user_id_to_chat_with === null) {
    die("User ID not provided.");
}

$sql = "SELECT * FROM users WHERE id = '{$user_id_to_chat_with}'";
$result = mysqli_query($connection, $sql);

if (!$result) {
    die("Query Failed: " . mysqli_error($connection));
}

$row = mysqli_num_rows($result) > 0 ? mysqli_fetch_assoc($result) : null;
?>


<?php include_once "header.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles.css">
    
</head>
<body> 
<div class="container">
<?php
    if (isset($_SESSION["user"])) {
        require_once "../navbar_sub.php";
    }
    if (isset($_SESSION["admin"])) {
        require_once "../navbar_admin_sub.php";
    }
    ?>
<?php if ($row): ?>
    <img src="../public/images/user_images/<?php echo $row['pictures']; ?>" alt="">
    <div class="details">
        <span><?php echo $row['username']. " " . $row['role']; ?></span>
        <p><?php echo $row['is_approved']; ?></p>
    </div>

    <div class="search">
        <span class="text">Select a user to start chat</span>
        <input type="text" placeholder="Enter name to search...">
        <button><i class="fas fa-search"></i></button>
    </div>
    <div class="users-list"></div>
<?php else: ?>
    <p>User not found!</p>
<?php endif; ?>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script src="users.js"></script>
</body>
</html>

          
