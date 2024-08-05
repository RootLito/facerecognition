<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="./../styles/admin.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css" rel="stylesheet" />


    <title>Schedules</title>
</head>

<body>
    <div class="panel">
        <div class="wrapper">
            <?php include('./components/sidebar.php') ?>

            <div class="main">
                <?php include('./components/header.php') ?>

                <div class="page">
                    <div class="as">
                        <H2 class="mt-2">Attendace and Schedules</H2>
                        <table class="table table-hover table-borderless" id="myTable">
                            <thead>
                                <tr>
                                    <th scope="col">Teacher Name</th>
                                    <th scope="col">Subject</th>
                                    <th scope="col">Day</th>
                                    <th scope="col">Year & Section</th>
                                    <th scope="col">Time In</th>
                                    <th scope="col">Time Out</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <tr>
                                    <th>R. Restauro</th>
                                    <td>ITP-323</td>
                                    <td>Monday</td>
                                    <td>BSIT-2B</td>
                                    <td>1pm <span class="badge text-bg-success">Done</span></td>
                                    <td>3pm <span class="badge text-bg-success">Done</span></td>
                                </tr>
                                <tr>
                                    <th>N. Panaligan</th>
                                    <td>ITP-324</td>
                                    <td>Tuesday</td>
                                    <td>BSIT-1C</td>
                                    <td>1pm <span class="badge text-bg-success">Done</span></td>
                                    <td>3pm <span class="badge text-bg-danger">Done</span></td>
                                </tr>
                                <tr>
                                    <th>R. Perito</th>
                                    <td>ITP-321</td>
                                    <td>Wednesday</td>
                                    <td>BSIT-3A</td>
                                    <td>1pm <span class="badge text-bg-danger">Done</span></td>
                                    <td>3pm <span class="badge text-bg-success">Done</span></td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div> -->
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>
<script>
    let table = new DataTable('#myTable');
</script>

</html>