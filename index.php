<?php
session_start();
include('./config/conn.php');
require './vendor/autoload.php';

function generateOTP() {
    return rand(100000, 999999);
}

function sendOTPEmail($email, $otp) {
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'jeshuapalma04@gmail.com';
        $mail->Password   = 'fgce qygi vaah vqhg';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
        $mail->setFrom($email);
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'OTP Verification';
        $mail->Body    = 'Your OTP is: ' . $otp;
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if (isset($_POST['btn_login'])) {
    $role = $_POST['role'];
    $email = $_POST['email'];
    $password = $_POST['password'];


//admin log in ni diri
    if ($role == 'admin') {
        $sql = "SELECT * FROM admin WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['admin_id'] = $row['admin_id'];
            header('location: ./admin/index.php');
        } else {
            echo "ERROR: No matching records found.";
        }
        $stmt->close();
    }


// diri kay teacher log in 
    if ($role == 'teacher') {
        $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['user_id'] = $row['id'];

            //otp ni diri
            $otp = generateOTP();
            $_SESSION['otp'] = $otp;
        
            if (sendOTPEmail($email, $otp)) {
                header('location: ./otp.php');
            } else {
                echo "error";
            }

        } else {
            echo "ERROR: No matching records found.";
        }
        
        $stmt->close();
    }
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
                <h3 class="text-center mb-2">Login</h3>
                <p class="form-text text-center mb-4">Provide credentials to log in to your account.</p>
                <form action="" method="post">
                    <select name="role" class="form-select py-3 mb-3 shadow-none" required>
                        <option value="" selected disabled>Select role</option>
                        <option value="admin">Admin</option>
                        <option value="teacher">Teacher</option>
                    </select>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control shadow-none" id="floatingInput" name="email" placeholder="Email address" required>
                        <label for="floatingInput">Email address</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control shadow-none" id="floatingPassword" name="password" placeholder="Password" required>
                        <label for="floatingPassword">Password</label>
                    </div>
                    <button class="w-100 mt-2" id="btn" name="btn_login">Login</button>
                    <a href="./auth/reg.php" class="btn btn-primary w-100 mt-2" id="btn_reg">Register</a>
                </form>
                <p class="form-text position-absolute bottom-0 start-50 translate-middle">Developed by <i class="text-danger">Jeshua Lopez</i></p>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ...
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Understood</button>
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