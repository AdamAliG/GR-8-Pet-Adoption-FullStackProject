<?php
    session_start();
    include_once "../db_connect.php";

    if(isset($_SESSION['id'])) {
      $outgoing_id = $_SESSION['id'];
  } else {
      die("Session 'id' is not set");
  }
    $searchTerm = mysqli_real_escape_string($connection, $_POST['searchTerm']);

    $sql = "SELECT * FROM users WHERE NOT id = {$outgoing_id} AND (username LIKE '%{$searchTerm}%') ";
    $output = "";
    $query = mysqli_query($connection, $sql);
    if(mysqli_num_rows($query) > 0){
        include_once "data.php";
    }else{
        $output .= 'No user found related to your search term';
    }
    echo $output;
?>