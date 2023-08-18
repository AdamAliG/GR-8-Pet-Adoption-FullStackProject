<?php
    session_start(); 

    if(!isset($_SESSION["user"]) && !isset($_SESSION["admin"])){ 
        header("Location: login.php"); 
    }

    if(isset($_SESSION["user"])){ 
        header("Location: home.php"); 
    }

    require_once "db_connect.php";

    $sql = "SELECT * FROM users WHERE id = {$_SESSION["admin"]}";
    
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);


   

    $sqlUsers = "SELECT * FROM users WHERE role != 'admin'";
    $resultUsers = mysqli_query($connection, $sqlUsers);

    $layout = "";

    if(mysqli_num_rows($resultUsers) > 0){
        while($userRow = mysqli_fetch_assoc($resultUsers)){
            $layout .= "";
        }
    }else {
        $layout .= "No results found!";
    }
    $query = "SELECT * FROM pets";
    $result = $connection->query($query);
    mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome <?= $row["first_name"] ?></title>
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
                <a class="nav-link" href="login_logout_register_crud/update.php?id=<?= $row["id"] ?>">edit</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="user_auth/logout.php?logout">Logout</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pet_crud/add_pet.php?add_pet">Add Pet</a>
                </li>
            </ul>
        </div>
    </nav>
    <h2 class="text-center">Welcome <?= $row["username"]  ?></h2>
    <table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Species</th>
            <th>Description</th>
            <th>Location</th>
            
            
        </tr>
    </thead>
    <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['species'] ?></td>
                <td><?= $row['description'] ?></td>
                <td><?= $row['location'] ?></td>
                
                <td>
                    <a href="pet_crud/edit_pet.php?id=<?= $row['id'] ?>">Edit</a> | 
                    <a href="pet_crud/delete_pet.php?id=<?= $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this pet?');">Delete</a>



                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
    <div class="container">
        <div class="row row-cols-3">
            <?= $layout ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>