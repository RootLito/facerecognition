<?php
session_start();
include('./../config/conn.php');
date_default_timezone_set('Asia/Manila');

if ($_SESSION['user_id'] != "") {
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT * FROM users WHERE id = $user_id";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);
    $url = json_encode($row['picture']);
} else {
    header('location: ./../index.php');
}


if(isset($_POST['att_save'])){
    
    // LABORATORY DIRI 
    $lab_id = $_GET['lab_id'];
    $lab_tch = $row['fullname'];
    $lab_status = "occupied";

    $stmt_lab = $conn->prepare("UPDATE laboratory SET lab_status = ?, teacher_name = ? WHERE lab_id = ?");
    $stmt_lab->bind_param("ssi", $lab_status, $lab_tch, $lab_id);

    if ($stmt_lab->execute()) {
        echo "<h3>LABORATORY - OK</h3>";
    } else {
        echo "<h3>Failed: " . $stmt_lab->error . "</h3>";
    }
    $stmt_lab->close();


    //SCHEDULE DIRI
    $in_remark ="present";
    $sched_tch_id = $user_id;

    $stmt_sched = $conn->prepare("UPDATE scheds SET in_remark = ? WHERE teacher_id=?");
    $stmt_sched->bind_param("si", $in_remark, $sched_tch_id);

    if ($stmt_sched->execute()) {
        echo "<h3>SCHEDULE - OK</h3>";
    } else {
        echo "<h3>Failed: " . $stmt_sched->error . "</h3>";
    }
    $stmt_sched->close();



    //ATTENDACE DIRI--------------------------------
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM scheds WHERE teacher_id = '$user_id'";
    $result = mysqli_query($conn, $sql);

    $daysArray = [];

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $daysArray[] = $row['day'];
            $qin = $row['time_in'];
            $qout = $row['time_out'];
        }
    } else {
        echo "Error: " . mysqli_error($connection);
    }

    $att_date = date('m/d/Y');
    $tch_id = $user_id;
    $day = date('l'); 
    $att_time = date("g:iA");



    if (in_array($day, $daysArray)){
        $sql = "SELECT * FROM scheds WHERE day = '$day'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $schedule = mysqli_fetch_assoc($result);
            $time_in = $schedule['time_in'];
            $time_out = $schedule['time_out'];
        } else {
            echo "No schedule found for $day.";
        }



        $stmt_att = $conn->prepare("INSERT INTO attendance (date, teacher_id, day, time_in) VALUES (?, ?, ?, ?)");
        $stmt_att->bind_param("ssss", $att_date, $tch_id, $day, $att_time);

        if ($stmt_att->execute()) {
            $attendanceId = $conn->insert_id;
            $_SESSION['attendance_id'] = $attendanceId;
            echo "<h3>ATTENDANCE - OK</h3>";
        } else {
            echo "<h3>Failed: " . $stmt_att->error . "</h3>";
        }

        // KANI DIRI KAY LOGIC PARA SA LATE, PRESENT UG ABSENT 
        echo $att_time . "<br>";
        echo $time_in . "<br>";
        echo $time_out . "<br>";

        $remarks = '';

        if ($att_time <= $time_in) {
            $remarks = 'Present';
        } elseif ($att_time > $time_in && $att_time <= $time_out) {
            $remarks = 'Late';
        } elseif ($att_time > $time_out) {
            $remarks = 'Absent';
        } else {
            $remarks = 'Absent';
        }

        $stmt_update = $conn->prepare("UPDATE attendance SET remarks = ? WHERE att_id = ?");
        $stmt_update->bind_param("si", $remarks, $attendanceId);

        if ($stmt_update->execute()) {
            echo "<h3>Attendance updated to '$remarks'</h3>";
        } else {
            echo "<h3>Failed to update: " . $stmt_update->error . "</h3>";
        }

        $stmt_update->close();


        
        header('location: ./../user/attendance.php');
    
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="./../styles/font.css">
    <link rel="stylesheet" href="./../styles/cam.css">

    <script defer src="./../dist/face-api.min.js"></script>
    <script defer src="./../scripts/face-reg.js"></script>

    <title>Register</title>
</head>

<body>
    <div class="wrapper">

        <div class="cam-panel">
            <h2 class="m-0 text-center">Face Verification</h2>
            <p class="form-text mb-4 text-center">Click verify if the face landmark appears</p>

            <div class="cam mb-4">
                <video id="video" autoplay muted></video>
            </div>

            <div class="toast align-items-center text-bg-success border-0 mb-4" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        Face match, attendance saved!
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>

            <div class="toast align-items-center text-bg-danger border-0 mb-4 toast2" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        Face did not match, please try again.
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>

            <div class="toast align-items-center text-bg-danger border-0 mb-4 toast3" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        No face detected, please try again.
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>

            <div class="spinner spinner-border text-secondary mb-4" role="status" style="display: none;">
                <span class="visually-hidden"></span>
            </div>
            <button id="btn" class="btn_ver mb-2 w-100">Verify</button>
            <form action="" method="post" class="w-100">
                <button class="btn btn-success w-100 mb-4 p-2 disabled" id="btn_proceed" name="att_save">Proceed</button>
            </form>
        </div>
        <div class="right p-3 bg-light border rounded " style="display: none;">
            <h2 class="m-0"><?= $user_id ?></h2>
            <p class="form-text"><?= $row['fullname'] ?></p>
            <img src="./../assets/<?= $row['picture'] ?>" id="user_pic" alt="" width="150px" style="display: none;">
            <canvas id="ccanvas" width="640" height="360" style="display: none;"></canvas>
            <img id="captured-image" alt="Captured Frame" style="display: none;" width="350px">
            
        </div>
    </div>
</body>
</html>
