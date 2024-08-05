<?php
include('./../config/conn.php');


if (isset($_POST['btn_reg'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $picture = $_FILES['picture']["name"];
    $tempname = $_FILES["picture"]["tmp_name"];
    $folder = "./../assets/" . $tempname;


    if (move_uploaded_file($tempname, $folder)) {
        echo "<h3>Image uploaded successfully!</h3>";

        $stmt = $conn->prepare("INSERT INTO users (fullname, email, password, picture) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $password, $picture);

        if ($stmt->execute()) {
            echo "<h3>Registered successfully!</h3>";
        } else {
            echo "<h3>Failed to register user: " . $stmt->error . "</h3>";
        }

        $stmt->close();
    } else {
        echo "<h3>Failed to upload image!</h3>";
    }
}

$conn->close();
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

    <title>Create account</title>
</head>

<body>
    <div class="panel">
        <div class="wrapper">
            <div class="cover">
                <div class="tag d-flex flex-column justify-content-center align-items-center">
                    <i class="lni lni-grid-alt fs-1"></i>
                    <h2 class="fw-normal mt-3">CLASSKOTO</h2>
                </div>
            </div>
            <div class="creds p-5 position-relative">
                <h3 class="text-center mb-4">Register</h3>
                <p class="form-text text-center mb-4">Please provide clear image and fill up all the information below to create an account.</p>

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
                    <button class="btn btn-dark d-flex align-items-center justify-content-center px-3 py-2 mb-5 w-100" name="btn_reg">Proceed </button>
                </form>

                <p class="form-text position-absolute bottom-0 start-50 translate-middle">Developed by <i class="text-danger">Jeshua Lopez</i></p>
            </div>
            
        </div>
    </div>
</body>

</html>