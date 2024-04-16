<!DOCTYPE html>
<html lang="en">

<?php 
    $rootPath = str_replace("\\frontend\layouts","",__DIR__);
    $layoutsPath =  $rootPath . "\\frontend\layouts";
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Sarabun:wght@400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../../style/StyleNavbar.css">

    <?php include_once $layoutsPath . "\css.php" ?>

    <!-- js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
     <!-- jQuery -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>

<?php

session_start();
include '../../DB/connect.php';

?>

<body>

<?php 
    include_once $layoutsPath .  "\\navbar_admin.php";
?>