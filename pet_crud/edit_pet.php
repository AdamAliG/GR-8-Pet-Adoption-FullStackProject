<?php
require_once "../db_connect.php";
require_once "../file_upload.php";

$message = "";


if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    if (isset($_POST['update'])) {
        $name = $_POST['name'];
        $species = $_POST['species'];
        $description = $_POST['description'];
        $location = $_POST['location'];
        $breed = $_POST['breed'];
        $age = $_POST['age'];
        $size =  $_POST['size'];
        $status = $_POST['status'];

        if ($_FILES["pictures"]["error"] != UPLOAD_ERR_NO_FILE) {
            $image = fileUpload($_FILES["pictures"], 'pet');
            $query = "UPDATE pets SET name='$name', species='$species', description='$description', location='$location', breed='$breed', age='$age', image='$image[0]', size='$size', status='$status' WHERE id='$id'";
        } else {
            $query = "UPDATE pets SET name='$name', species='$species', description='$description', location='$location', breed='$breed', age='$age', size='$size', status='$status' WHERE id='$id'";
        }

        
        if ($connection->query($query)) {
            $message = "Pet updated successfully!";

            header("Refresh: 2; url= ../dashboard.php");
        } else {
            echo "Error updating pet!";
        }
    }

    
    $query = "SELECT * FROM pets WHERE id='$id'";
    $result = $connection->query($query);
    $pet = $result->fetch_assoc();

} else {
    echo "Invalid ID!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
    <style>
    body, html {
        height: 100%;
        margin: 0;
    }
    .custom-input-width {
    width: 100% !important;
}
    .centered-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
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

<h1 class="text-center">Edit Pet!</h1>

<div class="centered-container">
<div id="success-message" style="display: <?= ($message == "Pet updated successfully!") ? 'flex' : 'none'; ?>;">
    <h1 class="text-center"><?= $message; ?></h1>
</div>
<div style="display: <?= ($message == "Pet updated successfully!") ? 'none' : 'block'; ?>;">
  <form method="post" enctype="multipart/form-data">

  <label for="name" class="form-label">Name:</label>
    <input type="text" name="name" class="form-control custom-input-width" value="<?= $pet['name'] ?>">

    <label for="species" class="form-label">species:</label>
    <input type="text" name="species" class="form-control custom-input-width" value="<?= $pet['species'] ?>">

    <label for="description" class="form-label">Description: </label>
    <textarea name="description" class="form-control custom-input-width" ><?= $pet['description'] ?></textarea>

    <label for="Location" class="form-label">Location: </label>
    <input type="text" name="location" class="form-control custom-input-width" value="<?= $pet['location'] ?>">

    <label for="breed" class="form-label">Breed:</label>
<input type="text" name="breed" class="form-control custom-input-width" value="<?= $pet['breed'] ?>">


    <label for="status" class="form-label">status:</label>
    <input type="text" name="status" class="form-control custom-input-width" value="<?= $pet['status'] ?>">

    <label for="age" class="form-label">age:</label>
    <input type="text" name="age" class="form-control custom-input-width" value="<?= $pet['age'] ?>">

    <label for="pictures" class="form-label">image:</label>
    <input type="file" class="form-control custom-input-width" id="pictures" name="pictures">


    <label for="size" class="form-label">size:</label>
    <input type="text" name="size" class="form-control custom-input-width" value="<?= $pet['size'] ?>">

    <input type="submit" class="btn btn-info mt-5" name="update" value="Update">
</form>  
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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

