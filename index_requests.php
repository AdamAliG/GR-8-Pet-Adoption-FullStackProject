<?php
/*
This page is a admin page, it needs sign in ($_SESSION['adm']) 
it show all adoption requets from users with their status.
in this page you can filter requests depend on status
*/
session_start();
$_SESSION['adm']= 4;
if (!isset($_SESSION['adm'])) {
    header( "Location: login.php" );
} 
require_once 'public/components/db_connect.php';
require_once "public/functions.php";

if (isset($_GET['status'])) {
    $status = $_GET['status'];
} else {
    $status = "NO-Status";
}
if ($status!='NO-Status') {
    $sql = "SELECT *,pets.image as pimage,users.image as uimage,adoption_applications.status as status_req
            FROM adoption_applications 
            inner join users on (user_id = users.id)
            inner join pets on (pet_id = pets.id)
            where 
            adoption_applications.status = '$status'
            group BY
            adoption_applications.pet_id , adoption_applications.user_id ";
} else {
    $sql = "SELECT *,pets.image as pimage,users.image as uimage,adoption_applications.status as status_req
            FROM adoption_applications 
            inner join users on (user_id = users.id)
            inner join pets on (pet_id = pets.id)
            group BY
            adoption_applications.pet_id , adoption_applications.user_id ";
}




$result = mysqli_query($connect ,$sql);
$layer="";
$layer.="<div class='d-flex justify-content-center'><div class='grid-container'>";

if(mysqli_num_rows($result) > 0){

    while($rows = mysqli_fetch_assoc($result)){

        $layer.="
            <div class='card' style='width: 22rem;'>
            <img src='public/images/pet_images/{$rows['pimage']}' class='card-img-top' alt='...'>
            <div class='card-body'>
            <h5 class='card-title'>{$rows['name']}</h5>
            <p class='card-text'>
            Request From : {$rows['username']}
            <br>
            Request Status : <b>{$rows['status_req']}</b>";
            if ($rows['status_req']=='rejected') {
                $sql2="SELECT username,id from users where id = (select user_id from adoption_applications where status='approved' and  pet_id={$rows['pet_id']} ) ";
                // echo $sql2;
                // exit();
                $rows2=retreive_form_database($connect ,$sql2);
                if ($rows2) { 
                    $layer.="(adopted by: {$rows2['username']})";   
                }
            }
        $layer.="<br>
            Species : {$rows['species']}
            <br>
            Breed : {$rows['breed']}
            <br>
            age : {$rows['age']}
            </p>
            <a href='detail_request.php?detail={$rows['pet_id']}&user_id_req={$rows['user_id']}&status={$rows['status_req']}' class='btn btn-primary'>Request Details</a>
            </div>
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
    <div class="container">
    <div>
    <a href='index_requests.php' class='btn btn-success'>All Requests</a>
    <a href='index_requests.php?status=pending' class='btn btn-warning'>Pending Requests</a>
    <a href='index_requests.php?status=approved' class='btn btn-primary'>Approved Requests</a>
    <a href='index_requests.php?status=rejected' class='btn btn-danger'>Rejected Requests</a>
    </div>
        <?=$layer ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>