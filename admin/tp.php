<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="./../styles/admin.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />


    <title>Attendance and Schedules</title>
</head>

<body>
    <div class="panel">
        <div class="wrapper">
            <?php include('./components/sidebar.php') ?>

            <div class="main">
                <?php include('./components/header.php') ?>

                <div class="page">
                    <div class="att_wrapper">
                        <div class="rooms">
                            <div class="room">
                                <h2 class="d-flex align-items-center justify-content-center my-3"><i class="lni lni-display me-2"></i>COMLAB 1</h2>
                                <p class="m-0 text-center">KARL VINCENT SURDILLA</p>
                            </div>
                            <div class="room active">
                            <h2 class="d-flex align-items-center justify-content-center my-3"><i class="lni lni-display me-2"></i>COMLAB 2</h2>
                            <p class="m-0 text-center">AVAILABLE</p>
                            </div>
                            <div class="room">
                            <h2 class="d-flex align-items-center justify-content-center my-3"><i class="lni lni-display me-2"></i>COMLAB 3</h2>
                            <p class="m-0 text-center">ROAYDA HASIM</p>
                            </div>

                            <div class="room">
                            <h2 class="d-flex align-items-center justify-content-center my-3"><i class="lni lni-display me-2"></i>COMLAB 3</h2>
                            <p class="m-0 text-center">ROAYDA HASIM</p>
                            </div>

                            <div class="room">
                            <h2 class="d-flex align-items-center justify-content-center my-3"><i class="lni lni-display me-2"></i>COMLAB 3</h2>
                            <p class="m-0 text-center">ROAYDA HASIM</p>
                            </div>

                            <div class="room">
                            <h2 class="d-flex align-items-center justify-content-center my-3"><i class="lni lni-display me-2"></i>COMLAB 3</h2>
                            <p class="m-0 text-center">ROAYDA HASIM</p>
                            </div>

                            <div class="room">
                            <h2 class="d-flex align-items-center justify-content-center my-3"><i class="lni lni-display me-2"></i>COMLAB 3</h2>
                            <p class="m-0 text-center">ROAYDA HASIM</p>
                            </div>

                            <div class="room">
                            <h2 class="d-flex align-items-center justify-content-center my-3"><i class="lni lni-display me-2"></i>COMLAB 3</h2>
                            <p class="m-0 text-center">ROAYDA HASIM</p>
                            </div>
                            
                            <div class="room">
                            <h2 class="d-flex align-items-center justify-content-center my-3"><i class="lni lni-display me-2"></i>COMLAB 3</h2>
                            <p class="m-0 text-center">ROAYDA HASIM</p>
                            </div>

                            <div class="room">
                            <h2 class="d-flex align-items-center justify-content-center my-3"><i class="lni lni-display me-2"></i>COMLAB 3</h2>
                            <p class="m-0 text-center">ROAYDA HASIM</p>
                            </div>



                            <div class="room">
                            <h2 class="d-flex align-items-center justify-content-center my-3"><i class="lni lni-display me-2"></i>COMLAB 4</h2>
                            <p class="m-0 text-center">NEL PANALIGAN</p>
                            </div>
                        </div>
                        <div class="cam-scan">
                            <!-- Scan -->
                            <!-- <div class="modal fade" id="face-scan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ...
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <button class="btn btn-success d-flex align-items-center my-5 px-5" data-bs-toggle="modal" data-bs-target="#face-scan"><i class="lni lni-frame-expand p-2 fs-5"></i>Take Attendance</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>