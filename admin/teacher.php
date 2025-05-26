<?php
include('./../config/conn.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);


if (isset($_GET['teacher_id'])) {
    $teacher_id = $_GET['teacher_id'];
}

if (isset($_POST['btn_save'])) {
    $user_id = $_GET['teacher_id'];
    $tch_fullname = $_POST['tch_fullname'];
    $sub_id = $_POST['sub'];
    $day = $_POST['day'];
    $year_section = $_POST['year_section'];
    $timei = $_POST['timei'];
    $time_in = $_POST['time_in'];
    $timeo = $_POST['timeo'];
    $time_out = $_POST['time_out'];

    $in = $timei . $time_in;
    $out = $timeo . $time_out;

    $stmt = $conn->prepare("INSERT INTO scheds (teacher_id, tch_name, sub_id, day, year_section, time_in, time_out) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $user_id, $tch_fullname, $sub_id, $day, $year_section, $in, $out);

    if ($stmt->execute()) {
        echo "<h3>Schedule added successfully!</h3>";
    } else {
        echo "<h3>Failed to register user: " . $stmt->error . "</h3>";
    }

    $stmt->close();
}



// mga teacher ni diri gikan sa database
$sql_tch = "SELECT * FROM users WHERE id = $teacher_id";
$tch_res = mysqli_query($conn, $sql_tch);
$tch_row = mysqli_fetch_assoc($tch_res);


// sa subjects  
$sql_sub = "SELECT * FROM subs";
$sub_res = mysqli_query($conn, $sql_sub);



//update teacher
if(isset($_POST['tch_update'])){
    $tch_id = $_GET['teacher_id'];
    $tch_name = $_POST['tch_name'];
    $tch_email = $_POST['tch_email'];
    $tch_pass = $_POST['tch_pass'];

    $stmt_tch = $conn->prepare("UPDATE users SET fullname = ?, email = ?, password = ? WHERE id = ?");
    $stmt_tch->bind_param("sssi", $tch_name, $tch_email, $tch_pass, $tch_id);

    if ($stmt_tch->execute()) {
        // echo "<h3>TEACHER UPDATE - OK</h3>";
        header('location: ./teacher.php?teacher_id=' . $tch_id);
    } else {
        echo "<h3>Failed: " . $stmt_tch->error . "</h3>";
    }
    $stmt_tch->close();
}


//delete teacher
if(isset($_POST['tch_delete'])){
    $tch_id = $_GET['teacher_id'];
    $stmt_tch = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt_tch->bind_param("i", $tch_id);
    $stmt_tch->execute();
    if ($stmt_tch->affected_rows > 0) {
        header('location: ./tp.php');
    } else {
        echo "<h3>Failed: " . $stmt_tch->error . "</h3>";
    }
    $stmt_tch->close();
}


$user_id = $_GET['teacher_id'];
$sql_subs = "SELECT scheds.year_section AS ys, scheds.day AS day, scheds.time_in AS time_in, scheds.time_out AS time_out,subs.code AS code, subs.name AS name 
    FROM subs
    JOIN scheds
    ON scheds.sub_id = subs.sub_id
    WHERE scheds.teacher_id = $user_id";
$res = mysqli_query($conn, $sql_subs);

if (!$res) {
    die("Error executing query: " . mysqli_error($conn));
}
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

    <link rel="stylesheet" href="./../styles/admin.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />


    <title>Teachers Profile</title>
</head>

<body>
    <div class="panel">
        <div class="wrapper">
            <?php include('./components/sidebar.php') ?>

            <div class="main">
                <?php include('./components/header.php') ?>

                <div class="page">

                <!-- UPDATE ---------------->
                <div class="hystmodal" id="update_modal" aria-hidden="true">
                    <div class="hystmodal__wrap">
                        <div class="hystmodal__window p-4 rounded" role="dialog" aria-modal="true">
                            <button data-hystclose class="hystmodal__close">Закрыть</button>
                            <div class="top mb-4">
                                <h4 class="m-0">Update</h4>
                                <p class="form-text">Want to update the teacher?</p>
                            </div>

                            <form method="post" enctype="multipart/form-data">
                                <div class="form-floating mb-3">
                                    <input type="text" name="tch_name" class="form-control shadow-none" id="floatingInput" placeholder="Fullname" value="<?= $tch_row['fullname'] ?>" required>
                                    <label for="floatingInput">Fullname</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="tch_email" class="form-control shadow-none" id="floatingInput" placeholder="Email" value="<?= $tch_row['email'] ?>" required>
                                    <label for="floatingInput">Email</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="tch_pass" class="form-control shadow-none" id="floatingInput" placeholder="Password" value="<?= $tch_row['password'] ?>" required>
                                    <label for="floatingInput">Password</label>
                                </div>

                                <button class="btn_vp w-100" name="tch_update">Update</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- DELETE ---------------->
                <div class="hystmodal" id="delete_modal" aria-hidden="true">
                    <div class="hystmodal__wrap">
                        <div class="hystmodal__window p-4 rounded" role="dialog" aria-modal="true">
                            <button data-hystclose class="hystmodal__close">Закрыть</button>
                            <div class="top mb-4">
                                <h4 class="m-0">Delete</h4>
                                <p class="form-text">Are you sure to delete the teacher <span class="h2 fs-6"><?= $tch_row['fullname'] ?></span> ?</p>
                            </div>

                            <form method="post" enctype="multipart/form-data" class="w-100">
                                <button class="btn btn-danger w-100" name="tch_delete">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>


                    <div class="prof_wrapper">
                        <div class="prof_left">
                            <div class="prof_pic">
                                <img src="./../assets/<?= $tch_row['picture'] ?>" alt="">
                            </div>
                            <form action="#" method="post" class="w-100">
                                <table class="table mt-4 table-borderless">
                                    <tr>
                                        <th>Name</th>
                                        <td><?= $tch_row['fullname'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td><?= $tch_row['email'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Password</th>
                                        <td><?= $tch_row['password'] ?></td>
                                    </tr>
                                </table>
                                <button class="btn_vp w-100 mb-2 mt-2" name="btn_update" data-hystmodal="#update_modal">Update</button>
                                <button class="btn btn-danger w-100 py-2" name="btn_delete" data-hystmodal="#delete_modal">Delete</button>
                            </form>
                        </div>
                        <div class="prof_right">
                            <div class="prof_sub">
                                <h4 class="m-0 mt-2">Subjects Handled</h4>
                                <p class="form-text">List of all subjects</p>

                                <table class="table table-hover table-borderless">
                                    <thead>
                                        <tr>
                                            <th scope="col">Subject</th>
                                            <th scope="col">Day</th>
                                            <th scope="col">Year & Section</th>
                                            <th scope="col">Time In</th>
                                            <th scope="col">Time Out</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                        <?php
                                        if (mysqli_num_rows($res) > 0) {
                                            while ($row = mysqli_fetch_assoc($res)) {
                                        ?>
                                                <tr>
                                                    <td><?= $row['name'] ?></td>
                                                    <td><?= $row['day'] ?></td>
                                                    <td><?= $row['ys'] ?></td>
                                                    <td><?= $row['time_in'] ?></td>
                                                    <td><?= $row['time_out'] ?></td>
                                                </tr>
                                        <?php
                                            }
                                        } else {
                                            // echo "<h2 class='text-center mx-auto fs-3'> No subjects handled yet </h2>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="prof_add">
                                <h4 class="m-0 mt-2">Add subject</h4>
                                <p class="form-text">Add subject to teacher</p>
                                <form method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="tch_fullname" value="<?= $tch_row['fullname'] ?>">
                                    <div class="dropdown mb-2 d-flex gap-2">
                                        <select class="form-select shadow-none w-50" aria-label="Default select example" name="sub" required>
                                            <option value="" selected disabled>Select subject</option>
                                            <?php
                                            if (mysqli_num_rows($sub_res) > 0) {
                                                while ($sub_row = mysqli_fetch_assoc($sub_res)) {
                                            ?>
                                                    <option value="<?= $sub_row['sub_id'] ?>"> <?= $sub_row['code'] . " " . $sub_row['name'] ?> </option>
                                            <?php
                                                }
                                            } else {
                                                echo "<h2 class='text-center mx-auto fs-3'> No teacher subjects yet </h2>";
                                            }
                                            ?>
                                        </select>


                                        <select class="form-select w-50 shadow-none" aria-label="Default select example" name="day" required>
                                            <option value="" selected disabled>Day</option>
                                            <option value="Monday">Monday</option>
                                            <option value="Tuesday">Tuesday</option>
                                            <option value="Wednesday">Wednesday</option>
                                            <option value="Thursday">Thursday</option>
                                            <option value="Friday">Friday</option>
                                        </select>

                                        <input type="text" class="form-control shadow-none w-50" id="ys" placeholder="Year and Section" required name="year_section">
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-text m-0 mt-3">Use this format eg. 1:30</p>
                                        <div class="input-group">
                                            <input type="text" aria-label="First name" class="form-control shadow-none" name="timei" required>
                                            <select class="form-select shadow-none" aria-label="Default select example" name="time_in" required>
                                                <option value="" selected disabled>Time in</option>
                                                <option value="AM">AM</option>
                                                <option value="PM">PM</option>
                                            </select>
                                            <input type="text" aria-label="Last name" class="form-control shadow-none" name="timeo" required>
                                            <select class="form-select shadow-none" aria-label="Default select example" name="time_out" required>
                                                <option value="" selected disabled>Time out</option>
                                                <option value="AM">AM</option>
                                                <option value="PM">PM</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button id="btn_nt" class="btn d-flex align-items-center justify-content-center px-3 py-2 mb-2 w-100 mt-4" name="btn_save"> Save </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/hystmodal@1.0.1/dist/hystmodal.min.js"></script>
<script>
    const myModal = new HystModal({
        linkAttributeName: "data-hystmodal"
    });
</script>

</html>