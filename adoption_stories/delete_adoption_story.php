<?php

session_start();

require_once "../db_connect.php";
require_once "../public/functions.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];


    $query = "DELETE FROM adoption_stories WHERE id = $id";


    if ($connection->query($query)) {
        echo "Story deleted!";

        header("Location: ../dashboard.php");
    } else {
        echo "Story not deleted!: " . $connection->error;
    }
} else {
    echo "Invalid request.";
}
