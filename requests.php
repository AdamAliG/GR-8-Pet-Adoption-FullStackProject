<?php
    session_start(); 

    if(!isset($_SESSION["user"]) && !isset($_SESSION["admin"])){ 
        header("Location: user_auth/login.php"); 
    }
    
    if(isset($_SESSION["user"])){ 
        header("Location: home.php"); 
    }



    require_once "db_connect.php";
    require_once "public/functions.php";
   
    
    if (isset($_SESSION["admin"])) {
        $adminId = intval($_SESSION["admin"]); 
        $sql = "SELECT * FROM users WHERE id = $adminId";
        $result = mysqli_query($connection, $sql);
        $adminRow = mysqli_fetch_assoc($result);

    }

    if (isset($_GET['status'])) {
        $status = $_GET['status'];
    } else {
        $status = "NO-Status";
    }
    if ($status!='NO-Status') {
        $sql = "SELECT *,pets.image as pimage,users.pictures as uimage,adoption_applications.status as status_req
                FROM adoption_applications 
                inner join users on (user_id = users.id)
                inner join pets on (pet_id = pets.id)
                where 
                adoption_applications.status = '$status'
                group BY
                adoption_applications.pet_id , adoption_applications.user_id ";
    } else {
        $sql = "SELECT *,pets.image as pimage,users.pictures as uimage,adoption_applications.status as status_req
                FROM adoption_applications 
                inner join users on (user_id = users.id)
                inner join pets on (pet_id = pets.id)
                group BY
                adoption_applications.pet_id , adoption_applications.user_id ";
    }

    if (isset($sql)) {

        $result = mysqli_query($connection ,$sql);
        $layer="";
        $layer.="<div class='d-flex justify-content-center'><div class='grid-container'>";
    
        if(mysqli_num_rows($result) > 0){
    
            while($rows = mysqli_fetch_assoc($result)){
                $sqlfost="SELECT * from foster_to_adopt inner join users on (user_id = users.id) where pet_id={$rows['pet_id']} and status='in_progress'  order by foster_to_adopt.id desc ";
                $rows3=retreive_form_database($connection ,$sqlfost);
                $layer.="<div class='col mb-4'>
                        <div class='card h-100'>
                            <div class='card-body'>
                                <h5 class='card-title'>{$rows["name"]}</h5>
                                <img src='public/images/pet_images/{$rows['pimage']}' class='card-img-top' alt='...'>
                                <p class='card-text'>Species: {$rows["species"]}</p>";
                    if ($rows3) {
                        $layer.="<p class='card-text'><b>Fosted by:".$rows3['username']."<br>from: ".$rows3['start_date']." to: ".$rows3['end_date']."</b></p>";
                    }
                    $layer.="<p class='card-text'>Request From : {$rows['username']}<br>Request Status : <b>{$rows['status_req']}</b></p>";
                    if ($rows['status_req']=='rejected') {
                        $sql2="SELECT username,id from users where id = (select user_id from adoption_applications where status='approved' and  pet_id={$rows['pet_id']} ) ";
                        // echo $sql2;
                        // exit();
                        $rows2=retreive_form_database($connection ,$sql2);
                        if ($rows2) { 
                            $layer.="<p class='card-text'>adopted by: {$rows2['username']}</p>";   
                        }
                    }
                $layer.="<p class='card-text'>
                    Breed : {$rows['breed']}
                    </p>
                    <p class='card-text'>
                    age : {$rows['age']}
                    </p>
                    <a href='detail_request.php?detail={$rows['pet_id']}&user_id_req={$rows['user_id']}&status={$rows['status_req']}' class='btn btn-primary'>Request Details</a>
                    </div>
                    </div>
                    </div>";
            }
        }
        else {
            $layer.="<div class='text-danger'>No Records Yet!!</div>";
        }
    
        $layer.="</div></div>";
    
    }
    

// $sql = "SELECT * FROM pets WHERE 1"; 

// if (isset($_GET['species'])) {
//     $selectedSpecies = $_GET['species'];
//     if ($selectedSpecies !== 'all') {
//         $sql .= " AND species = '$selectedSpecies'";
//     }
// }
// if (isset($_GET['size'])) {
//     $selectedSize = $_GET['size'];
//     if ($selectedSize !== 'all') {
//         $sql .= " AND size = '$selectedSize'";
//     }
// }
// if (isset($_GET['status'])) {
//     $selectedStatus = $_GET['status'];
//     if ($selectedStatus !== 'all') {
//         $sql .= " AND status = '$selectedStatus'";
//     }
// }
//     $result = mysqli_query($connection, $sql);
//     $cards = "";

    // if(mysqli_num_rows($result) > 0){
    //     while($row = mysqli_fetch_assoc($result)){
    //         $cards .= "<div class='col mb-4'>
    //             <div class='card h-100'>
    //                 <div class='card-body'>
    //                     <h5 class='card-title'>{$row["name"]}</h5>
                        
    //                 <img src='public/images/pet_images/{$row["image"]}' class='card-img-top' alt='...'>
                    
    //                     <p class='card-text'>Species: {$row["species"]}</p>
    //                     <p class='card-text'>Location: {$row["location"]}</p>
    //                     <a href='details.php?detail={$row["id"]}' class='btn btn-info'>Show Details</a>
    //                     <a href='pet_crud/edit_pet.php?id={$row["id"]}' class='btn btn-info'>Edit</a>
    //                     <a href='pet_crud/delete_pet.php?id={$row["id"]}' class='btn btn-info'>Delete</a>
    //                 </div>
    //             </div>
    //         </div>";
    //     }
    // } else {
    //     $cards = "<p>No results found</p>";
    // }

   

    mysqli_close($connection);
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
require_once "navbar_admin.php";
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
    
    
        <?= $layer ?>
    
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