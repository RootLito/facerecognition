<?php
session_start();
include('./../config/conn.php');

if ($_SESSION['user_id'] != "") {
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT * FROM users WHERE id = $user_id";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);
} else {
    header('location: ./../index.php');
}

if (isset($_POST['btn_logout'])) {
    echo "eyyyy";
    unset($_SESSION['user_id']);
    header('location: ./../index.php');
}

if(isset($_POST['btn_update'])){
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT picture FROM users WHERE id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($old_picture);
    $stmt->fetch();
    $stmt->close();


    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        $picture = $_FILES['picture']['name'];
        $tempname = $_FILES['picture']['tmp_name'];
        $folder = "./../assets/" . basename($picture);

        if (move_uploaded_file($tempname, $folder)) {
            echo "<h3>Image uploaded successfully!</h3>";

            if ($picture !== $old_picture) {
                $stmt = $conn->prepare("UPDATE users SET picture=? WHERE id=?");
                $stmt->bind_param("si", $picture, $user_id);

                if ($stmt->execute()) {
                    echo "Picture updated successfully.";
                } else {
                    echo "Error updating picture: " . $stmt->error;
                }

            }
        } else {
            echo "<h3>Error uploading image!</h3>";
        }
    } else {
        $picture = null;
        echo "<h3>No image uploaded!</h3>";
    }

    
    if(!empty($fullname) && !empty($email) && !empty($password)){
        $sql = "UPDATE users SET fullname='$fullname', email='$email', password = '$password' WHERE id='$user_id'";
        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully.";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

    header("location: ./index.php");
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">


    <title>Dashboard</title>
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
            

            <?php include('./components/sidebar.php') ?>

            <div class="main">
                <?php include('./components/header.php') ?>

                <div class="page">
                    <div class="profile_wrapper">
                        <div class="main-prof">
                            <div class="prof_left">
                                <form method="post" enctype="multipart/form-data">
                                <div class="prof_pic">
                                    <img src="./../assets/<?= htmlspecialchars($row['picture']) ?>" alt="">
                                </div>
                                <table class="table mt-4 table-borderless w-100">
                                    <tr>
                                        <th>Name</th>
                                        <td><input type="text" class="form-control shadow-none ps-4" id="" aria-describedby="emailHelp" value="<?= $row['fullname'] ?>" name="fullname"></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>
                                            <input type="email" class="form-control shadow-none ps-4" id="" aria-describedby="emailHelp" value="<?= $row['email'] ?>" name="email">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Password</th>
                                        <td>
                                            <div class="input-group">
                                                <input type="password" class="form-control shadow-none ps-4" id="password" value="<?= $row['password'] ?>" name="password">
                                                <span class="input-group-text">
                                                    <i class="fas fa-eye" id="togglePassword" style="cursor: pointer;"></i>
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Picture</th>
                                        <td><input class="form-control shadow-none" name="picture" type="file" id="formFile">
                                        </td>
                                    </tr>
                                </table>
                                <button id="btn_update" name="btn_update" class="btn btn-warning w-100 mb-2">Update</button>
                                </fo>
                            </div>
                        </div>

                        <?php 
                            $sql = "SELECT 
                                SUM(CASE WHEN remarks = 'Present' THEN 1 ELSE 0 END) AS present_count,
                                SUM(CASE WHEN remarks = 'Absent' THEN 1 ELSE 0 END) AS absent_count,
                                SUM(CASE WHEN remarks = 'Late' THEN 1 ELSE 0 END) AS late_count,
                                COUNT(*) AS total_count
                                FROM 
                                    attendance
                                WHERE teacher_id = '$user_id'";
                            
                            $result = $conn->query($sql);
                            
                            if ($result) {
                                $row = $result->fetch_assoc();

                                $present_count = $row['present_count'];
                                $absent_count = $row['absent_count'];
                                $late_count = $row['late_count'];
                                $total_count = $row['total_count'];

                                // Calculate active (present + late) and inactive (absent)
                                $active_count = $present_count + $late_count;
                                $inactive_count = $absent_count;




                                // CALCULATE NATO ANF PERCENTAGE
                                // $active_percentage = $total_count > 0 ? ($active_count / $total_count) * 100 : 0;
                                // $inactive_percentage = $total_count > 0 ? ($inactive_count / $total_count) * 100 : 0;

                                // echo "Active (Present + Late): " . $active_count . " (" . round($active_percentage, 2) . "%)<br>";
                                // echo "Inactive (Absent): " . $inactive_count . " (" . round($inactive_percentage, 2) . "%)<br>";
                            ?>
                        <div class="sub-sched">
                            <div class="subs py-4">
                                <div class="border-end px-4">
                                    <h2 class="mt-4"><span class="badge text-bg-success d-block w-100">Present</span></h2>
                                    <p class="form-text text-center">Total present</p>
                                    <h1 class="text-center mt-4 fs-1 fw-bold text-dark"><?php if($row['present_count']==""){
                                        echo "0";  }else{echo $row['present_count'];}?>
                                    </h1>
                                </div>
                                <div class="px-4">
                                    <h2 class="mt-4"><span class="badge text-bg-danger d-block w-100">Absent</span></h2>
                                    <p class="form-text text-center">Total absent</p>
                                    <h1 class="text-center mt-4 fs-1 fw-bold text-dark"><?php if($row['absent_count']==""){
                                        echo "0";  }else{echo $row['absent_count'];}?></h1>
                                </div>
                                <div class="border-start px-4">
                                    <h2 class="mt-4"><span class="badge text-bg-secondary d-block w-100">Late</span></h2>
                                    <p class="form-text text-center">Total late</p>
                                    <h1 class="text-center mt-4 fs-1 fw-bold text-dark"><?php if($row['late_count']==""){
                                        echo "0";  }else{echo $row['late_count'];}?></h1>
                                </div>
                            </div>
                            <div class="scheds">
                                <h2 class="m-0 text-center">Activeness percentage</h2>
                                <div class="chart" class="mx-auto">
                                    <canvas id="myChart"></canvas>
                                    <h2 id="noDataMessage" style="display: none;">No Data Yet</h2>
                                </div>
                        </div>
                        <?php 
                            } else {
                                echo "Error: " . $conn->error;
                            }
                            $conn->close();
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
<script src="./../scripts/user.js"></script>
<script src="https://cdn.jsdelivr.net/npm/hystmodal@1.0.1/dist/hystmodal.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const myModal = new HystModal({
        linkAttributeName: "data-hystmodal"
    });

    const btn_cancel = document.querySelectorAll('.btn_cancel')
    const modal = document.getElementById('logout')

    console.log(btn_cancel)

    btn_cancel.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault()
            myModal.close(modal);
        })
    })
</script>
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
      const passwordField = document.getElementById('password');
      const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordField.setAttribute('type', type);
      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    });
  </script>
  <script>
    const dgh = document.getElementById('myChart');

    let active = <?= !empty($active_count) ? (int)$active_count : 0 ?>;
    let inactive = <?= !empty($inactive_count) ? (int)$inactive_count : 0 ?>;


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
                    // 'rgb(220, 53, 69)'
                ],
                hoverOffset: 4
            }]
        }
    });
    }else{
        new Chart(dgh, {
        type: 'doughnut',
        data: {
            labels: [
                'Active (Present + Late)',
                'Inactive (Absent)',
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
        }
    });
    }


    
   
  </script>
</html>