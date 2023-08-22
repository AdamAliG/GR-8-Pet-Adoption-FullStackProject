<?php

session_start();

// if (isset($_SESSION["user"])) {
//     header("Location: ../home.php");
// }

if (!isset($_SESSION["admin"])) {
    header("Location: ../login.php");
}

require_once "../db_connect.php";
require_once "../file_upload.php";


if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    if (isset($_POST['update'])) {
        $story = $_POST['story'];
        var_dump($_FILES);
        if (isset($_FILES["photo"])) {
            $photo = fileUpload($_FILES["photo"], 'story');
            $query = "UPDATE adoption_stories SET story='$story', photo='$photo[0]' WHERE id='$id'";
        } else {
            $query = "UPDATE adoption_stories SET story='$story' WHERE id='$id'";
        }

        if ($connection->query($query)) {
            echo "Story was updated.";
            header("Location: adoption_stories.php");
        } else {
            echo "Story not updated!";
        }
    }


    $query = "SELECT * FROM adoption_stories WHERE id='$id'";
    $result = $connection->query($query);
    $stories = $result->fetch_assoc();
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Shelter</title>
</head>

<body>
<?php
if (isset($_SESSION["user"])){ 
require_once "../navbar_sub.php";
}
if (isset($_SESSION["admin"])){ 
    require_once "../navbar_admin_sub.php";
}
?>

    <div class="container mt-5">
        <form class="form-group" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label" for="story">Adoption Story</label>
                <input class="form form-control" type="text" name="story" id="story" value="<?= $stories['story'] ?>">
            </div>
            <div class="mb-3">
                <label class="form-label" for="story">Story Image</label>
                <input class="form form-control" type="file" name="photo" id="photo" value="<?= $stories['photo'] ?>">
            </div>
            <input class="btn btn-primary" type="submit" name="update" value="Update Story">
            <input class="btn btn-danger" type="submit" name="delete" value="Delete Story">
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>