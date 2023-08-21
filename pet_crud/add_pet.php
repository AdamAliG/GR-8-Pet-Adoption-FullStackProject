<?php

session_start(); 
//$_SESSION["admin"]=9;
if(!isset($_SESSION["admin"])){ 
    header("Location: login.php"); 
}

require_once "../db_connect.php";
require_once "../file_upload.php";

$message = "";  

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $species = $_POST['species'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $image = fileUpload($_FILES["image"],'pet');
    $size = $_POST['size'];
    $status = $_POST['status'];
    $added_by = $_SESSION["admin"];

    $query = "INSERT INTO pets (name, species, description, location, breed, status, age, image, size, added_by) VALUES ('$name', '$species','$description', '$location', '$breed', '$status', $age, '$image[0]', '$size', $added_by)";

    if($connection->query($query)) {
        $message = "Pet added successfully!";
        header("Refresh: 2; url=../dashboard.php");
    } else {
        $message = "Error adding pet!";
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Pet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles.css">
    <style>
    
    body, html {
        height: 100%;
        margin: 0;
    }

    .centered-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    
}
.custom-input-width {
    width: 100% !important;
}
    #success-message {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        width: 100%;
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0.5;
        transition: opacity 2s;
        
        
    }
</style>

</head>
<body>
    
<div class="centered-container">

<div id="success-message" style="display: <?php echo ($message == "Pet added successfully!") ? 'flex' : 'none'; ?>;">
    <h1 class="text-center"><?php echo $message; ?></h1>
</div>

<div style="display: <?php echo ($message == "Pet added successfully!") ? 'none' : 'block'; ?>;">
    <h3 class="text-center">Add Pet</h3>
        <form method="post" enctype="multipart/form-data">
            Name: <input type="text" name="name" class="form-control custom-input-width">
            Species: <select name="species" class="form-control custom-input-width">
                        <option value="dog">Dog</option>
                        <option value="cat" >Cat</option>
                        <option value="bird" >Bird</option>
                        <option value="hamster" >Hamster</option>
                        <option value="fish" >Fish</option>
                        <option value="other" >Other</option>
                    </select>
            Description: <textarea name="description" class="form-control custom-input-width" rows="5"></textarea>
            Location: <input type="text" name="location" class="form-control custom-input-width">
            Breed: <input type="text" name="breed" class="form-control custom-input-width">
            Status: <select name="status" class="form-control custom-input-width">
                        <option value="not adopted" selected>Not Adopted</option>
                        <option value="pending" disabled>Pending</option>
                        <option value="adopted" disabled>Adopted</option>
                    </select>
            Age: <input type="text" name="age" class="form-control custom-input-width">
            Image: <input type="file" class="form-control custom-input-width" id="image" name="image">
            Size: <select name="size" class="form-control custom-input-width">
                        <option value="small">Small</option>
                        <option value="medium">Medium</option>
                        <option value="big">Big</option>
                    </select>
                    <br>
            <input type="submit" name="submit" value="Add Pet">
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script>
    window.onload = function() {
        let successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(function() {
                successMessage.style.opacity = "1";
            }, 100);
        }
    };
</script>
</body>
</html>
