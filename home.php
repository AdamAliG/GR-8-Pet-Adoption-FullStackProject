<?php
    session_start(); 

    require_once "db_connect.php";

    $sql = "SELECT * FROM users WHERE id = {$_SESSION["user"]}";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);

$query = "SELECT * FROM pets";
$result = $connection->query($query);

    //mysqli_close($connection);

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome <?= $row["username"] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="pictures/<?= $row["pictures"] ?>" alt="user pic" width="30" height="24">
            </a>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>

                <li class="nav-item">
                <a class="nav-link" href="user_auth/update.php?id=<?= $row["id"] ?>">edit</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="user_auth/logout.php?logout">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Species</th>
            <th>Breed</th>
            <th>Age</th>
            <th>Location</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while($petRow = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $petRow['name'] ?></td>
                <td><?= $petRow['species'] ?></td>
                <td><?= $petRow['description'] ?></td>
                <td><?= $petRow['location'] ?></td>
                
                
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
    <h2 class="text-center">Welcome <?= $row["username"] ?></h2>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>