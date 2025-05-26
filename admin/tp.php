<?php
include('./../config/conn.php');


if (isset($_POST['btn_reg'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $picture = $_FILES['picture']["name"];
    $tempname = $_FILES["picture"]["tmp_name"];
    $folder = "./../assets/" . basename($picture);


    if (move_uploaded_file($tempname, $folder)) {
        echo "<h3>Image uploaded successfully!</h3>";

        $stmt = $conn->prepare("INSERT INTO users (fullname, email, password, picture) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $password, $picture);

        if ($stmt->execute()) {
            echo "<h3>Registered successfully!</h3>";
        } else {
            echo "<h3>Failed to register user: " . $stmt->error . "</h3>";
        }

        $stmt->close();
    } else {
        echo "<h3>Failed to upload image!</h3>";
    }
}


// mga teacher ni diri gikan sa database
$sql_tch = "SELECT * FROM users";
$tch_res = mysqli_query($conn, $sql_tch);
// $tch_row = mysqli_fetch_assoc($tch_res);

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
                    <div class="att_wrapper">
                        <div class="tch d-flex justify-content-between align-items-center">
                            <h2 class="m-0">Teachers Profile</h2>
                            <button id="btn_tch" class="d-flex justify-content-between align-items-center" data-hystmodal="#myModal"><i class="lni lni-plus me-2"></i> Add Teacher </button>
                            <div class="hystmodal" id="myModal" aria-hidden="true">
                                <div class="hystmodal__wrap">
                                    <div class="hystmodal__window p-4 rounded" role="dialog" aria-modal="true">
                                        <button data-hystclose class="hystmodal__close"></button>
                                        <div class="top mb-4">
                                            <h4 class="m-0">Add new teacher</h4>
                                            <p class="form-text">Create new teacher account</p>
                                        </div>

                                        <form method="post" enctype="multipart/form-data">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="name" class="form-control shadow-none" id="floatingInput" placeholder="name@example.com" required>
                                                <label for="floatingInput">Full name</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="email" name="email" class="form-control shadow-none" id="floatingInput" placeholder="name@example.com" required>
                                                <label for="floatingInput">Email address</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="password" name="password" class="form-control shadow-none" id="floatingPassword" placeholder="Password" required>
                                                <label for="floatingPassword">Password</label>
                                            </div>
                                            <div class="mb-3">
                                                <input class="form-control shadow-none" name="picture" type="file" id="formFile" required>
                                            </div>
                                            <button id="btn_nt" class="btn d-flex align-items-center justify-content-center px-3 py-2 mb-2 w-100" name="btn_reg">Proceed </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="rooms">
                            <?php
                            if (mysqli_num_rows($tch_res) > 0) {
                                while ($tch_row = mysqli_fetch_assoc($tch_res)) {
                            ?>
                                    <div class="room">
                                        <div class="tch_pic">
                                            <img src="./../assets/<?= $tch_row['picture'] ?>" alt="">
                                        </div>
                                        <form class="tch_info w-100" method="post">
                                            <h4 class="m-0 fs-5 text-center"><?= $tch_row['fullname'] ?></h4>
                                            <!-- <p class="text-center d-flex justify-content-center"><small class="text-center">SUBJECTS HANDLED <span class="badge text-bg-success fs-6">4</span></small></p> -->
                                            <a href="./teacher.php?teacher_id=<?= $tch_row['id'] ?>" class="w-100 my-2 d-block text-center text-decoration-none" id="btn_vp">View</a>
                                        </form>
                                    </div>
                            <?php
                                }
                            } else {
                                echo "<h2 class='text-center mx-auto fs-3'> No teacher registered </h2>";
                            } ?>
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