<?php
session_start();
include('./../config/conn.php');

$sql_subs = "SELECT scheds.tch_name AS tch_name, scheds.year_section AS ys, scheds.day AS day, scheds.time_in AS time_in, scheds.time_out AS time_out,subs.code AS code, subs.name AS name, scheds.in_remark AS in_remark, scheds.out_remark AS out_remark
FROM subs
JOIN scheds
ON scheds.sub_id = subs.sub_id";
$res = mysqli_query($conn, $sql_subs);

if (!$res) {
    die("Error executing query: " . mysqli_error($conn));
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="./../styles/admin.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/hystmodal@1.0.1/dist/hystmodal.min.css" rel="stylesheet">



    <title>Schedules</title>
</head>

<body>
    <div class="panel">
        <div class="wrapper">
            <?php include('./components/sidebar.php') ?>

            <div class="main">
                <?php include('./components/header.php') ?>
                <div class="page">
                    <div class="as_wrapper">
                        <div class="ast d-flex justify-content-between align-items-center">
                            <h2 class="m-0">Attendace and Schedules</h2>
                        </div>
                        <div class="as">
                            <table class="table table-hover table-borderless">
                                <thead class="fs-5">
                                    <tr>
                                        <th scope="col">Teacher Name</th>
                                        <th scope="col">Subject</th>
                                        <th scope="col">Day</th>
                                        <th scope="col">Year & Section</th>
                                        <th scope="col">Time In</th>
                                        <th scope="col">Time Out</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    <?php
                                    if (mysqli_num_rows($res) > 0) {
                                        while ($row = mysqli_fetch_assoc($res)) {
                                    ?>
                                        <div class="hystmodal" id="data-hystmodal" aria-hidden="true">
                                            <div class="hystmodal__wrap">
                                                <div class="hystmodal__window p-4 rounded" role="dialog" aria-modal="true">
                                                    <button data-hystclose class="hystmodal__close">Закрыть</button>
                                                    <div class="top mb-2">

                                                        <h4 class="m-0 mb-5 text-dark">Edit schedule</h4>

                                                        <form action="" method="post">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" name="tch_name" class="form-control shadow-none" id="floatingInput" placeholder="Fullname" value="<?=$row['code'] . " - " . $row['name']?>" required>
                                                                <label for="floatingInput">Subject</label>
                                                            </div>
                                                            <div class="form-floating mb-3">
                                                                <input type="text" name="tch_name" class="form-control shadow-none" id="floatingInput" placeholder="Fullname" value="<?= $row['day'] ?>" required>
                                                                <label for="floatingInput">Day</label>
                                                            </div>
                                                            <div class="form-floating mb-3">
                                                                <input type="text" name="tch_name" class="form-control shadow-none" id="floatingInput" placeholder="Fullname" value="<?= $row['ys'] ?>" required>
                                                                <label for="floatingInput">Section</label>
                                                            </div>
                                                            <div class="form-floating mb-3">
                                                                <input type="text" name="tch_name" class="form-control shadow-none" id="floatingInput" placeholder="Fullname" value="<?= $row['time_in']?>" required>
                                                                <label for="floatingInput">Time in</label>
                                                            </div>
                                                            <div class="form-floating mb-3">
                                                                <input type="text" name="tch_name" class="form-control shadow-none" id="floatingInput" placeholder="Fullname" value="<?= $row['time_out'] ?>" required>
                                                                <label for="floatingInput">Time out</label>
                                                            </div>

                                                        <button class="btn_vp w-100" name="tch_update">Save</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            <tr>
                                                <th><?= $row['tch_name'] ?></th>
                                                <td><?= $row['code'] . " - " . $row['name'] ?></td>
                                                <td><?= $row['day'] ?></td>
                                                <td><?= $row['ys'] ?></td>
                                                <td><?= $row['time_in'] ?>
                                                    <?= $row['in_remark'] == "present" ? '<span class="badge bg-success">Done</span></td>' :  '<span class="badge bg-danger"> ... </span></td>' ?>
                                                <td><?= $row['time_out'] ?>
                                                    <?= $row['out_remark'] == "Out" ? '<span class="badge bg-success">Done</span></td>' :  '<span class="badge bg-danger"> ... </span></td>' ?>
                                                </td>
                                                <td>
                                                    <a href="" data-hystmodal="#data-hystmodal" class="text-decoration-none text-light bg-dark rounded p-2 px-3"><i class="lni lni-pencil me-2"></i>Edit</a>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        // echo "<h2 class='text-center mx-auto fs-3'> No subjects handled yet </h2>";
                                    }
                                    ?>
                                </tbody>
                            </table>
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
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/gridjs/dist/gridjs.umd.js"></script>
<script src="https://cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/hystmodal@1.0.1/dist/hystmodal.min.js"></script>
<script>
    const myModal = new HystModal({
        linkAttributeName: "data-hystmodal"
    });
</script>
<script>
    let table = new DataTable('#myTable');
</script>
<script>
    new gridjs.Grid({
        columns: ["Name", "Email", "Phone Number"],
        data: [
            ["John", "john@example.com", "(353) 01 222 3333"],
            ["Mark", "mark@gmail.com", "(01) 22 888 4444"],
            ["Eoin", "eoin@gmail.com", "0097 22 654 00033"],
            ["Sarah", "sarahcdd@gmail.com", "+322 876 1233"],
            ["Afshin", "afshin@mail.com", "(353) 22 87 8356"]
        ],
        search: true,
        sort: true,
        pagination: {
            limit: 2,
            summary: false
        }
    }).render(document.getElementById("tbl"));
</script>

</html>