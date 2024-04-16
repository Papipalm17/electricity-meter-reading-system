<?php

require_once '../DB/connect.php';
session_start();

// รับค่า user_id จาก AJAX request
$user_id = $_GET['user_id'];

// สร้างคำสั่ง SQL เพื่อลบข้อมูล
$sql = "DELETE FROM tb_user WHERE user_id = :user_id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

// ทำการลบข้อมูล
if ($stmt->execute()) {
    echo "ลบข้อมูลเรียบร้อยแล้ว";
} else {
    echo "เกิดข้อผิดพลาดในการลบข้อมูล";
}

?>