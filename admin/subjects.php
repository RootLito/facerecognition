<?php
include('./../config/conn.php');


if (isset($_POST['btn_sub'])) {
    $code = $_POST['code'];
    $name = $_POST['name'];

    $stmt = $conn->prepare("INSERT INTO subs (code, name) VALUES (?, ?)");
    $stmt->bind_param("ss", $code, $name);

    if ($stmt->execute()) {
        $status = 'success';
        $message = "New subject added";
    } else {
        $status = "error";
        $message = "Failed to add" . $stmt->error;
    }

    $stmt->close();
}

// // mga subjects ni diri gikan sa database
$sql_sub = "SELECT * FROM subs";
$sub_res = mysqli_query($conn, $sql_sub);
// $sub_row = mysqli_fetch_assoc($sub_res);

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


    <title>Subjects</title>
</head>

<body>
    <div class="panel">
        <div class="wrapper">
            <?php include('./components/sidebar.php') ?>

            <div class="main">
                <?php include('./components/header.php') ?>

                <div class="page">
                    <div class="subs_wrapper">
                        <div class="tch d-flex justify-content-between align-items-center">
                            <h2 class="m-0">Subjects</h2>
                            <button id="btn_tch" class="d-flex justify-content-between align-items-center" data-hystmodal="#myModal"><i class="lni lni-plus me-2"></i> Add Subjects </button>
                            <div class="hystmodal" id="myModal" aria-hidden="true">
                                <div class="hystmodal__wrap">
                                    <div class="hystmodal__window p-4 rounded" role="dialog" aria-modal="true">
                                        <button data-hystclose class="hystmodal__close"></button>
                                        <div class="top mb-4">
                                            <h4 class="m-0">Add new subject</h4>
                                            <p class="form-text">Create new subject</p>
                                        </div>

                                        <form method="post" enctype="multipart/form-data">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="code" class="form-control shadow-none" id="floatingInput" placeholder="code" required>
                                                <label for="floatingInput">Code</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="text" name="name" class="form-control shadow-none" id="floatingInput" placeholder="name" required>
                                                <label for="floatingInput">Name</label>
                                            </div>
                                            <button id="btn_nt" class="btn d-flex align-items-center justify-content-center px-3 py-2 mb-2 w-100" name="btn_sub">Proceed </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="subs">
                            <?php 
                                if(mysqli_num_rows($sub_res) > 0){
                                    while($sub_row = mysqli_fetch_assoc($sub_res)){
                            ?>
                                <div class="sub">
                                    <h2><span class="badge text-bg-success"><?=$sub_row['code']?></span></h2>
                                    <div class="tch_info text-center">
                                        <h4 class="m-0 fs-5 text-center"><?=$sub_row['name']?></h4>
                                    </div>
                                </div>
                            <?php
                                    }
                                }else{
                                    echo "<h2 class='text-center mx-auto fs-3'> No teacher registered </h2>";
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
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