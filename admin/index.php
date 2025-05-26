<?php
session_start();
include('./../config/conn.php');

if (isset($_POST['btn_reg'])) {
    $lab_name = $_POST['lab_name'];
    $lab_status = $_POST['lab_status'];

    $stmt = $conn->prepare("INSERT INTO laboratory (lab_name, lab_status) VALUES (?, ?)");
    $stmt->bind_param("ss", $lab_name, $lab_status);

    if ($stmt->execute()) {
        $status = 'success';
        $message = "Successfully added";
    } else {
        $status = "error";
        $message = "Failed to register" . $stmt->error;
    }

    $stmt->close();
}

// total teacher ni diri
$sql_tch = "SELECT COUNT(*) AS 'count' FROM users";
$tch_res = mysqli_query($conn, $sql_tch);
$tch_row = mysqli_fetch_assoc($tch_res);
$tch_total = $tch_row['count'];

// total subjects ni diri
$sql_sub = "SELECT COUNT(*) AS 'count' FROM subs";
$sub_res = mysqli_query($conn, $sql_sub);
$sub_row = mysqli_fetch_assoc($sub_res);
$sub_total = $sub_row['count'];







//para ni sa bar graph
$sql1 = "SELECT
    COUNT(CASE WHEN remarks = 'Present' THEN 1 END) AS present_count,
    COUNT(CASE WHEN remarks = 'Absent' THEN 1 END) AS absent_count,
    COUNT(CASE WHEN remarks = 'Late' THEN 1 END) AS late_count
    FROM
        attendance
    WHERE day = 'Monday'";

$sql2 = "SELECT
    COUNT(CASE WHEN remarks = 'Present' THEN 1 END) AS present_count,
    COUNT(CASE WHEN remarks = 'Absent' THEN 1 END) AS absent_count,
    COUNT(CASE WHEN remarks = 'Late' THEN 1 END) AS late_count
    FROM
    attendance
    WHERE day = 'Tuesday'";

$sql3 = "SELECT
    COUNT(CASE WHEN remarks = 'Present' THEN 1 END) AS present_count,
    COUNT(CASE WHEN remarks = 'Absent' THEN 1 END) AS absent_count,
    COUNT(CASE WHEN remarks = 'Late' THEN 1 END) AS late_count
    FROM
    attendance
    WHERE day = 'Wednesday'";

$sql4 = "SELECT
    COUNT(CASE WHEN remarks = 'Present' THEN 1 END) AS present_count,
    COUNT(CASE WHEN remarks = 'Absent' THEN 1 END) AS absent_count,
    COUNT(CASE WHEN remarks = 'Late' THEN 1 END) AS late_count
    FROM
    attendance
    WHERE day = 'Thursday'";

$sql5 = "SELECT
    COUNT(CASE WHEN remarks = 'Present' THEN 1 END) AS present_count,
    COUNT(CASE WHEN remarks = 'Absent' THEN 1 END) AS absent_count,
    COUNT(CASE WHEN remarks = 'Late' THEN 1 END) AS late_count
    FROM
    attendance
    WHERE day = 'Friday'";










$result1 = $conn->query($sql1);
if ($result1->num_rows > 0) {
    $row = $result1->fetch_assoc();
    
    $present_count1 = $row["present_count"];
    // $absent_count = $row["absent_count"];
    // $late_count = $row["late_count"];
} else {
    $present_count = 0;
    // $absent_count = 0;
    // $late_count = 0;
}



$result2 = $conn->query($sql2);
if ($result2->num_rows > 0) {
    $row = $result2->fetch_assoc();
    
    $present_count2 = $row["present_count"];
    // $absent_count = $row["absent_count"];
    // $late_count = $row["late_count"];
} else {
    $present_count2 = 0;
    // $absent_count = 0;
    // $late_count = 0;
}

$result3 = $conn->query($sql3);
if ($result3->num_rows > 0) {
    $row = $result3->fetch_assoc();
    
    $present_count3 = $row["present_count"];
    // $absent_count = $row["absent_count"];
    // $late_count = $row["late_count"];
} else {
    $present_count3 = 0;
    // $absent_count = 0;
    // $late_count = 0;
}

$result4 = $conn->query($sql4);
if ($result4->num_rows > 0) {
    $row = $result4->fetch_assoc();
    
    $present_count4 = $row["present_count"];
    // $absent_count = $row["absent_count"];
    // $late_count = $row["late_count"];
} else {
    $present_count4 = 0;
    // $absent_count = 0;
    // $late_count = 0;
}

$result5 = $conn->query($sql5);
if ($result5->num_rows > 0) {
    $row = $result5->fetch_assoc();
    
    $present_count5 = $row["present_count"];
    // $absent_count = $row["absent_count"];
    // $late_count = $row["late_count"];
} else {
    $present_count5 = 0;
    // $absent_count = 0;
    // $late_count = 0;
}











//activeness ni diri
$sql = "SELECT 
            SUM(CASE WHEN remarks = 'Present' THEN 1 ELSE 0 END) AS present_count,
            SUM(CASE WHEN remarks = 'Absent' THEN 1 ELSE 0 END) AS absent_count,
            SUM(CASE WHEN remarks = 'Late' THEN 1 ELSE 0 END) AS late_count,
            COUNT(*) AS total_count
        FROM 
            attendance";

$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $present_count = $row['present_count'];
    $absent_count = $row['absent_count'];
    $late_count = $row['late_count'];
    $total_count = $row['total_count'];

    // echo "Total Attendance: $total_count<br>";
    // echo "Present: $present_count<br>";
    // echo "Absent: $absent_count<br>";
    // echo "Late: $late_count<br>";
} else {
    echo "Error: " . $conn->error;
}
$active = $present_count + $late_count;
$inactive = $absent_count;


$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/hystmodal@1.0.1/dist/hystmodal.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

    <link rel="stylesheet" href="./../styles/admin.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />


    <title>Dashboard</title>
</head>

<body>
    <div class="panel">
        <div class="wrapper">
            <?php include('./components/sidebar.php') ?>

            <div class="main">
                <?php include('./components/header.php') ?>

                <div class="page">
                    <div class="dashboard">
                        <div class="boxes">
                            <div class="box">
                                <div class="inf">
                                    <h2 class="m-0"><?= $tch_total; ?></h2>
                                    <p class="m-0">Total teacher</p>
                                </div>
                                <div class="icon">
                                    <i class="lni lni-users fs-1"></i>
                                </div>
                            </div>
                            <div class="box">
                                <div class="inf">
                                    <h2 class="m-0"><?= $sub_total; ?></h2>
                                    <p class="m-0">Total subjects</p>
                                </div>
                                <div class="icon">
                                    <i class="lni lni-display fs-1"></i>
                                </div>
                            </div>
                            <div class="box">
                                <div class="inf">
                                    <h2 class="m-0">Laboratory</h2>
                                    <p class="m-0">Add new laboratory</p>
                                </div>
                                <div class="icon">
                                    <button class="btn p-0" data-hystmodal="#myModal"><i class="lni lni-plus fs-1"></i></button>
                                </div>
                            </div>

                            <div class="hystmodal" id="myModal" aria-hidden="true">
                                <div class="hystmodal__wrap">
                                    <div class="hystmodal__window p-4 rounded" role="dialog" aria-modal="true">
                                        <button data-hystclose class="hystmodal__close">Закрыть</button>
                                        <div class="top mb-4">
                                            <h4 class="m-0">Add new laboratory</h4>
                                            <p class="form-text">Create new laboratory</p>
                                        </div>

                                        <form method="post" enctype="multipart/form-data">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="lab_name" class="form-control shadow-none" id="floatingInput" placeholder="name@example.com" required>
                                                <label for="floatingInput">Laboratory name</label>
                                            </div>
                                            <input type="hidden" name="lab_status" value="available">
                                            <button id="btn_nt" class="btn d-flex align-items-center justify-content-center px-3 py-2 mb-2 w-100" name="btn_reg">Proceed </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="graph">
                            <div class="visual">
                                <h2 class="m-0 ms-2">Attendance</h2>
                                <p class="m-0 ms-2 mb-3 form-text">This shows the teacher attendace</p>
                                <div class="g">
                                <canvas id="myChart"></canvas>

                                </div>
                            </div>
                            <div class="visual">
                                <h2 class="m-0 ms-2">Activeness</h2>
                                <p class="m-0 ms-2 mb-3 form-text">Active and inactice teachers</p>
                                <canvas id="dgh"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
<script src="./../scripts/user.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/hystmodal@1.0.1/dist/hystmodal.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script>
    const ctx = document.getElementById('myChart');
    const dgh = document.getElementById('dgh');



    let active = <?= !empty($active) ? (int)$active : 0 ?>;
    let inactive = <?= !empty($inactive) ? (int)$inactive : 0 ?>;


    //present attendace
    let monday = <?= $present_count1?>;
    let tuesday = <?= $present_count2?>;
    let wednesday = <?= $present_count3?>;
    let thursday = <?= $present_count4?>;
    let friday = <?= $present_count5?>;




    if (active === 0 || inactive === 0){
        new Chart(dgh, {
        type: 'doughnut',
        data: {
            labels: [
                'No Data Yet',
            ],
            datasets: [{
                label: 'Activeness',
                data: [1],
                backgroundColor: [
                    '#3d5a80',
                ],
                hoverOffset: 4
            }]
        },

    });
    }else{
        new Chart(dgh, {
        type: 'doughnut',
        data: {
            labels: [
                'Active',
                'Inactive',
            ],
            datasets: [{
                label: 'Activeness',
                data: [active, inactive],
                backgroundColor: [
                    '#3d5a80',
                    'rgb(220, 53, 69)'
                ],
                hoverOffset: 4
            }]
        },

    });
    }





    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
            datasets: [{
                label: 'Present total',
                data: [monday, tuesday, wednesday, thursday, friday],
                backgroundColor: '#3d5a80',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    border: {
                        display: false
                    },
                    ticks: {
                        maxTicksLimit: 5,
                    }
                },
                x: {
                    grid: {
                        display:false
                    },
                }
            }
        }
    });

    
</script>
<script>
    const myModal = new HystModal({
        linkAttributeName: "data-hystmodal"
    });
</script>
<script type="text/javascript">
    const message = <?php echo json_encode($message); ?>;
    const status = <?php echo json_encode($status); ?>;
    if (message) {
        swal({
            title: status === 'success' ? 'Success!' : 'Error!',
            text: message,
            icon: status === 'success' ? 'success' : 'error',
            confirmButtonText: 'OK'
        });
    }
</script>

</html>