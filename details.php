<?php
  
session_start(); 

if(!isset($_SESSION["user"]) && !isset($_SESSION["admin"])){ 
    header("Location: user_auth/login.php"); 
}


  
require_once "db_connect.php";
require_once "public/functions.php";

$pet_id = 0;
$adoption = False;
$adoption_confirm = False;
$layout = "";

if (isset($_GET['detail'])) {

    $pet_id = $_GET['detail'];

} 
if (isset($_GET['adoption'])) {

    if ($_GET['adoption'] == "yes") {

        $adoption = True;
    }

} else if (isset($_GET['pet_id'])) {

    $pet_id = intval($_GET['pet_id']);

}

    $sql = "SELECT * FROM pets WHERE id = $pet_id";
    $result = mysqli_query($connection, $sql); 

    $row = mysqli_fetch_assoc($result);

    if (isset($_SESSION["user"])){ 
    $userId = intval($_SESSION["user"]); 
    $usersql = "SELECT * FROM users WHERE id = {$_SESSION["user"]}";
    $result = mysqli_query($connection, $usersql);
    $userrow = mysqli_fetch_assoc($result);
    }



    if (isset($_GET['pet_id']))  {

        $sql1 = "INSERT INTO `adoption_applications`(`user_id`, `pet_id`, `application_date`) VALUES ($userId,$pet_id,NOW())";
        $sql2 = "UPDATE `pets` SET `status`='pending' WHERE id =".$pet_id;

        $sqlpet="select name from pets where id =$pet_id";
        $pet_name=retreive_form_database($connection ,$sqlpet);

        $sender=9;
        $receiver_id=$_SESSION['user'];
        $msg="You have sent an adoption request for <a href='detail.php?detail=$pet_id'>".$pet_name['name']."</a> wait for our contact!";
        $msg=addslashes($msg);

        $sqlmsg = "INSERT INTO `messages` (`sender_id`, `receiver_id`, `content`, `timestamp`) VALUES ($sender,$receiver_id,'$msg', now())";

        if (mysqli_query($connection, $sql1) && mysqli_query($connection, $sql2) && mysqli_query($connection, $sqlmsg) ) {

            $layout .= "<div class='alert alert-success' role='alert'>
            Your request has registered. Pls wait for contact from shelter! :)
            </div>";
            header("refresh : 3 , url = home.php");

            //$sql ="UPDATE `a` SET `status`='' WHERE id =".$pet_id;

            // if (mysqli_query($connection, $sql)) {

            //     $layout .= "<div class='alert alert-success' role='alert'>
            //     Your request is registered. Pls wait for contact from shelter! :)
            //     </div>";
            //     header("refresh : 3 , url = home.php");

            // } else {

            // $layout .= "<div class='alert alert-danger' role='alert'>
            // Try Again Later....:(! ,
            // </div>";
            // header("refresh : 3 , url = home.php");
            // }
            
        } else {

            $layout .= "<div class='alert alert-danger' role='alert'>
            Try Again Later....:(!
            </div>";
            header("refresh : 3 , url = home.php");
        }
    
    }

    // $name = $name_error = $breed = $breed_error = $age = $age_error = $picture ="";
    // $type = $type_error = $description = $description_error = $location = $location_error = ""; 

    // $sql = "select * from pets where id =". $pet_id;


    // $row = retreive_form_database($connection ,$sql);

    // if ($row) {
    //     $name = $row['name'];
    //     $breed = $row['breed'];
    //     $age = $row['age'];
    //     $type = $row['species'];
    //     $size = $row['size'];
    //     $description = $row['description'];
    //     $location = $row['location'];
    //     //$vaccinated = $row['vaccinated'];
    //     $status = $row['status'];
    //     $picture = $row['image'];
    //     $pet_id =$row['id'];
    // }


    
    $error = false;
    $flag = true;  
    
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $row["name"] ?> Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="styles2.css">
    <link rel="stylesheet" href="styles.css">

</head>
<body>
<?php
if (isset($_SESSION["user"])){ 
require_once "navbar.php";
}
if (isset($_SESSION["admin"])){ 
    require_once "navbar_admin.php";
}
?>
<?= $layout ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center"><?= $row["name"] ?>'s Details</h1>
                </div>
                <div class="card-body">
                    <p class="card-text"><img src="../public/images/pet_images/<?= $row["image"] ?>" width="400"></p>
                    <p class="card-text"><strong>Species:</strong> <?= $row["species"] ?></p>
                    <p class="card-text"><strong>Description:</strong> <?= $row["description"] ?></p>
                    <p class="card-text"><strong>Location:</strong> <?= $row["location"] ?></p>
                    <p class="card-text"><strong>Added by:</strong> <?= $row["added_by"] ?></p>
                    <p class="card-text"><strong>Breed:</strong> <?= $row["breed"] ?></p>
                    <p class="card-text"><strong>Status:</strong> <?= $row["status"] ?></p>
                    <p class="card-text"><strong>Age:</strong> <?= $row["age"] ?></p>
                    <p class="card-text"><strong>Size:</strong> <?= $row["size"] ?></p>
                </div>
                <div class="card-footer text-center">
                    <?php
                    if (isset($_SESSION["user"])){ ?>
                        <a href="home.php" class="btn btn-warning">Back to Home Page</a>
                    <?php
                    }
                    if (isset($_SESSION["admin"])){ ?>
                        <a href="dashboard.php" class="btn btn-warning">Back to Home Page</a>
                    <?php 
                    }
                    if ($adoption) { ?>
                        <a href="details.php?pet_id=<?=$pet_id?>" class="btn btn-success">Take Me Home!</a>
                    <?php } ?>
                </div>

            </div>
        </div>
    </div>
    
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
