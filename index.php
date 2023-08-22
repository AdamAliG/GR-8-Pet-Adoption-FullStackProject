<?php
/*
This page is a user page, it needs sign in ($_SESSION['user']) 
it show all adoption cases.
it has detail, and adoption request for each case
*/


session_start();
//$_SESSION['user']= 3;
if (!isset($_SESSION['user'])) {
    header( "Location: user_auth/login.php");
} 

require_once 'db_connect.php';
require_once "public/functions.php";

$userId = intval($_SESSION["user"]); 
$sql = "SELECT * FROM users WHERE id = $userId";
$result = mysqli_query($connection, $sql);
$userRow = mysqli_fetch_assoc($result);


$sql1 = "SELECT * FROM pets";
$result = mysqli_query($connection ,$sql1);

$layer="";
$layer.="<div class='d-flex justify-content-center'><div class='grid-container'>";

if(mysqli_num_rows($result) > 0){

    while($rows = mysqli_fetch_assoc($result)){

        $flag=false;

        $sql2="select id,status from adoption_applications where status !='approved' and pet_id = {$rows['id']} and user_id != {$_SESSION['user']} and pet_id in (select pet_id from foster_to_adopt where pet_id = {$rows['id']} and status='in_progress' and user_id != {$_SESSION['user']} )";
        $rows2=retreive_form_database($connection ,$sql2);
        // if ($rows['id']==9) {
        //     echo isset($rows2);
        //     exit();
        // } 
        $sql3="select id,status from adoption_applications where pet_id = {$rows['id']} and user_id = {$_SESSION['user']} ";
        $rows3=retreive_form_database($connection ,$sql3);

        $sql4="select * from foster_to_adopt where pet_id = {$rows['id']} and user_id = {$_SESSION['user']}  and status='in_progress' ";
        $rows4=retreive_form_database($connection ,$sql4);

        $layer.="
            <div class='card' style='width: 20rem;'>
            <img src='public/images/pet_images/{$rows['image']}' class='card-img-top' alt='...'>
            <div class='card-body'>
            <h5 class='card-title'>{$rows['name']}</h5>
            <p class='card-text'>Species : {$rows['species']}";

            if (($rows3) && (!$rows4)) {
                $flag=true;
                switch ($rows3['status']) {
                    case "rejected":
                        $layer.="<br><span class='text-danger'>your request for {$rows['name']} has rejected!</span>";
                        break;
                    case "pending":
                        $layer.="<br><span class='text-success'>your request for {$rows['name']} is in progress!</span>";
                        break;
                    case "approved":
                        $layer.="<br><span class='text-primary'>you have adopted {$rows['name']}!:)</span>";
                        break;
                }
            }
            if ($rows4) {
                $layer.="<br><span class='text-success'>in Foster-to-Adopt process by you! have a good time!:)</span>";
            }
            if ($rows2) {
                $layer.="<br><span class='text-primary'>in Foster-to-Adopt process by another applicant!wait a little!:)</span>";
            } 
            $layer.="<br>
            Breed : {$rows['breed']}
            <br>
            age : {$rows['age']}
            </p>
            <a href='detail.php?detail={$rows['id']}' class='btn btn-primary'>Details</a>";
            if (!$rows2 && !$rows4 && !$flag) {
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
<?php
require_once "navbar.php";
?> 
    <?=$layer ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>