<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="./../styles/admin.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />


    <title>Home - User</title>
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
                                    <h2 class="m-0">12</h2>
                                    <p class="m-0">Total teacher</p>
                                </div>
                                <div class="icon">
                                    <i class="lni lni-users fs-1"></i>
                                </div>
                            </div>
                            <div class="box">
                                <div class="inf">
                                    <h2 class="m-0">7</h2>
                                    <p class="m-0">Total subjects</p>
                                </div>
                                <div class="icon">
                                    <i class="lni lni-display fs-1"></i>
                                </div>
                            </div>
                            <div class="box">
                                <div class="inf">
                                    <h2 class="m-0">Add</h2>
                                    <p class="m-0">Add new teacher</p>
                                </div>
                                <div class="icon">
                                    <i class="lni lni-plus fs-1"></i>
                                </div>
                            </div>
                        </div>
                        <div class="graph">
                            <div class="visual">
                                <h2 class="m-0 ms-2">Attendance</h2>
                                <p class="m-0 ms-2 mb-3 form-text">This shows the eacher attendace</p>
                                <canvas id="myChart"></canvas>
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

<script>
    const ctx = document.getElementById('myChart');
    const dgh = document.getElementById('dgh');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green'],
            datasets: [{
                label: '# of Votes',
                data: [12, 3, 5, 1],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    new Chart(dgh, {
        type: 'doughnut',
        data: {
            labels: [
                'Active',
                'Inactive',
            ],
            datasets: [{
                label: 'Activeness',
                data: [18,2],
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)'
                ],
                hoverOffset: 4
            }]
        },
        
    });
</script>

</html>