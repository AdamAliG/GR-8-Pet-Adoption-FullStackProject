<?php
/*
This page is a admin page, it needs sign in ($_SESSION['adm']) 
it show all details about adoption request.
in this page can see and change the status of the request
*/

session_start();
// $_SESSION['adm']= 4;
if (!isset($_SESSION['admin'])) {
    header( "Location: user_crud/login.php" );
} 
    

    require_once "db_connect.php"; 
    require_once "file_Upload.php"; 
    require_once "public/functions.php";

    if(isset($_POST['fost'])) {
        $pet_id = $_POST['pet_id'];
        $user_id_req = $_POST['user_id_req'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $description = $_POST['description'];

        $sqlfost = "INSERT INTO `adoption_applications`(`user_id`, `pet_id`, 'status','','',) VALUES ($user_id,$pet_id,NOW())";

    }
    

    $pet_id = 0;
    $user_id_req=0;
    $new_status="";
    $layout = "";

    if (isset($_GET['status'])) {

        $status_g = $_GET['status'];
    }

    if (isset($_GET['new_status'])) {

        $new_status = $_GET['new_status'];

    } 

    if (isset($_GET['detail'])) {

        $pet_id = $_GET['detail'];

    } 
    if (isset($_GET['user_id_req'])) {

        $user_id_req = $_GET['user_id_req'];

    } 
    
    if (isset($_GET['adoption'])) {

        if ($_GET['adoption'] == "yes") {
            $adoption = True;
        }

    } 
    
    if (isset($_GET['pet_id'])) {

        $pet_id = intval($_GET['pet_id']);

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

    $sql = "select * from users where id =". $user_id_req;


    $row = retreive_form_database($connection ,$sql);

    if ($row) {
        $username = $row['username'];
        $email = $row['email'];
        $reg_date = $row['registration_date'];
        $picture_user = $row['pictures'];
        $user_id_req =$row['id'];
    }

    if (!empty($new_status))  {

        $sql0= "select status from adoption_applications where pet_id=$pet_id and user_id=$user_id_req";
        $rows0=retreive_form_database($connection,$sql0);
        $current_status = $rows0['status'];
        $status_g = $new_status;

        $sql1 = "UPDATE adoption_applications set status='$new_status', status_date=Now() where pet_id=$pet_id and user_id=$user_id_req"; 
        
        if ($new_status == 'approved') {

            $sql2 ="UPDATE pets SET `status`='adopted' WHERE id =".$pet_id;
            $sql3= "UPDATE adoption_applications set status='rejected', status_date=Now() where pet_id=$pet_id and user_id != $user_id_req";

            if (mysqli_query($connection, $sql1) && mysqli_query($connection, $sql2) && mysqli_query($connection, $sql3) ) {

                $layout .= "<div class='alert alert-success' role='alert'>
                You have changed the Request Status!
                </div>";
                //header("refresh : 3 , url = index_requests.php");
            }


        } else if ($new_status == 'rejected') {



            if ($current_status=='approved') {
                
                $sql22= "select * from adoption_applications where status='rejected' and pet_id=$pet_id and user_id!=$user_id_req";
                $rows2=retreive_form_database($connection,$sql22);
                if ($rows2) {
                    $sql3 ="UPDATE pets SET `status`='pending' WHERE id =".$pet_id;
                    $sql2="UPDATE adoption_applications SET status='pending',status_date=Now() where pet_id=$pet_id and user_id != $user_id_req";
                } else {
                    $sql3 ="UPDATE pets SET `status`='not adopted' WHERE id =".$pet_id;
                }
            }

            if ($current_status=='pending') {
                $sql2= "select id from adoption_applications where status='pending' and pet_id=$pet_id and user_id!=$user_id_req";
                $rows2=retreive_form_database($connection,$sql2);
                if (!$rows2) {
                    $sql22 ="UPDATE pets SET `status`='not adopted' WHERE id =".$pet_id;
                }
            }
            
            if (isset($sql3) && isset($sql2)) {
               
                if (mysqli_query($connection, $sql1) && mysqli_query($connection, $sql2) && mysqli_query($connection, $sql3)) {

                    $layout .= "<div class='alert alert-success' role='alert'>
                    You have changed the Request Status.Now the Pet is free for adoption requests.
                    </div>";
                    //header("refresh : 3 , url = index_requests.php");
                }

            } else if (isset($sql3)) {

                if (mysqli_query($connection, $sql1) && mysqli_query($connection, $sql3)) {

                    $layout .= "<div class='alert alert-success' role='alert'>
                    You have changed the Request Status.Now the Pet status is not adopted.
                    </div>";
                    //header("refresh : 3 , url = index_requests.php");
                }

            } else if (isset($sql22)) {

                if (mysqli_query($connection, $sql1) && mysqli_query($connection, $sql22)) {

                    $layout .= "<div class='alert alert-success' role='alert'>
                    You have changed the Request Status.Now the Pet status is not adopted.
                    </div>";
                    //header("refresh : 3 , url = index_requests.php");
                }

            } else {

                if (mysqli_query($connection, $sql1)) {

                    $layout .= "<div class='alert alert-success' role='alert'>
                    You have changed the Request Status!
                    </div>";
                    //header("refresh : 3 , url = index_requests.php");
                }

            }
            
        } else if ($new_status == 'pending') {

            $sql2 ="UPDATE pets SET `status`='pending' WHERE id =".$pet_id;
        
            if ($current_status=='approved') {
                $sql3="UPDATE adoption_applications SET status='pending', status_date=Now() where pet_id=$pet_id and user_id != $user_id_req";
            }

            if ($current_status=='rejected') {
                $sql4= "select id from adoption_applications where status='approved' and pet_id=$pet_id and user_id!=$user_id_req";
                $rows4=retreive_form_database($connection,$sql4);
                if (!$rows4) {
                    $sql44 ="UPDATE pets SET `status`='pending' WHERE id =".$pet_id;
                }
            }

            if (isset($sql3)) {
                if (mysqli_query($connection, $sql1) && mysqli_query($connection, $sql2) && mysqli_query($connection, $sql3)) {
                    $layout .= "<div class='alert alert-success' role='alert'>
                    You have changed the Request Status!.Now the Pet is free for adoption requests!
                    </div>";
                    // header("refresh : 3 , url = index.php");
                }
            } else if (isset($sql44)) {
                if (mysqli_query($connection, $sql1) && mysqli_query($connection, $sql2) && mysqli_query($connection, $sql44)) {
                    $layout .= "<div class='alert alert-success' role='alert'>
                    You have changed the Request Status.
                    </div>";
                    // header("refresh : 3 , url = index.php");
                }

            }  else {
                if (mysqli_query($connection, $sql1) && mysqli_query($connection, $sql2)) {
                    $layout .= "<div class='alert alert-success' role='alert'>
                    You have changed the Request Status!
                    </div>";
                    // header("refresh : 3 , url = index.php");
                }

            }

        }

  
    }
    switch ($status_g) {
        case 'approved':
            $color = "primary";
            break;
        case 'rejected':
            $color = "danger";
            break;
        case 'pending':
            $color = "warning";
            break;
        default:
            $color = "dark";
            break;
    }
    $layout .= "<h2 class='text-{$color} text-center fw-bold'>".ucwords($status_g)."!</h2>";

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
    
    <a href="index_requests.php" class="btn btn-dark" >Back to requests page</a>

    <?php if ($status_g != 'approved')  { ?>
        <a href="detail_request.php?pet_id=<?=$pet_id?>&user_id_req=<?=$user_id_req?>&new_status=approved" class="btn btn-primary" onclick="return confirm('Are you sure?')">Change to Approved request</a>
    <?php } ?>
    <?php if ($status_g != 'rejected')  { ?>
        <a href="detail_request.php?pet_id=<?=$pet_id?>&user_id_req=<?=$user_id_req?>&new_status=rejected" class="btn btn-danger" onclick="return confirm('Are you sure?')">Change to Rejected request</a>
    <?php } ?>
    <?php if ($status_g != 'pending')  { ?>
        <a href="detail_request.php?pet_id=<?=$pet_id?>&user_id_req=<?=$user_id_req?>&new_status=pending" class="btn btn-warning" onclick="return confirm('Are you sure?')">Change to Pending request</a>
    <?php } ?>

    <div class="grid-container-3 ">
    <div>
            <div>
                <h3 class="text-primary">Pet Detail</h3>
            </div>
            
            <div class="mb-3 d-flex justify-content-center  ">
            <img src="public/images/pet_images/<?=$picture ?>" class="detail_pic" >
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
            <a href="home.php" class="btn btn-warning">Back to home page</a>
    </div>
    <div>
            <div>
                <h3 class="text-primary">Applicant Detail</h3>
            </div>
            
            <div class="mb-3 d-flex justify-content-center  ">
            <img src="public/images/user_images/<?=$picture_user ?>" class="detail_pic" >
            </div>
            <div class="mb-3 mt-3 w-90">
                <label for="name" class= "form-label">Username: </label><br><?=$username ?>
            </div>
            <div class="mb-3 w-90">
                <label for="type" class="form-label">Email: </label><br><?=$email ?>
            </div>
            <div class="mb-3 w-90">
                <label for="breed" class="form-label">Registration Date: </label><br><?=$reg_date ?>
            </div>
            <div class="border border-primary p-2">
            <h3 class="text-danger">Foster-to-Adopt Form</h3>
            <form method="post">
                Pet : <?=$name ?><input type="hidden" name="pet_id" value=<?=$pet_id ?>><br>
                User : <?=$username ?><input type="hidden" name="user_id_req" value=<?=$user_id_req ?>><br><br>
                Start Date : <input type="date" name="start_date" class="form-control" required><br>
                End Date : <input type="date" name="end_date" class="form-control" required><br>
                Description : <textarea name="description" id="description" cols="70" rows="5" required></textarea>
                <br><br>
                <button type="submit" name="fost" value="fost" class="btn btn-large btn-warning">Foster for <?=$username ?></button>
            </form>
            </div>
    </div>
    </div>

    </div>
    <script  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"  integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
<?php
mysqli_close($connection);
?>