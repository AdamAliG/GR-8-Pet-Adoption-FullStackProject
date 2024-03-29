<?php
if (isset($_SESSION["admin"])) {
    $adminId = intval($_SESSION["admin"]);
    $sql = "SELECT * FROM users WHERE id = $adminId";
    $result = mysqli_query($connection, $sql);
    $adminRow = mysqli_fetch_assoc($result);
}
$hasAccessToChat = false;

if (isset($_SESSION["admin"])) {
    $hasAccessToChat = true;
} elseif (isset($_SESSION["user"])) {
    if (isset($userRow["is_approved"]) && $userRow["is_approved"] == 1) {
        $hasAccessToChat = true;
    }
}
?>
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <image class="navbar-brand" src="public/images/web_images/navbar_logo.png" width="39">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="dashboard.php?dashboard">Home</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="requests.php">Requests</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adoption_stories/adoption_stories.php">Adoption Stories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pet_of_the_day/pet_of_the_day.php">Pet of the Day</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="calendar/calendar.php">Calendar for Volunteers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="matchmaker/matchmaker.html">Matchmaker</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pet_crud/add_pet.php?add_pet">Add Pet</a>
                    </li>
                    <?php if ($hasAccessToChat) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="messenger/users.php?id=<?= $_SESSION['id'] ?>">Chat</a>
                        </li>
                    <?php endif; ?>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <a class="nav-item me-3" href="#">
                        <img src="public/images/user_images/<?= $adminRow["pictures"] ?>" alt="user pic" width="35" height="30">
                    </a>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" href="user_auth/update.php?id=<?= $adminRow["id"] ?>">Update</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" href="user_crud/users.php?users">See Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" href="user_auth/logout.php?logout">Logout</a>
                    </li>
                </ul>

            </div>
    </div>
</nav>
<br>