<?php
/*
This page is a admin page, it needs sign in ($_SESSION['adm']) 
it show all details about adoption request.
in this page can see and change the status of the request
*/

session_start();
// $_SESSION['adm']= 4;
if (!isset($_SESSION['adm'])) {
    header( "Location: login.php" );
} 
    

    require_once "public/components/db_connect.php"; 
    require_once "public/components/file_Upload.php"; 
    require_once "public/functions.php";

    $pet_id = 0;
    $user_id_req=0;
    $new_status="";
    $layout = "";

    if (isset($_GET['status'])) {

        $status_g = $_GET['status'];

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


    $row = retreive_form_database($connect ,$sql);

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


    $row = retreive_form_database($connect ,$sql);

    if ($row) {
        $username = $row['username'];
        $email = $row['email'];
        $reg_date = $row['registration_date'];
        $picture_user = $row['image'];
        $user_id_req =$row['id'];
    }

    if (!empty($new_status))  {

        

        $sql1 = "UPDATE adoption_applications set status='$new_status', status_date=Now() where pet_id=$pet_id and user_id=$user_id_req"; 
        
        if ($new_status == 'approved') {

            $sql2 ="UPDATE pets SET `status`='adopted' WHERE id =".$pet_id;
            $sql3= "UPDATE adoption_applications set status='rejected' where pet_id=$pet_id and user_id != $user_id_req";

            if (mysqli_query($connect, $sql1) && mysqli_query($connect, $sql2) && mysqli_query($connect, $sql3) ) {

                $layout .= "<div class='alert alert-success' role='alert'>
                You have changed the Request Status!
                </div>";
                header("refresh : 3 , url = index_requests.php");
            }


        } else if ($new_status == 'rejected') {

            $sql="select id from adoption_applications where status!='rejected' and pet_id=$pet_id and user_id != $user_id_req";
            $row=retreive_form_database($connect ,$sql);
            if (!$row2) {
                $sql2 ="UPDATE pets SET `status`='not adopted' WHERE id =".$pet_id;
            }

            if (isset($sql2)) {

                if (mysqli_query($connect, $sql1) && mysqli_query($connect, $sql2)) {

                    $layout .= "<div class='alert alert-success' role='alert'>
                    You have changed the Request Status!
                    </div>";
                    header("refresh : 3 , url = index_requests.php");
                }

            } else {

                if (mysqli_query($connect, $sql1)) {

                    $layout .= "<div class='alert alert-success' role='alert'>
                    You have changed the Request Status!
                    </div>";
                    header("refresh : 3 , url = index_requests.php");
                }

            }
            
        } else {
            $sql2 ="UPDATE pets SET `status`='pending' WHERE id =".$pet_id;

            if (mysqli_query($connect, $sql1) && mysqli_query($connect, $sql2)) {

                $layout .= "<div class='alert alert-success' role='alert'>
                You have changed the Request Status!
                </div>";
                header("refresh : 3 , url = index.php");
            }
        }
  
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

    </div>
    </div>
    <?php if ($adoption) { ?>
        <a href="detail.php?pet_id=<?=$pet_id?>" class="btn btn-success">Take Me Home!</a>
    <?php } ?>
    </div>
    <script  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"  integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
<?php
mysqli_close($connect);
?>