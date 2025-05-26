<?php
session_start();
include('./../config/conn.php');
date_default_timezone_set('Asia/Manila');

if ($_SESSION['user_id'] != "") {
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT * FROM users WHERE id = $user_id";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);
    $_SESSION['teacher_name'] = $row['fullname'];
} else {
    header('location: ./../index.php');
}

if (isset($_POST['btn_logout'])) {
    echo "eyyyy";
    unset($_SESSION['user_id']);
    header('location: ./../index.php');
}

$sql_lab = "SELECT * FROM laboratory";
$res_lab = mysqli_query($conn, $sql_lab);


if (isset($_POST['time'])) {
    echo "The time is " . date("g:iA");
}


$sql_subs = "SELECT scheds.year_section AS ys, scheds.day AS day, scheds.time_in AS time_in, scheds.time_out AS time_out,subs.code AS code, subs.name AS name 
    FROM subs
    JOIN scheds
    ON scheds.sub_id = subs.sub_id
    WHERE scheds.teacher_id = $user_id";
$res = mysqli_query($conn, $sql_subs);

if (!$res) {
    die("Error executing query: " . mysqli_error($conn));
}


if(isset($_POST['btn_timeout'])){
    $tch_name = $_SESSION['teacher_name'];
    $sql_labatt = "UPDATE laboratory SET lab_status = 'available', teacher_name = '' WHERE teacher_name = '$tch_name'";
    $res_labatt = mysqli_query($conn, $sql_labatt);
    if($res_labatt){
        echo "TIMED OUT - OK";
    }else{
        echo "ERROR";
    }


    $att_id = $_SESSION['attendance_id'];
    $att_time = date("g:iA");
    $user_id = $_SESSION['user_id'];
    $sql_att = "UPDATE attendance SET time_out = ? WHERE teacher_id = ? AND att_id = '$att_id'";
    $stmt = $conn->prepare($sql_att);

    if ($stmt === false) {
        die('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param('si', $att_time, $user_id);
    if ($stmt->execute()) {
        echo"TIMED OUT - OK";
    } else {
        echo"ERROR: " . $stmt->error;
    }


    $remark = "Out";
    $user_id = $_SESSION['user_id'];
    $day = date('l'); 
    $sql = "UPDATE scheds SET out_remark = '$remark' WHERE teacher_id = '$user_id' AND day = '$day'";
    if (mysqli_query($conn, $sql)) {
        echo "You've just timed out.";
        header('Location: ./attendance.php');
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
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

    <link href="https://cdn.jsdelivr.net/npm/hystmodal@1.0.1/dist/hystmodal.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./../styles/user.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />


    <title>Attendance</title>
</head>

<body>
    <div class="panel">
        <div class="wrapper">
            <div class="hystmodal" id="logout" aria-hidden="true">
                <div class="hystmodal__wrap">
                    <div class="hystmodal__window p-4 rounded" role="dialog" aria-modal="true">
                        <button data-hystclose class="hystmodal__close">Закрыть</button>
                        <div class="top mb-2">

                            <h1 class="text-dark fs-1 text-center"><i class="lni lni-sad"></i></h1>
                            <h4 class="m-0 mb-5 text-dark text-center">Are you leaving?</h4>
                            <div class="d-flex gap-2">
                                <button class="btn_cancel w-50" name="btn_reg">Cancel</button>
                                <form action="#" method="post" class="w-50">
                                    <button id="btn_logout" class="btn btn-danger w-100" name="btn_logout">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hystmodal" id="setting" aria-hidden="true">
                <div class="hystmodal__wrap">
                    <div class="hystmodal__window p-4 rounded" role="dialog" aria-modal="true">
                        <button data-hystclose class="hystmodal__close">Закрыть</button>
                        <div class="top mb-2">

                            <h1 class="text-dark fs-1 text-center"><i class="lni lni-sad"></i></h1>
                            <h4 class="m-0 mb-5 text-dark text-center">Are you leaving?</h4>
                            <div class="d-flex gap-2">
                                <button class="btn_cancel w-50" name="btn_reg">Cancel</button>
                                <form action="#" method="post">
                                    <button id="btn_logout" class="btn btn-danger w-50" name="btn_reg">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hystmodal" id="timeout" aria-hidden="true">
                <div class="hystmodal__wrap">
                    <div class="hystmodal__window p-4 rounded" role="dialog" aria-modal="true">
                        <button data-hystclose class="hystmodal__close">Закрыть</button>
                        <div class="top mb-2">

                            <h1 class="text-dark fs-1 text-center"><i class="lni lni-exit"></i></h1>
                            <h4 class="m-0 mb-5 text-dark text-center">Do you want time out?</h4>
                            <div class="d-flex gap-2">
                                <button class="btn_cancel w-50" name="btn_out">Cancel</button>
                                <form action="#" method="post" class="w-50">
                                    <button id="btn_logout" class="btn btn-danger w-100" name="btn_timeout">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('./components/sidebar.php') ?>

            <div class="main">
                <?php include('./components/header.php') ?>

                <div class="page">
                    <div class="att_wrapper">
                        <div class="lab_title d-flex justify-content-between">
                            <h2 class="m-0">Laboratory attendance</h2>
                        </div>
                        <div class="att_scheds">
                            <table class="table table-hover w-100 table-borderless m-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Year & Section</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">Subject</th>
                                        <th scope="col">Day</th>
                                        <th scope="col">Time In</th>
                                        <th scope="col">Time Out</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($res) > 0) {
                                        while ($row = mysqli_fetch_assoc($res)) {

                                            //LABORATORY SCHEDULES----- i check nato diri ang ang day para mao ray i display na schedule
                                            $sched_day = $row['day'];
                                            $sched_time = $row['time_in'];
                                            $str_in = strtotime($sched_time);


                                            $day = date('l');
                                            $time = date('h:iA');
                                            $str_time = strtotime($time);

                                            if ($sched_day == $day) {
                                    ?>
                                        <tr>
                                            <td><?= $row['ys'] ?></td>
                                            <td><?= $row['code'] ?></td>
                                            <td><?= $row['name'] ?></td>
                                            <td><?= $row['day'] ?></td>
                                            <td><?= $row['time_in'] ?></td>
                                            <td><?= $row['time_out'] ?></td>

                                        </tr>
                                    <?php
                                            }
                                        }
                                    } else {
                                        // echo "<h2 class='text-center mx-auto fs-3'> No subjects handled yet </h2>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="rooms">
                            <?php
                            //i check sa nato daan laboratory kung naa teacher
                            $lab_check = "";


                            if (mysqli_num_rows($res_lab) > 0) {
                                while ($lab_row = mysqli_fetch_assoc($res_lab)) {
                                    $lab_id = $lab_row['lab_id'];
                            ?>
                                <form method="post" class="d-none">
                                    <input type="hidden" id="lab_id" value="<?= $lab_row['lab_id'] ?>">
                                </form>
                                <div <?= $lab_row['lab_status'] == 'available' ? 'class="room active"' : 'class="room"'; ?>>
                                    <h2 class="d-flex align-items-center justify-content-center my-3"><i class="lni lni-display me-2"></i><?= $lab_row['lab_name'] ?></h2>

                                    <?php if($lab_row['lab_status'] == 'available'){
                                        echo '<a href="./../auth/fr.php?lab_id=' . $lab_id . '" class="btn btn-success d-flex align-items-center justify-content-center" id="btn_att"><i class="lni lni-frame-expand p-2 fs-5"></i>Take Attendance</a>';
                                    }else if($lab_row['lab_status'] != 'available' && $lab_row['teacher_name'] == $_SESSION['teacher_name']){
                                        echo '<form method="post"><button class="btn btn-danger w-100 py-2" id="btn_timeout"  data-hystmodal="#timeout">Time out</button></form>';
                                    }else{
                                        echo '<p class="m-0 text-center bg-danger">'. $lab_row['teacher_name'] .'</p>';
                                    }?>
                                </div>
                                
                            <?php
                                }
                            } else {
                                echo "<h2 class='text-center mx-auto fs-3'> No teacher registered </h2>";
                            } ?>
                        </div>
                        <!-- <p class="text-center">CLICK AVAILABLE LABORATORY TO PROCEED</p> -->
                        <div class="cam-scan">

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/hystmodal@1.0.1/dist/hystmodal.min.js"></script>
<script>
    
</script>
<script>
    const btn_cancel = document.querySelectorAll('.btn_cancel')
    const modal = document.getElementById('logout')
    const modalout = document.getElementById('timeout')



    const timeout = new HystModal({
        linkAttributeName: "data-hystmodal"
    });
    const myModal = new HystModal({
        linkAttributeName: "data-hystmodal"
    });


    btn_cancel.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault()
            myModal.close(modal);
            timeout.close(modalout);
        })
    })
</script>
<!-- <script>
    let rooms = document.querySelectorAll('.room');
    const btn_att = document.querySelector('#btn_att');

    rooms.forEach((room, index) => {
        room.addEventListener('click', ()=>{
            if (room.classList.contains('active')) {
                
                btn_att.classList.remove('disabled');
                alert(index + 1)
                // alert('PROCEED');
            } else {
                // alert('OCCUPIED NA NI NA LAB');
                btn_att.classList.add('disabled');
                alert(index + 1)
            }
        })
    })
</script> -->
<script>
    const divs = document.querySelectorAll('.room.active');
    const mydiv = document.querySelectorAll('.room');
    const btn_atts = document.querySelectorAll('#btn_att');
    const btn_select = document.querySelectorAll('#select_sched');
    const btn = document.querySelector('#btn_timeout');

    btn_select.forEach(select => {
        select.addEventListener('click', (e) => {
            e.preventDefault();
            select.classList.add('selected')
            if(!select.classList.contains('selected')){
                divs.forEach(div => {
                    btn_atts.forEach(att => {
                        att.classList.add('disabled')
                    })
                    div.style.cursor = "default";
                })
            }

        })
    });

    if(btn){
        divs.forEach(div => {
            btn_atts.forEach(att => {
                att.classList.add('disabled')
            })
            div.style.cursor = "default";
        })
    }
    mydiv.forEach(div => {
        if (div.querySelector('p')) {
            div.style.cursor = "default";
        }
    })
</script>
</html>