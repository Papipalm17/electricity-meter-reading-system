<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Sarabun:wght@400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../../style/StyleNavbar.css">
</head>

<?php


include '../../DB/connect.php';

?>

<body>
    <nav>
        <div class="page">
                    <a class="nav-link" href="Home.php">Home</a>
                    <a class="nav-link" href="Report.php">Report</a>
        </div>
        <div class="log-out">
            <a href="../logout.php"><img src="../../icon/logout.png" id="img-logout"></a>
        </div>
    </nav>
    <div id="line1"></div>
    <div id="line2"></div>
    <div id="line3"></div>
