<?php
if(session_status() != PHP_SESSION_ACTIVE){
session_start();

}

// ตรวจสอบว่ามีเซสชันล็อกอินหรือไม่
if (!isset($_SESSION['login']) || $_SESSION['login'] !== 1) {
    // ถ้าไม่มีการล็อกอิน ให้ redirect ไปยังหน้าล็อกอินหรือหน้าอื่น ๆ ตามที่คุณต้องการ
    header("Location: ../login.php");
    exit();
}
?>