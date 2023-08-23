<?php 
    session_start();
    include '../db_connect.php';
    if(isset($_SESSION['id'])) {
        $outgoing_id = $_SESSION['id'];
    } else {
        die("Session 'id' is not set");
    }
    
    $incoming_id = mysqli_real_escape_string($connection, $_POST['incoming_id']);

    $output = "";

    
    $sql = "SELECT * FROM messages LEFT JOIN users ON users.id = messages.sender_id
            WHERE (sender_id = {$outgoing_id} AND receiver_id = {$incoming_id})
            OR (sender_id = {$incoming_id} AND receiver_id = {$outgoing_id}) 
            ORDER BY messages.id";

    $query = mysqli_query($connection, $sql);

    if (!$query) {
        die("Query Failed: " . mysqli_error($connection));
    }

    if(mysqli_num_rows($query) > 0){
        while($row = mysqli_fetch_assoc($query)){
            if($row['sender_id'] === $outgoing_id){
                $output .= '<div class="chat outgoing">
                            <div class="details">
                                <p>'. $row['content'] .'</p>
                            </div>
                            </div>';
            }else{
                $user_image = isset($row['pictures']) ? $row['pictures'] : ''; 
                $output .= '<div class="chat incoming">
                            <img src="../public/images/user_images/'.$user_image.'" alt="">
                            <div class="details">
                                <p>'. $row['content'] .'</p>
                            </div>
                            </div>';
            }
        }
    } else {
        $output .= '<div class="text">No messages are available. Once you send a message, they will appear here.</div>';
    }

    echo $output;
?>
