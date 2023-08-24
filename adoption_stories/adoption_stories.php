<?php

session_start();

require_once "../db_connect.php";
require_once "../file_upload.php";
require_once "../public/functions.php";

if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: ../user_auth/login.php");
}

$sql = "SELECT * FROM adoption_stories";
$result = mysqli_query($connection, $sql);

$cards = "";
$layout = "";
$addStory = "";

if (isset($_SESSION["admin"])) {
    $addStory .= "<a href='add_adoption_story.php' class='btn btn-warning btn-lg mt-5'>Add new Story</a>";
}

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $cards .=
            "<div>
                <div class='card' style='width: 26rem;'>
                    <img src='../public/images/story_images/{$row["photo"]}' class='card-img-top img-fluid' alt='...'>
                    <div class='card-body'>
                        <h5 class='card-title'>{$row["story"]}</h5>
                        <div class='row'>
                        <a href='details_adoption_story.php?id={$row["id"]}' class='btn btn-primary btn-sm'>Show Story</a>
                        </div>
                        <hr>";
        if (isset($_SESSION["admin"])) {
            $cards .= "<a href='edit_adoption_story.php?id={$row["id"]}' class='btn btn-warning btn-sm'>Edit Story</a>
                        <a href='delete_adoption_story.php?id={$row["id"]}' class='btn btn-danger btn-sm'>Delete Story</a>";
        }
        $cards .= "</div>
                </div>
            </div>";
    }
} else {
    $layout .= "No Results";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles.css">
    <title>Adoption Stories</title>
</head>

<body>
    <?php
    if (isset($_SESSION["user"])) {
        require_once "../navbar_sub.php";
    }
    if (isset($_SESSION["admin"])) {
        require_once "../navbar_admin_sub.php";
    }
    ?>

    <div class="container mt-5">
        <?= $addStory ?>
    </div>

    <div class="container w-100 mt-5">
        <div class="row row-cols-lg-3 row-cols-md-2 row-cols-sm-1 row-cols-xs-1">
            <?= $cards ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>