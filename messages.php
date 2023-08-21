<?php
/*
This page is a user page, it needs sign in ($_SESSION['user']) 
it show all adoption cases.
it has detail, and adoption request for each case
*/


session_start();
// $_SESSION['user']=11;
if (!isset($_SESSION['user'])) {
    header( "Location: user_auth/login.php");
} 

require_once 'db_connect.php';
require_once "public/functions.php";

$sql1 = "SELECT * FROM messages where receiver_id=".$_SESSION['user'];
$result = mysqli_query($connection ,$sql1);

$layer="";
$layer.="<div class='d-flex justify-content-center'><div class='grid-container-msg'>";

if(mysqli_num_rows($result) > 0){

    while($rows = mysqli_fetch_assoc($result)){

        $layer.="
            <div class='card' style='width: 26rem;'>
            <div class='card-body'>
            <h5 class='card-title'>Message Code: {$rows['id']}</h5>
            <p class='card-text'>{$rows['content']}
            </p>
            
            <a href='detail.php?detail={$rows['id']}' class='btn btn-primary'>i read message!</a>";
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