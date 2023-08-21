<?php
/*
This page is a user page, it needs sign in ($_SESSION['user']) 
it show detail for each case and has a adopt request button,
to put a request to database

*/
    session_start();
    // $_SESSION['user']=2;
    // $_SESSION['user']=2;
    // $_SESSION['adm']=3;
     if (!isset($_SESSION['user'])) {
            header( "Location: login.php" );
     } else if (isset($_SESSION['user'])) {
         $user_id = $_SESSION['user'];
     } 
    

    require_once "db_connect.php"; 
    require_once "file_Upload.php"; 
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

    if (isset($_GET['pet_id']))  {

        $sql1 = "INSERT INTO `adoption_applications`(`user_id`, `pet_id`, `application_date`) VALUES ($user_id,$pet_id,NOW())";
        $sql2 = "UPDATE `pets` SET `status`='pending' WHERE id =".$pet_id;

        if (mysqli_query($connection, $sql1) && mysqli_query($connection, $sql2) ) {

            $layout .= "<div class='alert alert-success' role='alert'>
            Your request has registered. Pls wait for contact from shelter! :)
            </div>";
            header("refresh : 3 , url = index.php");

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

    $name = $name_error = $breed = $breed_error = $age = $age_error = $picture ="";
    $type = $type_error = $description = $description_error = $location = $location_error = ""; 

    $sql = "select * from pets where id =". $pet_id;


    $row = retreive_form_database($connection ,$sql);

    if ($row) {
        $name = $row['name'];
        $breed = $row['breed'];
        $age = $row['age'];
        $type = $row['species'];
        $size = $row['size'];
        $description = $row['description'];
        $location = $row['location'];
        //$vaccinated = $row['vaccinated'];
        $status = $row['status'];
        $picture = $row['image'];
        $pet_id =$row['id'];
    }


    
    $error = false;
    $flag = true;  
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Adoption - Event Page</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"  rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"  crossorigin="anonymous">
    <link rel="stylesheet" href="public/components/css/main.css">
</head>
<body>
    <?php
        include  "public/components/navbar.php"; 
    ?>
    <?= $layout ?>
    <div class="container ">
    <div class="grid-container-2 ">
    <div>
            <a href="index.php" class="btn btn-warning">Back to home page</a>
            <?php if ($adoption) { ?>
                <a href="detail.php?pet_id=<?=$pet_id?>" class="btn btn-success">Take Me Home!</a>
            <?php } ?>
            <div>
                <h2 class="text-primary">Detail</h2>
            </div>
            
        
            <div class="mb-3 mt-3 w-90">
                <label for="name" class= "form-label">Name: </label><br><?=$name ?>
            </div>
            <div class="mb-3 w-90">
                <label for="type" class="form-label">Type: </label><br><?=$type ?>
            </div>
            <div class="mb-3 w-90">
                <label for="breed" class="form-label">Breed: </label><br><?=$breed ?>
            </div>
            <div class="mb-3 w-90">
                <label for="age" class="form-label">Age:</label><br><?=$age ?> years old
            </div>
            <div class="mb-3 mt-3 w-90">
                <label for="description" class= "form-label">Description:</label><br><?=$description ?>
            </div>
            <div class="mb-3 w-90">
                <label for="size" class="form-label">Size:</label><br><?=$size ?>        
            </div>
            <div class="mb-3 mt-3 w-90">
                <label for="location" class= "form-label">Location:</label><br><?=$location ?>
            </div>
            <div class="mb-3 mt-3 w-90">
                <label for="vaccinated" class= "form-label">Status:</label><br><?=$status ?>
            </div>
            <a href="index.php" class="btn btn-warning">Back to Index</a>
            <?php if ($adoption) { ?>
                <a href="detail.php?pet_id=<?=$pet_id?>" class="btn btn-success">Take Me Home!</a>
            <?php } ?>
    </div>
    <div>
        <div class="mb-3 d-flex justify-content-center  ">
            <img src="public/images/pet_images/<?=$picture ?>" class="detail_pic" >
        </div>
        <div class="mb-3 ">
    </div>
    </div>
    </div>
    <script  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"  integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
<?php
mysqli_close($connection);
?>