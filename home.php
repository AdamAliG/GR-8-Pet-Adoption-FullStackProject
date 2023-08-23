<?php
session_start(); 

if(!isset($_SESSION["user"]) && !isset($_SESSION["admin"])){ 
    header("Location: user_auth/login.php"); 
    exit;
}

if(isset($_SESSION["admin"])){ 
    header("Location: dashboard.php");
    exit;
}

require_once "db_connect.php";
require_once "public/functions.php";

$userId=$_SESSION["user"];

$sql = "SELECT * FROM pets WHERE 1"; 

if (isset($_GET['species'])) {
    $selectedSpecies = $_GET['species'];
    if ($selectedSpecies !== 'all') {
        $sql .= " AND species = '$selectedSpecies'";
    }
}
if (isset($_GET['size'])) {
    $selectedSize = $_GET['size'];
    if ($selectedSize !== 'all') {
        $sql .= " AND size = '$selectedSize'";
    }
}
if (isset($_GET['status'])) {
    $selectedStatus = $_GET['status'];
    if ($selectedStatus !== 'all') {
        $sql .= " AND status = '$selectedStatus'";
    }
}

$result = mysqli_query($connection, $sql);

$cards = "";

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){

            $flag=false;
            $show=true;
            $sql2="select id,status from adoption_applications where status !='approved' and pet_id = {$row['id']} and user_id != {$userId} and pet_id in (select pet_id from foster_to_adopt where pet_id = {$row['id']} and status='in_progress' and user_id != {$userId} )";
            $rows2=retreive_form_database($connection ,$sql2);
            // if ($rows['id']==9) {
            //     echo isset($rows2);
            //     exit();
            // } 
            $sql3="select * from adoption_applications where pet_id = {$row['id']} and user_id = {$userId} order by id desc LIMIT 1 ";

            $rows3=retreive_form_database($connection ,$sql3);

            $sql4="select * from foster_to_adopt where pet_id = {$row['id']} and user_id = {$userId}  and status='in_progress' ";
            $rows4=retreive_form_database($connection ,$sql4);

            $cards .= "<div class='col mb-4'>
                <div class='card h-100'>
                    <div class='card-body'>
                        <h5 class='card-title'>{$row["name"]}</h5>
                        
                        <img src='public/images/pet_images/{$row["image"]}' class='card-img-top' alt='...'>
                    
                        <p class='card-text'>Species: {$row["species"]}</p>";            
                        if (($rows3) && (!$rows4)) {
                            $flag=true;
                            switch ($rows3['status']) {
                                case "rejected":
                                    $show=false;
                                    $cards.="<p class='card-text'><span class='text-danger'>your request for {$row['name']} has rejected!</span></p>";
                                    break;
                                case "pending":
                                    $cards.="<p class='card-text'><span class='text-success'>your request for {$row['name']} is in progress!</span></p>";
                                    break;
                                case "approved":
                                    $show=false;
                                    $cards.="<p class='card-text'><span class='text-primary'>you have adopted {$row['name']}!:)</span></p>";
                                    break;
                            }
                        }
                        if ($rows4) {
                            $cards.="<p class='card-text'><span class='text-success'>in Foster-to-Adopt process by you! have a good time!:)</span></p>";
                        }
                        if (($rows2) && ($show)) {
                            $cards.="<p class='card-text'><span class='text-primary'>in Foster-to-Adopt process by another applicant!wait a little!:)</span></p>";
                        } 

                        $cards.="<p class='card-text'>Location: {$row["location"]}</p>
                        <a href='details.php?detail={$row["id"]}' class='btn btn-info'>Show Details</a>";
                        if (!$rows2 && !$rows4 && !$flag) {
                            $cards.="<a href='details.php?detail={$row['id']}&adoption=yes' class='btn btn-info'>Adopt Me!</a>";
                        } 
                        $cards.="</div>
                </div>
            </div>";
        }
    } else {
        $cards = "<p>No results found</p>";
    }
    



?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pet Adoption</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    
</head>
<body>

<?php
require_once "navbar.php";
?>

<div class="container mt-5">
    <h1 class="mt-5">Pet List</h1>
    <form action="" method="get" class="mb-3">
        <div class="accordion accordion-flush" id="filterAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="filterHeader">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                        Filter Options
                    </button>
                </h2>
                <div id="filterCollapse" class="accordion-collapse collapse" aria-labelledby="filterHeader" data-bs-parent="#filterAccordion">
                    <div class="accordion-body">
                        <div class="mb-3">
                            <label for="speciesSelect" class="form-label">Species:</label>
                            <select name="species" id="speciesSelect" class="form-select">
                                <option value="all">All</option>
                                <option value="dog">Dog</option>
                                <option value="cat">Cat</option>
                                <option value="bird">Bird</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="sizeSelect" class="form-label">Size:</label>
                            <select name="size" id="sizeSelect" class="form-select">
                                <option value="all">All</option>
                                <option value="small">Small</option>
                                <option value="medium">Medium</option>
                                <option value="big">Big</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="statusSelect" class="form-label">Status:</label>
                            <select name="status" id="statusSelect" class="form-select">
                                <option value="all">All</option>
                                <option value="not adopted">Not adopted</option>
                                <option value="adopted">Adopted</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm mt-3">Apply Filters</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    
    <div class="input-group input-group-sm mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Search by name...">
    </div>
    
    <div class="row row-cols-lg-3 row-cols-md-2 row-cols-sm-1 row-cols-xs-1">
        <?= $cards ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

<script>
    const searchInput = document.getElementById('searchInput');
    const cardContainer = document.querySelector('.row-cols');
    const cards = Array.from(document.querySelectorAll('.col.mb-4'));

    searchInput.addEventListener('input', function () {
        const searchTerm = searchInput.value.toLowerCase();

        cards.forEach(card => {
            const petName = card.querySelector('.card-title').textContent.toLowerCase();
            const shouldShow = petName.includes(searchTerm);

            card.style.display = shouldShow ? 'block' : 'none';
        });
        cards.sort((a, b) => {
            const isVisibleA = a.style.display === 'block';
            const isVisibleB = b.style.display === 'block';
            return isVisibleB - isVisibleA;
        });

        cards.forEach(card => cardContainer.removeChild(card));
        cards.forEach(card => cardContainer.appendChild(card));
    });
</script>


</body>
</html>