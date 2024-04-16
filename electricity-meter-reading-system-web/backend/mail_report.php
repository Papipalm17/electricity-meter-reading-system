<?php

require_once '../DB/connect.php';
session_start();
$mode = $_REQUEST["mode"];

switch ($mode) {
    case "send_approve_mail":
        $data_id = $_POST["id"];
        $data = SendApproveMail($db, $data_id);
        $emailuser = $data["user_email"];
        $email = [$emailuser];
        $header = 'การแจ้งขอแก้ไขข้อมูลมิเตอร์ไฟฟ้าของท่าน';
        $body = '<h4>เรียน  คุณ' . $data["user_first_name"] . ' ' . $data["user_last_name"] . '</h4>
        <p>จากที่ท่านได้มีคำขอแก้ไขข้อมูลมิเตอร์ไฟฟ้ามานั้นทางผู้ดูแล <br> <span style = "color : #66CC00;">ได้ทำการแก้ไขเรียบร้อยแล้ว</span> <br><br>ทางเราต้องขออภัยในความผิดพลาด หวังว่าท่านจะพึงพอใจในระบบของเราค่ะ</p>';

        $success = $mail->SendMail($email, $header, $body);
        if ($success) {
            $json["code"] = 200;
            $json["msg"] = "บันทึกสำเร็จ";
            echo json_encode($json);
        } else {
            $json["code"] = 400;
            $json["msg"] = "บันทึกไม่สำเร็จ";
            echo json_encode($json);
        }
        break;

    case "send_reject_mail":
        $data_id = $_POST["id"];
        $data = SendApproveMail($db, $data_id);
        $emailuser = $data["user_email"];
        $email = [$emailuser];
        $header = 'การแจ้งขอแก้ไขข้อมูลมิเตอร์ไฟฟ้าของท่าน';
        $body = '<h4>เรียน  คุณ' . $data["user_first_name"] . ' ' . $data["user_last_name"] . '</h4>
        <p>จากที่ท่านได้มีคำขอแก้ไขข้อมูลมิเตอร์ไฟฟ้ามานั้นทางผู้ดูแล <br> <span style = "color : #FF0000;">ได้ทำการยกเลิกการแก้ไขแล้ว</span><br><br>เนื่องจากทางผู้ดูแลได้ตรวจสอบและพบว่าข้อมูลตรงกับรูปภาพ<br><br>ทางเราต้องขออภัยในความผิดพลาด หวังว่าท่านจะพึงพอใจในระบบของเราค่ะ</p>';

        $success = $mail->SendMail($email, $header, $body);
        if ($success) {
            $json["code"] = 200;
            $json["msg"] = "บันทึกสำเร็จ";
            echo json_encode($json);
        } else {
            $json["code"] = 400;
            $json["msg"] = "บันทึกไม่สำเร็จ";
            echo json_encode($json);
        }
        break;

    default:
        throw new Exception("Invalid request method.");
}


function SendApproveMail($db, $data_id)
{
    $sql = "SELECT * FROM transaction_meter as a
    left join tb_user as b
    on a.meter_serial = b.user_meter_id
    WHERE a.id = ? ;";
    $stmt = $db->prepare($sql);
    $stmt->execute([$data_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
