<?php
require_once "../db_connect.php";


if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $pet_id = $_GET['id'];
    
    
    $query = "DELETE FROM pets WHERE id = $pet_id";
    
    
    if($connection->query($query)) {
        echo "Pet deleted successfully!";
        
        header("Refresh: 2; url=../dashboard.php");
    } else {
        echo "Error deleting pet: " . $connection->error;
    }
} else {
    echo "Invalid request.";
}
?>
