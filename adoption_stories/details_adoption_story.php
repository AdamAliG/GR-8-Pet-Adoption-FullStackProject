<?php

session_start();

// if (isset($_SESSION["user"])) {
//     header("Location: ../home.php");
// }

if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: ../login.php");
}

require_once "../db_connect.php";
require_once "../public/functions.php";

$id = $_GET["id"];

$sql = "SELECT * FROM adoption_stories WHERE id = $id";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles.css">
    <title>Details</title>
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
        <div class="card" style="width: 80rem;">
            <div class="card-body p-5">
                <div class="row">

                </div>
                <div class="row">
                    <div class="col">
                        <p><img src="../public/images/story_images/<?= $row["photo"] ?>" class="img-fluid rounded" width="400"></p>
                    </div>
                    <div class="col">
                        <p class="lead"><?= $row["story"] ?></p>
                        <hr>
                        <a href="adoption_stories.php" class="btn btn-warning">Show all stories</a>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>