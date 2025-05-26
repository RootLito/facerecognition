<?php
session_start();
include('./config/conn.php');

if($_SESSION['user_id'] != "") {
    $user_id = $_SESSION['user_id'];
    $otp =  $_SESSION['otp'];

    echo $otp;

    if(isset($_POST['btn_verify'])){
        $otp_input = $_POST['otp'];
        if($otp_input == $otp){
            header('location: ./user/index.php');
        }else{
            echo "error";
        }
    }
}else{
    header('location: ./index.php');
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

    <link rel="stylesheet" href="./styles/auth.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />

    <title>Login</title>
</head>

<body>
    <div class="panel">
        <div class="wrapper">
            <div class="cover">
                <div class="tag d-flex flex-column justify-content-center align-items-center">
                    <i class="lni lni-grid-alt fs-1 mb-3"></i>
                    <h2 class="fw-normal">CLASSKOTO</h2>
                </div>
            </div>
            <div class="creds p-5 position-relative">
                <h3 class="text-center mb-2">OTP Verification</h3>
                <p class="form-text text-center mb-4">Please provide the one-time password we have sent.</p>
                <form action="" method="post">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control shadow-none" id="floatingPassword" placeholder="OTP" name="otp" required>
                        <label for="floatingPassword">ENTER 6-DIGIT CODE</label>
                    </div>
                    <button class="w-100 mt-2" id="btn" name="btn_verify">Verify</button>
                </form>
                <p class="form-text position-absolute bottom-0 start-50 translate-middle">Developed by <i class="text-danger">Jeshua Lopez</i></p>
            </div>
        </div>
    </div>
</body>
</script>
</html>