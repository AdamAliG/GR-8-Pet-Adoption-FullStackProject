<?php
    session_start();

    if(isset($_SESSION["user"])){ 
        header("Location:../home.php"); 
    }

    if(isset($_SESSION["admin"])){ 
        header("Location: ../dashboard.php"); 
    } 
    
    require_once "../db_connect.php";

    $error = false;  

    function cleanInputs($input){ 
        $data = trim($input); 
        $data = strip_tags($data); 
        $data = htmlspecialchars($data); 

        return $data;
    }

    $email = ""; 
    $emailError = $passError = ""; 

    
if(isset($_POST["login"])){
    $email = cleanInputs($_POST["email"]);
    $password = cleanInputs($_POST["password"]);

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ 
        $error = true;
        $emailError = "Please enter a valid email address";
    }

    if (empty($password)) {
        $error = true;
        $passError = "Password can't be empty!";
    }

    if(!$error){ 
        
        $stmt = $connection->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if($row && password_verify($password, $row["password"])){ 
            if($row["role"] == "admin"){
                $_SESSION["admin"] = $row["id"]; 
                header("Location: ../dashboard.php");
            }else {
                $_SESSION["user"] = $row["id"]; 
                header("Location:../home.php");
            }
        }else {
            echo "<div class='alert alert-danger'>
                    <p>Incorrect email or password, please try again.</p>
                  </div>";
        }
        $stmt->close();
    }
}


?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login page</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <h1 class="text-center">Login page</h1>
            <form method="post">
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
                <button name="login" type="submit" class="btn btn-primary">Login</button>
                
                <span>you don't have an account? <a href="register.php">register here</a></span>
            </form>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </body>
</html>