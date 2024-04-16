<?php
require_once __DIR__ . '/../DB/connect.php';

if (!session_status() == PHP_SESSION_ACTIVE) {
    session_start();
}

function calculateDaily()
{
    GLOBAL $db;
    $meterId = $_SESSION['meter'];
    $currentDate = date('Y-m-d');

    $sql = "SELECT 
                max(meter_number) - min(meter_number)  as num
            FROM transaction_meter
            where meter_serial = ? and SUBSTRING(input_timestamp,1,10) = ?
            order by SUBSTRING(input_timestamp,1,10) asc";
    $stmt = $db->prepare($sql);
    $stmt->execute([$meterId, $currentDate]);

    return $stmt->fetch(PDO::FETCH_ASSOC)["num"];
}

function calculateMonthly()
{
    GLOBAL $db;
    $meterId = $_SESSION['meter'];
    $currentMonth = date('m');

    $sql = "SELECT 
                max(meter_number) - min(meter_number)  as num
            FROM transaction_meter
            where meter_serial = ? and SUBSTRING(input_timestamp,6,2) = ?
            order by SUBSTRING(input_timestamp,6,2) asc";
    $stmt = $db->prepare($sql);
    $stmt->execute([$meterId, $currentMonth]);

    return $stmt->fetch(PDO::FETCH_ASSOC)["num"];
}

function calculateReport()
{
    GLOBAL $db;
    $sql = "SELECT SUM(data_status = 'REPORT') as ans FROM transaction_meter";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC)["ans"];
}

function calculateAllMonthly()
{
    GLOBAL $db;
    // $meterId = $_SESSION['meter'];
    $currentMonth = date('m');

    $sql = "SELECT 
                max(meter_number) - min(meter_number)  as num
            FROM transaction_meter
            where  SUBSTRING(input_timestamp,6,2) = ?
            order by SUBSTRING(input_timestamp,6,2) asc";
    $stmt = $db->prepare($sql);
    $stmt->execute([$currentMonth]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}