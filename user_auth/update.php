<?php
    session_start(); 

    require_once "../db_connect.php";
    include "../file_upload.php";
    function getRedirectUrl() {
        if (isset($_SESSION['admin'])) {
            return "../dashboard.php";
        } elseif (isset($_SESSION['user'])) {
            return "../home.php";
        } else {
            return "login.php";
        }
    }
    $currentUserId = $_SESSION["user"] ?? $_SESSION["admin"] ?? null;

    if (!$currentUserId) {
        header("Location: login.php");
        exit;
    }

    $userId = $_GET["id"] ?? 0;

    if ($userId != $currentUserId) {
        die("Unauthorized Access!");
    }

    $sql = "SELECT * FROM users WHERE id = $userId";
    $result = mysqli_query($connection, $sql);
    if (!$result) {
        die("Error executing query: " . mysqli_error($connection));
    }

    $user = mysqli_fetch_assoc($result);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"] ?? $user["username"];
        $email = (isset($_POST["email"]) && !empty(trim($_POST["email"]))) ? trim($_POST["email"]) : $user["email"];
        $password = $_POST["password"];
        
        $redirectUrl = getRedirectUrl();

        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Refresh: 2; url=$redirectUrl");
            die("Invalid email format!");
        }

        if (empty($username)) {
            header("Refresh: 2; url=$redirectUrl");
            die("Username is required!");
        }

        if (!empty($username)) {
            if (strlen($username) < 5) {
                header("Refresh: 2; url=$redirectUrl");
                die("Username must be at least 5 characters long!");
            }
            if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
                header("Refresh: 2; url=$redirectUrl");
                die("Username can only contain letters and numbers!");
            }
        }

        if (isset($_FILES['pictures']) && $_FILES['pictures']['error'] !== 4) { 
            list($pictureName, $uploadMessage) = fileUpload($_FILES['pictures'], 'user');

            if ($uploadMessage != "Ok") {
                die($uploadMessage); 
            }
        } else {
            $pictureName = $user["pictures"];
        }

        $updateQuery = "UPDATE users SET username = '$username', email = '$email', pictures = '$pictureName'";

        
        if (!empty($password)) {
            if(strlen($password) < 5) {
                header("Refresh: 2; url=update.php");
                die("Password must be at least 5 characters long!");
            }
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $updateQuery .= ", password = '$hashedPassword'";
        }

        $updateQuery .= " WHERE id = $userId";

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
                <label for="password" class="form-label">password:</label>
                <input type="password" class="form-control" id="password" name="password">
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
