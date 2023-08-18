<?php
/*
This page is a user page, it needs sign in ($_SESSION['user']) 
it show all adoption cases.
it has detail, and adoption request for each case
*/


session_start();
//$_SESSION['user']= 3;
if (!isset($_SESSION['user'])) {
    header( "Location: login.php");
} 

require_once 'db_connect.php';
require_once "public/functions.php";

$sql1 = "SELECT * FROM pets";
$result = mysqli_query($connection ,$sql1);

$layer="";
$layer.="<div class='d-flex justify-content-center'><div class='grid-container'>";

if(mysqli_num_rows($result) > 0){

    while($rows = mysqli_fetch_assoc($result)){

        $sql2="select id,status from adoption_applications where pet_id = {$rows['id']} and user_id = {$_SESSION['user']}";
        $rows2=retreive_form_database($connection ,$sql2);

        $layer.="
            <div class='card' style='width: 20rem;'>
            <img src='public/images/pet_images/{$rows['image']}' class='card-img-top' alt='...'>
            <div class='card-body'>
            <h5 class='card-title'>{$rows['name']}</h5>
            <p class='card-text'>Species : {$rows['species']}";

            if ($rows2) {

                switch ($rows2['status']) {
                    case "rejected":
                        $layer.="<br><span class='text-danger'>your request has rejected!</span>";
                        break;
                    case "pending":
                        $layer.="<br><span class='text-success'>your request is in progress!</span>";
                        break;
                    case "approved":
                        $layer.="<br><span class='text-primary'>you have adopted this pet!:)</span>";
                        break;
                }

            }
            $layer.="<br>
            Breed : {$rows['breed']}
            <br>
            age : {$rows['age']}
            </p>
            <a href='detail.php?detail={$rows['id']}' class='btn btn-primary'>Details</a>";
            if (!($rows['age'] == 'adopted') && !($rows2) ) {
                $layer.="<a href='detail.php?detail={$rows['id']}&adoption=yes' class='btn btn-success'>Adopt Me!</a>";
            }
        $layer.="</div>
            </div>";
    }
}

$layer.="</div></div>";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoption Cases</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="Public/components/css/main.css">
</head>
<body>
    <?=$layer ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>