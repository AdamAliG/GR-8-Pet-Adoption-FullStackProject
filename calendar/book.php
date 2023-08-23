<?php

session_start();

require_once "../db_connect.php";
require_once "../file_upload.php";
require_once "../public/functions.php";

$mysqli = new mysqli('localhost', 'root', '', 'gr 8 - pet adoption - fullstackproject');
if (isset($_GET['date'])) {
    $date = $_GET['date'];

    $stmt = $mysqli->prepare("select * from bookings where date = ?");
    $stmt->bind_param('s', $date);
    $bookings = array();
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bookings = $row['timeslot'];
            }

            $stmt->close();
        }
    }
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $timeslot = $_POST['timeslot'];
    $stmt = $mysqli->prepare("select * from bookings where date = ? AND timeslot = ?");
    $stmt->bind_param('ss', $date, $timeslot);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $msg = "<div class='alert alert-danger'>Already Booked</div>";
        } else {
            $stmt = $mysqli->prepare("INSERT INTO bookings (name, timeslot, email, date) VALUES(?,?,?,?)");
            $stmt->bind_param('ssss', $name, $timeslot, $email, $date);
            $stmt->execute();

            $msg = "<div class='alert alert-success'>Booking Successful</div>";
            $bookings[] = $timeslot;
            $stmt->close();
            $mysqli->close();
        }
    }
}

$duration = 30;
$cleanup = 0;
$start = "09:00";
$end = "15:00";

function timeslots($duration, $cleanup, $start, $end)
{
    $start = new DateTime($start);
    $end = new DateTime($end);
    $interval = new DateInterval("PT" . $duration . "M");
    $cleanupInterval = new DateInterval("PT" . $cleanup . "M");
    $slots = array();

    for ($intStart = $start; $intStart < $end; $intStart->add($interval)->add($cleanupInterval)) {
        $endPeriod = clone $intStart;
        $endPeriod->add($interval);
        if ($endPeriod > $end) {
            break;
        }

        $slots[] = $intStart->format("H:iA") . "-" . $endPeriod->format("H:iA");
    }

    return $slots;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <title>Timetable</title>
</head>

<body>

    <?php
    if (isset($_SESSION["user"])) {
        require_once "../navbar_sub.php";
    }
    if (isset($_SESSION["admin"])) {
        require_once "../navbar_admin_sub.php";
    }
    ?>

    <div class="container">
        <h1 class="text-center">Book for date: <?php echo date('m/d/Y', strtotime($date)); ?></h1>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <?php echo isset($msg) ? $msg : ""; ?>
            </div>
            <?php $timeslots = timeslots($duration, $cleanup, $start, $end);
            foreach ($timeslots as $ts) {
            ?>
                <div class="col-md-2 g-5">
                    <div class="form-group">
                        <?php if (in_array($ts, $bookings)) { ?>
                            <button class="btn btn-danger"><?php echo $ts; ?></button>
                        <?php } else { ?>
                            <button class="btn btn-success book" data-timeslot="<?php echo $ts; ?>"><?php echo $ts; ?></button>
                        <?php } ?>

                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <div id="myModal" class="modal fade" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Booking: <span id="slot"></span></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="">Timeslot</label>
                                    <input required type="text" readonly name="timeslot" id="timeslot" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input required type="text" name="name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input required type="email" name="email" class="form-control">
                                </div>
                                <div class="form-group d-flex justify-content-end mt-5">
                                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script>
        $(".book").click(function() {
            var timeslot = $(this).attr('data-timeslot');
            $("#slot").html(timeslot);
            $("#timeslot").val(timeslot);
            $("#myModal").modal("show");
        })
    </script>
</body>

</html>