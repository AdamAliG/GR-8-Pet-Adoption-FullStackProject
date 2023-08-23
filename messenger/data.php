<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once '../db_connect.php';
include_once '../file_upload.php';
if (isset($_SESSION['id'])) {
    $outgoing_id = $_SESSION['id'];
} else {
    die("Session 'id' is not set");
}

$sql = "SELECT * FROM users WHERE id != {$outgoing_id}";
$query = mysqli_query($connection, $sql);

if (!$query) {
    die("Users Query Failed: " . mysqli_error($connection));
}

$output = "";

while ($row = mysqli_fetch_assoc($query)) {
    if (!isset($row['id'])) {
        continue;
    }

    $unique_id = $row['id'];

    $sql2 = "SELECT * FROM messages WHERE (sender_id = {$unique_id}
    OR receiver_id = {$unique_id}) AND (receiver_id = {$outgoing_id} 
    OR sender_id = {$outgoing_id}) ORDER BY id DESC LIMIT 1";

    $query2 = mysqli_query($connection, $sql2);

    if (!$query2) {
        die("Messages Query Failed: " . mysqli_error($connection));
    }

    $row2 = mysqli_fetch_assoc($query2);
    (mysqli_num_rows($query2) > 0) ? $result = $row2['content'] : $result = "No message available";
    (strlen($result) > 28) ? $msg = substr($result, 0, 28) . '...' : $msg = $result;

    $you = "";
    if (isset($row2['sender_id']) && $outgoing_id == $row2['sender_id']) {
        $you = "You: ";
    }

    
    $offline = (isset($row['status']) && $row['status'] == "Offline") ? "offline" : "";

    
    $imgSrc = isset($row['pictures']) ? '../public/images/user_images/' . $row['pictures'] : '';

    $output .= '<a href="chat.php?id=' . $unique_id . '">
                <div class="content">
                <img src="' . $imgSrc . '" alt="">
                <div class="details">
                    <span>' . $row['username'] . " " . $row['role'] . '</span>
                    <p>' . $you . $msg . '</p>
                </div>
                </div>
                <div class="status-dot ' . $offline . '"><i class="fas fa-circle"></i></div>
            </a>';
}

echo $output;
?>
