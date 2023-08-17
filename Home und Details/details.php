<?php
  
  
  require_once "db_connect.php";
    $id = $_GET["id"];

    $sql = "SELECT * FROM pets WHERE id = $id";
    $result = mysqli_query($connect, $sql); 

    $row = mysqli_fetch_assoc($result)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $row["name"] ?> Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            background-color: #ffffff;
        }

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
<link rel="stylesheet" href="styles.css">
<body>
<nav class="navbar navbar-expand-lg navbar-light ">
    <div class="container">
        <a class="navbar-brand" href="#">Pet Adoption</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="Home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Adoption Stories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pet of the Day</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Calendar for Volunteers</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center"><?= $row["name"] ?>'s Details</h1>
                </div>
                <div class="card-body">
                    <p class="card-text"><img src="pictures/<?= $row["image"] ?>" width="200"></p>
                    <p class="card-text"><strong>Species:</strong> <?= $row["species"] ?></p>
                    <p class="card-text"><strong>Description:</strong> <?= $row["description"] ?></p>
                    <p class="card-text"><strong>Location:</strong> <?= $row["location"] ?></p>
                    <p class="card-text"><strong>Added by:</strong> <?= $row["added_by"] ?></p>
                    <p class="card-text"><strong>Breed:</strong> <?= $row["breed"] ?></p>
                    <p class="card-text"><strong>Status:</strong> <?= $row["status"] ?></p>
                    <p class="card-text"><strong>Age:</strong> <?= $row["age"] ?></p>
                    <p class="card-text"><strong>Size:</strong> <?= $row["size"] ?></p>
                </div>
                <div class="card-footer text-center">
                    <a href="Home.php" class="btn btn-warning">Back to Home Page</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
