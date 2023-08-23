<?php
session_start(); 

// Überprüfung, ob der Benutzer eingeloggt ist und ob es sich um einen Admin handelt.
if(!isset($_SESSION["admin"])){ 
    header("Location: user_auth/login.php"); 
    exit;
}

require_once "../db_connect.php";
require_once "../file_upload.php";

$admin_id = $_SESSION["admin"];
$admin_sql = "SELECT * FROM users WHERE id = '$admin_id'";
$admin_result = mysqli_query($connection, $admin_sql);
$adminRow = mysqli_fetch_assoc($admin_result);

$sql = "SELECT * FROM users WHERE role = 'user'";
$result = mysqli_query($connection, $sql);

$users = "";

if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $users .= "<div class='col mb-4'>
            <div class='card h-100'>
                <div class='card-body'>
                    <h5 class='card-title'>{$row['username']}</h5>  
                    <img src='../public/images/user_images/{$row["pictures"]}' class='card-img-top square-img' alt='...'>        
                    <p class='card-text'>Email: {$row["email"]}</p>
                        <p class='card-text'>Registration date: {$row["registration_date"]}</p>
                    <a href='edit_user.php?id={$row['id']}' class='btn btn-info mt-2'>Bearbeiten</a>
                    <a href='delete_user.php?id={$row['id']}' class='btn btn-info mt-2'>Löschen</a>
                    <a href='details_user.php?id={$row["id"]}' class='btn btn-info mt-2'>Show Details</a>
                </div>
            </div>
        </div>";
    }
} else {
    $users = "<p>No results found</p>";
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzer anzeigen</title>
    <!-- Including Bootstrap for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
</head>
<style>
    


.square-img {
    display: block;
    height: 350px;
    width: 350px;
    margin: auto;
}
</style>
<body>
    
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="#">Pet Adoption</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="../dashboard.php?dashboard">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../adoption_stories/adoption_stories.php">Adoption Stories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pet of the Day</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../calendar/calendar.php">Calendar for Volunteers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../matchmaker/matchmaker.html">Matchmaker</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../pet_crud/add_pet.php?add_pet">Add Pet</a>
                </li>

            </ul>
            
            <ul class="navbar-nav ms-auto">
            <a class="nav-item me-3" href="#">
                <img src="../public/images/user_images/<?= $adminRow["pictures"] ?>" alt="user pic" width="35" height="30">
            </a>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" href="../user_auth/update.php?id=<?= $adminRow["id"] ?>">Update</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" href="user_auth/logout.php?logout">Logout</a>
                    </li>
                </ul>
            
        </div>
    </div>
</nav>
<div class="container mt-5">  
    <div class="row">
        <?php echo $users; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
