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
if (isset($_GET['id']) && isset($_GET['msg'])) {
    if ($_GET['msg']=='read') {
        $sqlupdate = "UPDATE `messages` set `read_flag`='true' where id=".$_GET['id'];
        mysqli_query($connection ,$sqlupdate);
    }
    
} 



$sql1 = "SELECT * FROM messages where receiver_id=".$_SESSION['user']." order by id desc";
$result = mysqli_query($connection ,$sql1);

$layer="";
$layer.="<div>";

if(mysqli_num_rows($result) > 0){

    while($rows = mysqli_fetch_assoc($result)){

        $layer.="
            <div class='card' style='width: 26rem;'>
            
            <div class='card-body'>";
            if ($rows['read_flag'] == 'false') {
                $layer.="<img src='public/images/web_images/notification.png'  width='30' height='30'>";
            }
            $layer.="<h5 class='card-title'>Message Code: ".substr(hash('md5',$rows['id']),0,6)."</h5>
            <p class='card-text'>
            {$rows['timestamp']}
            <br>
            {$rows['content']}
            </p>";
            if ($rows['read_flag'] == 'false') {
                $layer.="<a href='messages.php?id={$rows['id']}&msg=read' class='btn btn-primary'>i read message!</a>";
            }
            else {
                $layer.="<h5 class='text-success'>message has read!</h5>";
            }
        $layer.="</div>
            </div>";
    }
}

$layer.="</div>";

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