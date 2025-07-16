<?php
session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: ../../login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../Vendor/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <script src="../../Vendor/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../CSS/styles.css">
</head>

<body>
    <div>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Tabulation</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Sheets
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="../Screen/Sheet1.php">Class Dance</a></li>
                                <li><a class="dropdown-item" href="../Screen/Sheet2.php">Dance Battle</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Other
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="../../Backend/logout.php">Logout</a></li>

                            </ul>
                        </li>

                    </ul>
                    <label for="" class="pe-4">
                        <?php echo $_SESSION['firstname'] . ' ' . $_SESSION['lastname']; ?>
                    </label>

                </div>
            </div>
        </nav>
    </div>
    <img src="../../Assets/Logo.png" class="logo" alt="" style="position:fixed; z-index: -1; top:50%; left:50%;transform: translate(-50%, -50%); opacity: 5%; width:500px;">
