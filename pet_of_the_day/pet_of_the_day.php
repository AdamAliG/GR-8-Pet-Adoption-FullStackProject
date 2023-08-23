<?php
session_start();

require_once "../db_connect.php";
require_once "../public/functions.php";

if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: ../user_auth/login.php");
}

$sql = "SELECT * FROM pets ORDER BY RAND() LIMIT 1;";
$result = mysqli_query($connection, $sql);

$cards = "";
$layout = "";

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $cards .=
            "<div>
                <div class='card' style='width: 22rem;'>
                    <img src='../public/images/pet_images/{$row["image"]}' class='card-img-top img-fluid' alt='...'>
                    <div class='card-body'>
                        <h5 class='card-title'>{$row["name"]}</h5>
                        <p class='card-text'><strong>Species:</strong>{$row["species"]}</p>
                        <div class='row'>             
                        </div>
                        <hr>";

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
    <title>Pet of the day</title>
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
        <?php echo $cards ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>