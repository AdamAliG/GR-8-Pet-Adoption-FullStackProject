
<?php
session_start();


if (!isset($_SESSION["admin"])) {
    header("Location: user_auth/login.php");
    exit;
}

require_once "../db_connect.php";
$admin_id = $_SESSION["admin"];
$admin_sql = "SELECT * FROM users WHERE id = '$admin_id'";
$admin_result = mysqli_query($connection, $admin_sql);
$adminRow = mysqli_fetch_assoc($admin_result);

$adoptions_sql = "SELECT pets.name as pet_name FROM adoption_applications INNER JOIN pets ON adoption_applications.pet_id = pets.id WHERE adoption_applications.user_id = ?";
$adoptions_stmt = mysqli_prepare($connection, $adoptions_sql);
mysqli_stmt_bind_param($adoptions_stmt, "i", $id);
mysqli_stmt_execute($adoptions_stmt);
$adoptions_result = mysqli_stmt_get_result($adoptions_stmt);

$adoptedPets = [];
while ($row = mysqli_fetch_assoc($adoptions_result)) {
    $adoptedPets[] = $row["pet_name"];
}

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);  
    $sql = "SELECT * FROM users WHERE id = ?";
    
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $userDetails = mysqli_fetch_assoc($result);
    } else {
        die("Error fetching user details: " . mysqli_error($connection));
    }
} else {
    die("User ID not provided.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - User Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
    <style>
        

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .form-label {
            font-size: 0.875rem;
        }

        .form-select {
            font-size: 0.875rem;
        }

        .btn-sm {
            font-size: 0.75rem;
        }

        .form-control,
        .input-group-sm .form-control {
            font-size: 0.875rem;
        }

        .card-title {
            font-size: 1.25rem;
        }
        .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
    }

    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #ddd;
        padding: 20px;
    }

    .card-title {
        font-size: 1.8rem;
        margin-bottom: 0;
    }

    .card-body {
        padding: 20px;
    }

    .card-text img {
        max-width: 100%;
        height: auto;
    }

    .card-text strong {
        font-weight: bold;
    }

    .card-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #ddd;
        padding: 20px;
        text-align: center;
    }

    .btn-warning {
        background-color: #ffc107;
        border: none;
    }

    .btn-warning:hover {
        background-color: #ffaa00;
    }
    </style>
</head>

<body>
<?php
require_once "../navbar_admin_sub.php";
?> 
<div class="container w-50 mt-5">
    <h2>User Details</h2>
    <div class="card shadow"> 
        <div class="card-header bg-warning text-dark text-center fs-3"> 
            Details of <?= htmlspecialchars($userDetails["username"]) ?>
        </div>
        <div class="card-body">
           
            <p class="card-text text-center">
                <img src="../public/images/user_images/<?= htmlspecialchars($userDetails["pictures"]) ?>" class="rounded" width="400" alt="User Image">
            </p>
            <?php if (count($adoptedPets) > 0): ?>
              <p class="text-center"><strong>Adoptierte Tiere:</strong> <?= htmlspecialchars(implode(', ', $adoptedPets)) ?></p>
             <?php else: ?>
               <p class="text-center">Der Benutzer hat noch kein Tier adoptiert.</p>
             <?php endif; ?>
            <p class="text-center"><strong>Email:</strong> <?= htmlspecialchars($userDetails["email"]) ?></p>
            <p class="text-center"><strong>Registration Date:</strong> <?= htmlspecialchars($userDetails["registration_date"]) ?></p>
            <a href="edit_user.php?id=<?=$userDetails['id']?>" class="btn btn-info mt-2">Bearbeiten</a>
            <a href="delete_user.php?id=<?=$userDetails['id']?>" class="btn btn-info mt-2">Löschen</a>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>