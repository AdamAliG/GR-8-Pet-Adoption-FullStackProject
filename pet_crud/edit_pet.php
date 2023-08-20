<?php
require_once "../db_connect.php";


if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    if (isset($_POST['update'])) {
        $name = $_POST['name'];
        $species = $_POST['species'];
        $description = $_POST['description'];
        $location = $_POST['location'];
        $breed = $_POST['breed'];
        $age = $_POST['age'];
        $image = $_POST['image'];
        $size =  $_POST['size'];
       
        $query = "UPDATE pets SET name='$name', species='$species', description='$description', location='$location', breed='$breed', age ='$age', image=' $image', size= '$size'  WHERE id='$id'";
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

<form method="post">
    Name: <input type="text" name="name" value="<?= $pet['name'] ?>">
    Species: <input type="text" name="species" value="<?= $pet['species'] ?>">
    Description: <textarea name="description"><?= $pet['description'] ?></textarea>
    Location: <input type="text" name="location" value="<?= $pet['location'] ?>">
    breed: <input type="text" name="breed" value="<?= $pet['breed'] ?>">
    status: <input type="text" name="status" value="<?= $pet['status'] ?>">
    age:    <input type="text" name="age" value="<?= $pet['age'] ?>">
    image:  <input type="text" name="image" value="<?= $pet['image'] ?>">
    size:   <input type="text" name="size" value="<?= $pet['size'] ?>">
    <input type="submit" name="update" value="Update">
</form>
