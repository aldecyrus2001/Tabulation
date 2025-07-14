<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../Vendor/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <script src="../../Vendor/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="d-flex main-container justify-content-center align-items-center">
        <div class="d-flex border bg-white rounded justify-content-between align-items-center">
            <div class="d-flex justify-content-center">
                <img src="./Assets/Logo.png" alt="">
            </div>
            <div style="width: 1px; height: 330px; background-color: gray;"></div>
            <div class="p-5 gap-3 d-flex flex-column rounded">
                <div class="text-center">
                    <h3>Login Form</h3>
                </div>
                <form action="./Backend/login.php" method="POST" class="d-flex gap-3 flex-column">
                    <div class="">
                        <label for="">Username</label>
                        <input type="text" class="form-control" name="username">
                    </div>
                    <div class="">
                        <label for="">Password</label>
                        <input type="password" class="form-control" name="password">
                    </div>
                    <button type="submit" class="border py-2 rounded bg-primary text-white">Login</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>