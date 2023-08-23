<?php 
    session_start();
    require_once "../db_connect.php";
    if(isset($_SESSION['id'])) {
      $outgoing_id = $_SESSION['id'];
  } else {
      die("Session 'id' is not set");
  }
?>

<?php include_once "header.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  
</body>
</html>
<body>
    <div class="wrapper">
        <section class="chat-area">
            <header>
                <?php 
                    if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
                        header("Location: login.php");
                        exit;
                    }

                    if (isset($_GET['id'])) {
                      $user_id = mysqli_real_escape_string($connection, $_GET['id']);

                        $sql = mysqli_query($connection, "SELECT * FROM users WHERE id = {$user_id}");
                    
                        if (!$sql) {
                            die("Query Failed: " . mysqli_error($connection));
                        }
                    
                        if (mysqli_num_rows($sql) > 0) {
                            $row = mysqli_fetch_assoc($sql);
                        } else {
                            echo "No user found with the given unique ID.";
                            exit;  
                        }
                    } else {
                        echo "Unique ID missing";
                        exit; 
                    }
                ?>
                <a href="users.php?id=<?= $_SESSION['id'] ?>" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <img src="../public/images/user_images/<?php echo $row['pictures']; ?>" alt="">
                <div class="details">
                    <span><?php echo $row['username']. " " . $row['role'] ?></span>
                    <p><?php echo $row['is_approved']; ?></p>
                </div>
            </header>
            <div class="chat-box">
                
            </div>
            <form action="#" class="typing-area">
                <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
                <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
                <button><i class="fab fa-telegram-plane"></i></button>
            </form>
        </section>
    </div>

    <script src="chat.js"></script>
</body>
</html>
