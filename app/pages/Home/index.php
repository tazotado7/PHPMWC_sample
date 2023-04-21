<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <h1>Hello, world! my name is tamaz </h1>

    <div class="container">
        <ul class="list-group">
           <a class="list-group-item" href="<?php echo URL; ?>">home</a>
           <a class="list-group-item" href="<?php echo URL; ?>users/profile">profile</a>
           <a class="list-group-item" href="<?php echo URL; ?>users/login">login</a>
           <a class="list-group-item" href="<?php echo URL; ?>users/register">register</a>
           <a class="list-group-item" href="<?php echo URL; ?>users/logout">logout</a>
           <a class="list-group-item" href="<?php echo URL; ?>users/reset">reset</a>
        </ul>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>

</html>