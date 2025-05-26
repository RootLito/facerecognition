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

$sql_subs = "SELECT subs.code AS code, subs.name AS name 
    FROM subs
    JOIN scheds
    ON scheds.sub_id = subs.sub_id
    WHERE scheds.teacher_id = $user_id";
$res = mysqli_query($conn, $sql_subs);

if (!$res) {
    die("Error executing query: " . mysqli_error($conn));
}

if(isset($_POST['btn_logout'])){
    echo "eyyyy";
    unset($_SESSION['user_id']);
    header('location: ./../index.php');
}

mysqli_close($conn);
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


    <title>Subjects</title>
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
            <?php include('./components/sidebar.php') ?>

            <div class="main">
                <?php include('./components/header.php') ?>

                <div class="page">
                    <div class="sub_wrapper">
                        <div class="sub_title">
                            <h2 class="m-0">Subjects</h2>
                        </div>
                        <div class="all_sub">
                            <?php 
                                if (mysqli_num_rows($res) > 0) {
                                    while($row = mysqli_fetch_assoc($res)){
                                ?>
                                <div class="sub_details">
                                    <h2><span class="badge text-bg-success"><?=$row['code']?></span></h2>
                                    <h4 class="m-0 fs-5 text-center"><?=$row['name']?></h4>
                                </div>

                            <?php
                                    }
                                }else{
                                    // echo "<h2 class='text-center mx-auto fs-3'> No subjects handled yet </h2>";
                                }
                            ?>
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

    const btn_cancel =document.querySelectorAll('.btn_cancel')
    const modal =document.getElementById('logout')

    console.log(btn_cancel)

    btn_cancel.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault()
            myModal.close(modal);  
        })
    })
</script>
</html>