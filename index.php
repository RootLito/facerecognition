<?php 
include('./config/conn.php')
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="./styles/font.css">

    <title>Home</title>
</head>
<body>
    <div class="container">
        <div class="nav d-flex justify-content-between py-3">
            <h2>Logo</h2>
            <div class="auth">
                <a href="./auth/reg.php" class="btn btn-primary">Register</a>
                <button class="btn btn-secondary">Log in</button>
            </div>
        </div>
        <h2 class="text-center">Hello World</h2>
    </div>
</body>
</html>