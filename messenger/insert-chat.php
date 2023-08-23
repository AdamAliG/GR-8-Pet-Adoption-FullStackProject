<?php 
    session_start();
    include_once "../db_connect.php";

    
    if(isset($_SESSION['id'])) {
        $outgoing_id = $_SESSION['id'];
    } else {
        die("Session 'id' is not set");
    }
    
   
    if (!isset($_POST['incoming_id']) || empty($_POST['incoming_id']) || !isset($_POST['message'])) {
        echo "Required data not provided.";
        exit; 
    }

    $incoming_id = mysqli_real_escape_string($connection, $_POST['incoming_id']);
    $message = mysqli_real_escape_string($connection, $_POST['message']);

    if (empty($message)) {
        echo "Message is empty.";
        exit;
    }

    $sql = "INSERT INTO messages (sender_id, receiver_id, content) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($connection, $sql);

    if (!$stmt) {
        echo "Error preparing the statement: " . mysqli_error($connection);
        exit;
    }

    mysqli_stmt_bind_param($stmt, "iis", $outgoing_id, $incoming_id, $message);

    if (mysqli_stmt_execute($stmt)) {
        echo "Message inserted successfully.";
    } else {
        echo "Error executing the statement: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
?>



