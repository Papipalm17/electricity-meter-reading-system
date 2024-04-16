<?php
//ms sql
// $servername = "sqlsrv:Server=NARUEMON\SQLEXPRESS;Database=DB_Project";
// $username = null;
// $password = null;

$servername = "mysql:host=localhost;dbname=electric_meter_db";
$username = "root"; // ใส่ชื่อผู้ใช้ MySQL ของคุณที่นี่
$password = ""; // ใส่รหัสผ่าน MySQL ของคุณที่นี่

try {
    $db = new PDO($servername, $username, $password);
    // set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$rootPath = str_replace("\DB","",__DIR__);
include($rootPath . '\backend\Mail.php');

$mail = new SendMail($db);
// echo "Connected Success";
