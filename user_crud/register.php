<?php
    session_start();

    if(isset($_SESSION["user"])){ 
        header("Location: Home und Details/home.php"); 
    }

    if(isset($_SESSION["admin"])){
        header("Location: ../dashboard.php");
    }

    require_once "../db_connect.php";
    require_once "../file_upload.php";

    $error = false;  

    function cleanInputs($input){ 
        $data = trim($input); 
        $data = strip_tags($data); 
        $data = htmlspecialchars($data); 

        return $data;
    }

    $username  = $email = $password = "";
    $usernameError = $emailError = $passError = "";

    if(isset($_POST["sign-up"])){
        $username = cleanInputs($_POST["username"]); 
        $email = cleanInputs($_POST["email"]);
        $password = cleanInputs($_POST["password"]);
        $pictures = fileUpload($_FILES["pictures"]);

        
        if(empty($username)){
            $error = true;
            $usernameError= "Please, enter your first name";
        }elseif(strlen($username) < 3){
            $error = true;
            $usernameError = "Name must have at least 3 characters.";
        }elseif(!preg_match("/^[a-zA-Z\s]+$/", $username)){
            $error = true;
            $usernameError = "Name must contain only letters and spaces.";
        }
   
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ 
            $error = true;
            $emailError = "Please enter a valid email address";
        }else {
           
            $query = "SELECT email FROM users WHERE email='$email'";
            $result = mysqli_query($connection, $query);
            if(mysqli_num_rows($result) != 0){
                $error = true;
                $emailError = "Provided Email is already in use";
            }
        }

       
        if (empty($password)) {
            $error = true;
            $passError = "Password can't be empty!";
        } elseif (strlen($password) < 6) {
            $error = true;
            $passError = "Password must have at least 6 characters.";
        }

        if(!$error){ 
            
            $password = hash("sha256", $password);

            $sql = "INSERT INTO users (username, password, email, pictures) VALUES ('$username', '$password', '$email', '$pictures[0]')";

            $result = mysqli_query($connection, $sql);

            if($result){
                echo "<div class='alert alert-success'>
                <p>New account has been created, $pictures[1]</p>
            </div>";
            }else {
                echo "<div class='alert alert-danger'>
                <p>Something went wrong, please try again later ...</p>
            </div>";
            }
        }
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sign Up</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <h1 class="text-center">Sign Up</h1>
            <form method="post" autocomplete="off" enctype="multipart/form-data">
                <div class="mb-3 mt-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="username" value="<?= $username ?>">
                    <span class="text-danger"><?= $usernameError ?></span>
                </div>
               
                
                <div class="mb-3">
                    <label for="pictures" class="form-label">Profile picture</label>
                    <input type="file" class="form-control" id="pictures" name="pictures">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email address" value="<?= $email ?>">
                    <span class="text-danger"><?= $emailError ?></span>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <span class="text-danger"><?= $passError ?></span>
                </div>
                <button name="sign-up" type="submit" class="btn btn-primary">Create account</button>
                
                <span>you have an account already? <a href="login.php">sign in here</a></span>
            </form>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </body>
</html>