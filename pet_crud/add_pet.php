<?php
require_once "../db_connect.php";

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $species = $_POST['species'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $image = $_POST['image'];
    $size =  $_POST['size'];
    

    $query = "INSERT INTO pets (name, species, description,  location, breed, status, age, image, size) VALUES ('$name', '$species','$description', '$location',  '$breed', '$age', '$image', '$size')";
    if($connection->query($query)) {
        echo "Pet added successfully!";
        header("Location: ../dashboard.php");

    } else {
        echo "Error adding pet!";
    }
}
?>

<form method="post">
    Name: <input type="text" name="name">
    Species: <input type="text" name="species">
    Description: <textarea name="description"></textarea>
    Location: <input type="text" name="location">
    breed: <input type="text" name="breed">
    status: <input type="text" name="status">
    age:    <input type="text" name="age">
    image:  <input type="text" name="image">
    size:   <input type="text" name="size">
    <input type="submit" name="submit" value="Add Pet">
</form>
