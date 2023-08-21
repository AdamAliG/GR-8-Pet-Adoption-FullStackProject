<?php

session_start();

require_once "../db_connect.php";
require_once "../file_upload.php";

if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {
    header("Location: ../user_auth/login.php");
    exit;
}

// if (isset($_SESSION["user"]) || isset($_SESSION["admin"])) {
//     header("Location: ../home.php");
//     exit;
// }

if (isset($_POST["submit"])) {

    $story = $_POST["story"];
    $photo = fileUpload($_FILES["photo"], 'story');

    $sql = "INSERT INTO adoption_stories (story,photo) VALUES ('$story','$photo[0]')";

    if (mysqli_query($connection, $sql)) {
        echo "<div class='alert alert-success' role='alert'>
                    New story has been added, {$photo[1]}
                    </div>";
        header("refresh: 3; url = adoption_stories.php");
    } else {
        echo "<div class='alert alert-danger' role='alert'>
                    error found, {$photo[1]}
                    </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Add Adoption Story</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="../pictures/<?= $row["photo"] ?>" alt="user pic" width="30" height="24">
            </a>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="adoption_stories.php">Show adoption stories</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Add a new adoption story</h1>
        <form method="post" autocomplete="off" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label for="story" class="form-label">Story</label>
                <input type="text" class="form-control" id="story" aria-describedby="story" name="story" placeholder="Write your adoption story">
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Photo</label>
                <input type="file" class="form-control" id="photo" aria-describedby="photo" name="photo">
            </div>
            <button name="submit" type="submit" class="btn btn-warning">Add your story</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>