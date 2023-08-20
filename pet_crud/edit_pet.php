<?php
require_once "../db_connect.php";
require_once "../file_upload.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    if (isset($_POST['update'])) {
        $name = $_POST['name'];
        $species = $_POST['species'];
        $description = $_POST['description'];
        $location = $_POST['location'];
        $breed = $_POST['breed'];
        $age = $_POST['age'];
        $image = fileUpload($_FILES["pictures"],'pet');

        $size =  $_POST['size'];
        $status = $_POST['status'];

        $query = "UPDATE pets SET name='$name', species='$species', description='$description', location='$location', breed='$breed', age ='$age', image='$image[0]', size= '$size', status = '$status'  WHERE id='$id'";
        if ($connection->query($query)) {
            echo "Pet updated successfully!";
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
</head>
<body>

<h1 class="text-center">Edit Pet!</h1>

<div class="container">
  <form method="post" enctype="multipart/form-data">

  <label for="name" class="form-label">Name:</label>
    <input type="text" name="name" class="form-control" value="<?= $pet['name'] ?>">

    <label for="species" class="form-label">species:</label>
    <input type="text" name="species" class="form-control" value="<?= $pet['species'] ?>">

    <label for="description" class="form-label">Description: </label>
    <textarea name="description" class="form-control" ><?= $pet['description'] ?></textarea>

    <label for="Location" class="form-label">Location: </label>
    <input type="text" name="location" class="form-control" value="<?= $pet['location'] ?>">

    <label for="breed" class="form-label">Breed:</label>
<input type="text" name="breed" class="form-control" value="<?= $pet['breed'] ?>">


    <label for="status" class="form-label">status:</label>
    <input type="text" name="status" class="form-control" value="<?= $pet['status'] ?>">

    <label for="age" class="form-label">age:</label>
    <input type="text" name="age" class="form-control" value="<?= $pet['age'] ?>">

    <label for="pictures" class="form-label">image:</label>
    <input type="file" class="form-control w-25" id="pictures" name="pictures">


    <label for="size" class="form-label">size:</label>
    <input type="text" name="size" class="form-control" value="<?= $pet['size'] ?>">

    <input type="submit" class="btn btn-primary" name="update" value="Update">
</form>  
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

