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

$errorEmail = '';
$errorUsername = '';
$errorPassword = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST["username"]) && trim($_POST["username"]) !== '' ? trim($_POST["username"]) : null;
    $email = (isset($_POST["email"]) && !empty(trim($_POST["email"]))) ? trim($_POST["email"]) : null;
    $password = $_POST["password"];
    
    $redirectUrl = getRedirectUrl();

    if (is_null($username) || $username == '') {
        $errorUsername = "Username is required!";
    } elseif (strlen($username) < 3) {
        $errorUsername = "Username must be at least 3 characters long!";
    } elseif (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $errorUsername = "Username can only contain letters and numbers!";
    }

    if (is_null($email) || $email == '') {
        $errorEmail = "Email is required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorEmail = "Invalid email format!";
    }

    if (!empty($password) && strlen($password) < 6) {
        $errorPassword = "Password must be at least 6 characters long!";
    }

    if (empty($errorUsername) && empty($errorEmail) && empty($errorPassword)) {  
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
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $updateQuery .= ", password = '$hashedPassword'";
        }

        $updateQuery .= " WHERE id = $userId";

        if (mysqli_query($connection, $updateQuery)) {
            echo "Updated Successfully!";
            header("Refresh: 2; url=".$redirectUrl);
            exit;
        } else {
            echo "Error: " . mysqli_error($connection);
        }
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
    <?php if (!empty($errorUsername)): ?>
        <div class="alert alert-danger mt-2"><?= $errorUsername ?></div>
    <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $user["email"] ?>">
                <?php if (!empty($errorEmail)): ?>
                    <div class="alert alert-danger mt-2"><?= $errorEmail ?></div>
                    <?php endif; ?>
            </div>
            <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password">
                <?php if (!empty($errorPassword)): ?>
                    <div class="alert alert-danger mt-2"><?= $errorPassword ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                    <label for="pictures" class="form-label">Profile picture</label>
                    <input type="file" class="form-control" id="pictures" name="pictures">
                </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
    <script>
    
    document.addEventListener('DOMContentLoaded', function() {
        
        var alerts = document.querySelectorAll('.alert');

        
        alerts.forEach(function(alert) {
            setTimeout(function() {
                alert.style.display = 'none';
            }, 2000);
        });
    });
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
