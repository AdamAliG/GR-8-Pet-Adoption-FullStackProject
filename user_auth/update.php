<?php
    session_start(); 

    require_once "../db_connect.php";
    include "../file_upload.php";

    
    $currentUserId = $_SESSION["user"] ?? $_SESSION["admin"] ?? null;

    
    if (!$currentUserId) {
        header("Location: login.php");
        exit;
    }

    $userId = $_GET["id"] ?? 0;

    // Ensure the user is updating their own profile
    if ($userId != $currentUserId) {
        die("Unauthorized Access!");
    }

    // Fetch user data from the database
    $sql = "SELECT * FROM users WHERE id = $userId";
    $result = mysqli_query($connection, $sql);
    if (!$result) {
        die("Error executing query: " . mysqli_error($connection));
    }

    $user = mysqli_fetch_assoc($result);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $email = $_POST["email"];

        if (isset($_FILES['pictures']) && $_FILES['pictures']['error'] !== 4) { 
            list($pictureName, $uploadMessage) = fileUpload($_FILES['pictures'], 'user');

            if ($uploadMessage != "Ok") {
                die($uploadMessage); 
            }
        } else {
            $pictureName = $user["pictures"];
        }

        $updateQuery = "UPDATE users SET username = '$username', email = '$email', pictures = '$pictureName' WHERE id = $userId";

        if (mysqli_query($connection, $updateQuery)) {
            echo "Updated Successfully!";
            if (isset($_SESSION['user'])) {
                header("Location: ../home.php");
            } elseif (isset($_SESSION['admin'])) {
                header("Location: ../dashboard.php");
            } else {
                
                header("Location: login.php");
            }
            exit;
        } else {
            echo "Error: " . mysqli_error($connection);
        }
    }
    mysqli_close($connection);
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Profile</h2>
        <form action="update.php?id=<?= $userId ?>" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= $user["username"] ?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $user["email"] ?>">
            </div>
            <div class="mb-3">
                    <label for="pictures" class="form-label">Profile picture</label>
                    <input type="file" class="form-control" id="pictures" name="pictures">
                </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
