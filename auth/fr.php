<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="./../styles/font.css">
    <link rel="stylesheet" href="./../styles/cam.css">

    <script defer src="./../dist/face-api.min.js"></script>
    <script defer src="./../scripts/face-reg.js"></script>

    <title>Register</title>
</head>

<body>
    <div class="container">
        <h2 class="text-center py-5">Create Account</h2>
        <p class="text-center">Fill up the inforamtion below</p>

        <div class="cam d-flex justify-content-center">
            <video id="video" autoplay muted></video>
        </div>
        <button id="btn">Proceed</button>
        <!-- Hidden Canvas Element -->
        <canvas id="ccanvas" width="640" height="360" style="display: none;"></canvas>

        <!-- Image Element to Display Captured Frame -->
        <img id="captured-image" alt="Captured Frame" style="display: none;">
    </div>
</body>

</html>