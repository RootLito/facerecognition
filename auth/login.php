<?php 
include('./../config/conn.php')
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="./../styles/auth.css">
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
                <h3 class="text-center mb-4">Login</h3>
                <form action="">
                <div class="form-floating mb-3">
                        <input type="email" class="form-control shadow-none" id="floatingInput" placeholder="name@example.com">
                        <label for="floatingInput">Email address</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control shadow-none" id="floatingPassword" placeholder="Password">
                        <label for="floatingPassword">Password</label>
                    </div>
                    <div class="d-flex">
                    <input type="text" name="" id=""><button class="btn btn-dark d-flex align-items-center justify-content-center px-3"> <i class="lni lni-pointer me-2"></i> Send OTP </button>
                    </div>
                    <button class="btn btn-dark w-100 mt-3">login</button>
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

</html>