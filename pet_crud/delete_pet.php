<?php
session_start();
require_once "../db_connect.php";

$message = "";  

if(isset($_GET['id']) && is_numeric($_GET['id'])) {

    $pet_id = $_GET['id'];
    $query = "DELETE FROM pets WHERE id = $pet_id";
    if($connection->query($query)) {
        $message = "Pet deleted successfully!";
    } else {
        $message = "Error deleting pet: " . $connection->error;
    }
} else {
    $message = "Invalid request.";
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Pet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles.css">
    <style>
    body, html {
        height: 100%;
        margin: 0;
    }
    .centered-container {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        opacity: 0.5;
        transition: opacity 1s;
    }
</style>
</head>
<body>

<div class="centered-container">
    <h1 class="text-center"><?php echo $message; ?></h1>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script>
    setTimeout(function() {
        window.location.href = '../dashboard.php';
    }, 2000);  
    window.onload = function() {
        document.querySelector('.centered-container').style.opacity = "1";
    }
</script>

</body>
</html>
