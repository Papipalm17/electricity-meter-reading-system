<?php

require_once '../DB/connect.php';
session_start();
if (isset($_POST['action'])) {
    if ($_POST['action'] == "insert_add_user") {
        $json = array();
        $add_user_array = array();

        $add_user_array['user_meter_id'] = $_POST['user_meter_id'];
        $add_user_array['user_pea_id'] = $_POST['user_pea_id'];
        $add_user_array['user_first_name'] = $_POST['user_first_name'];
        $add_user_array['user_last_name'] = $_POST['user_last_name'];
        $add_user_array['user_phone'] = $_POST['user_phone'];
        $add_user_array['user_email'] = $_POST['user_email'];
        $add_user_array['user_username'] = $_POST['user_username'];
        $add_user_array['user_password'] = $_POST['user_password'];
        $add_user_array['role_id'] = $_POST['role_id'];

        $inserted = AddUserData($add_user_array, $db);
        if ($inserted) {
            $json["code"] = 200;
            echo json_encode($json);
        } else {
            $json["code"] = 400;
            echo json_encode($json);
        }
    }

    if ($_POST['action'] == "get_report_data") {
        $id = $_POST["id"];
        $json = array();

        $data_id = getData_id($db, $id);
        $reportData = getreportData($db, $data_id);

        if (is_array($reportData)) {
            $json["code"] = 200;
            $json["reportData"] = $reportData;
        } else {
            $json["code"] = 400;
        }
        echo json_encode($json);
    }

    if ($_POST['action'] == "save_report_data") {
        $id = $_POST["id"];
        $json = array();
        $data_array = array();

        $data_array['detail'] = htmlentities($_POST['detail']);

        $inserted = false;
        $inserted = UpdateReportData($db, $data_array, $id);

        if ($inserted) {
            $json["code"] = 200;
        } else {
            $json["code"] = 400;
        }
        echo json_encode($json);
    }

    if ($_POST['action'] == "get_edit_data") {
        $id = $_POST["id"];
        $json = array();

        $data_id = getData_id($db, $id);
        $editData = getreportData($db, $data_id);

        if (is_array($editData)) {
            $json["code"] = 200;
            $json["editData"] = $editData;
        } else {
            $json["code"] = 400;
        }
        echo json_encode($json);
    }

    if ($_POST['action'] == "edit_data") {
        $id = $_POST["id"];
        $number = $_POST["number"];
        $json = array();

        $inserted = false;
        $inserted = UpdateEditData($db, $id, $number);

        if ($inserted) {
            $json["code"] = 200;
        } else {
            $json["code"] = 400;
        }
        echo json_encode($json);
    }

    if ($_POST['action'] == "delete_report_data") {
        $id = $_POST["id"];
        $json = array();

        $inserted = false;
        $inserted = DeleteReportData($db, $id);

        if ($inserted) {
            $json["code"] = 200;
        } else {
            $json["code"] = 400;
        }
        echo json_encode($json);
    }

    if ($_POST['action'] == "getChartDaily") {
        $meterId = $_POST['meter_id'];
        $currentDate = date('Y-m-d');
        $dt = getChartDaily($meterId, $currentDate, $db);

        //for chart
        $labels = array();
        $data = array();
        foreach ($dt as $row) {
            array_push($labels, $row["data_time"]);
            array_push($data, $row["meter_number"]);
        }

        echo json_encode([$labels, $data]);
    }

    if ($_POST['action'] == "getChartWeekly") {
        $meterId = $_POST['meter_id'];
        $dt = getChartWeekly($meterId, $db);

        //for chart
        $labels = array();
        $data = array();
        foreach ($dt as $row) {
            array_push($labels, $row["data_date"]);
            array_push($data, $row["use_unit"]);
        }

        echo json_encode([$labels, $data]);
    }

    if ($_POST['action'] == "getChartMonthly") {
        $meterId = $_POST['meter_id'];
        $currentMonth = date('m');
        $dt = getChartMonthly($meterId, $currentMonth, $db);

        //for chart
        $labels = array();
        $data = array();
        foreach ($dt as $row) {
            array_push($labels, $row["day"]);
            array_push($data, $row["use_unit"]);
        }

        echo json_encode([$labels, $data]);
    }

    if ($_POST['action'] == "getChartMonthlyAll") {
        $jsonArr = getChartMonthlyAll();
        echo json_encode($jsonArr);
    }   

    if ($_POST['action'] == "calculateDaily") {
        $json = array();
        try {
            $json["data"] = calculateDaily($_POST['meter_id']) == null ? 0 : calculateDaily($_POST['meter_id']);
            $json["code"] = 200;
        } catch (Exception $ex) {
            $json = getJsonError($ex);
        }

        echo json_encode($json);
    }

    if ($_POST['action'] == "calculateMonthly") {
        $json = array();
        try {
            $json["data"] =  calculateMonthly($_POST['meter_id']) == null ? 0 : calculateMonthly($_POST['meter_id']);
            $json["code"] = 200;
        } catch (Exception $ex) {
            $json = getJsonError($ex);
        }

        echo json_encode($json);
    }
}

function getJsonError(Exception $ex)
{
    $json = array();
    $json["code"] = 400;
    $json["error"] = $ex->getMessage();
    return $json;
}

function calculateDaily($meterId)
{
    global $db;
    // $meterId = $_SESSION['meter'];
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

function calculateMonthly($meterId)
{
    global $db;
    // $meterId = $_SESSION['meter'];
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

function getChartDaily($meterId, $currentDate, $db)
{
    $sql = "SELECT 
                SUBSTRING(input_timestamp,12,5) as data_time
                ,meter_number as meter_number
            FROM transaction_meter
            where meter_serial = ? and SUBSTRING(input_timestamp,1,10) = ?
            order by SUBSTRING(input_timestamp,1,10) asc";
    $stmt = $db->prepare($sql);
    $stmt->execute([$meterId, $currentDate]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// function getChartDailyAll($currentDate, $db)
// {
//     $sql = "SELECT 
//                 SUBSTRING(input_timestamp,12,5) as data_time
//                 ,meter_number as meter_number
//             FROM transaction_meter
//             where meter_serial = ? and SUBSTRING(input_timestamp,1,10) = ?
//             order by SUBSTRING(input_timestamp,1,10) asc";
//     $stmt = $db->prepare($sql);
//     $stmt->execute([$meterId, $currentDate]);

//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }

function getChartWeekly($meterId, $db)
{
    $sql = "SELECT
                date(td.today_date) as data_date,
                td.today_unit,
                date( date(today_date) - 1 ) as yesday_date,
                (SELECT MAX(meter_number) FROM transaction_meter WHERE meter_serial = ? and  DATE(input_timestamp) = (date( date(td.today_date) - 1 ) )  ) as yesday_unit,
                case 
                    when  td.today_unit - (SELECT MAX(meter_number) FROM transaction_meter WHERE  DATE(input_timestamp) = (date( date(td.today_date) - 1 ) )  )  is null 
                    then  td.today_unit - td.today_min_unit 
                    else  td.today_unit - (SELECT MAX(meter_number) FROM transaction_meter WHERE  DATE(input_timestamp) = (date( date(td.today_date) - 1 ) )  )
            end as use_unit
            FROM
                (SELECT 
                    date(input_timestamp) as today_date,
                    MAX(meter_number) as today_unit,
                    MIN(meter_number) as today_min_unit
                FROM 
                    transaction_meter 
                WHERE meter_serial = ?
                GROUP BY DATE(input_timestamp)
                ORDER by date(input_timestamp) desc
                LIMIT 7) AS td;
            ";
    $stmt = $db->prepare($sql);
    $stmt->execute([$meterId, $meterId]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getChartMonthly($meterId, $currentMonth, $db)
{
    $sql = "SELECT
                date(td.today_date) as `day`,
                td.today_unit,
                date( date(today_date) - 1 ) as yesday_date,
                (SELECT MAX(meter_number) FROM transaction_meter WHERE meter_serial = ? and  DATE(input_timestamp) = (date( date(td.today_date) - 1 ) )  ) as yesday_unit,
                CASE
                    WHEN td.today_unit - (SELECT MAX(meter_number) FROM transaction_meter WHERE  DATE(input_timestamp) = (date( date(td.today_date) - 1 ) )  ) is null
                    then td.today_unit - td.today_min_unit
                    else  td.today_unit - (SELECT MAX(meter_number) FROM transaction_meter WHERE  DATE(input_timestamp) = (date( date(td.today_date) - 1 ) )  )
                end as use_unit
            FROM
                (SELECT 
                    date(input_timestamp) as today_date,
                    MAX(meter_number) as today_unit,
                    MIN(meter_number) as today_min_unit
                FROM 
                    transaction_meter 
                WHERE meter_serial = ? and MONTH(input_timestamp) = MONTH(CURDATE())
                GROUP BY DATE(input_timestamp)
                ORDER by date(input_timestamp) 
                ) AS td;";
    $stmt = $db->prepare($sql);
    $stmt->execute([$meterId, $meterId]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getChartMonthlyAll()
{
    $userData = getAllUser();

    $datasets = array();
    $datasets["labels"] = array();
    $datasets["data"] = array();

    foreach ($userData as $user) {
        $calculateMonthly = calculateMonthly($user["user_meter_id"]);
        array_push($datasets["labels"], $user["user_first_name"] . " " . $user["user_last_name"] . " (" . $user["user_meter_id"] . ")");
        array_push($datasets["data"], $calculateMonthly  == null ? 0 : $calculateMonthly);
    }

    return $datasets;
}

function getAllUser()
{
    global $db;

    $sql = "SELECT `user_id`, `user_meter_id`, `user_pea_id`, 
                    `user_username`, `user_first_name`, `user_last_name`, `user_phone`, 
                    `user_email`, `role_id`, `user_password` FROM `tb_user`";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function AddUserData($add_user_array, $db)
// edit
{
    $stmt = $db->prepare("INSERT INTO tb_user (user_meter_id , user_pea_id , user_first_name , 
    user_last_name , user_phone , user_email , user_username , user_password , role_id)
    VALUES (:user_meter_id , :user_pea_id , :user_first_name , :user_last_name , 
    :user_phone , :user_email , :user_username , :user_password , :role_id)");

    $stmt->bindParam(":user_meter_id", $add_user_array['user_meter_id']);
    $stmt->bindParam(":user_pea_id", $add_user_array['user_pea_id']);
    $stmt->bindParam(":user_first_name", $add_user_array['user_first_name']);
    $stmt->bindParam(":user_last_name", $add_user_array['user_last_name']);
    $stmt->bindParam(":user_phone", $add_user_array['user_phone']);
    $stmt->bindParam(":user_email", $add_user_array['user_email']);
    $stmt->bindParam(":user_username", $add_user_array['user_username']);
    $stmt->bindParam(":user_password", $add_user_array['user_password']);
    $stmt->bindParam(":role_id", $add_user_array['role_id']);

    return $stmt->execute();
}

function getData_id($db, $id)
{
    $sql = "SELECT id FROM transaction_meter WHERE id = ? ;";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $id = $row["id"];
}

function getreportData($db, $data_id)
// edit
{
    $sql = "SELECT * FROM transaction_meter WHERE id = ? ;";
    $stmt = $db->prepare($sql);
    $stmt->execute([$data_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function UpdateReportData($db, $data_array, $data_id)
// edit
{
    $sql = "
    UPDATE transaction_meter
    SET data_report = :data_report,
    data_status = 'REPORT'
    WHERE id = :id  ;    
    ";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(":data_report", $data_array['detail']);

    $stmt->bindParam(":id", $data_id);
    return $stmt->execute();
}

function UpdateEditData($db, $data_id, $data_report)
// edit
{
    $sql = "
    UPDATE transaction_meter
    SET meter_number = :meter_number,
    data_status = NULL
    WHERE id = :id  ;    
    ";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(":id", $data_id);
    $stmt->bindParam(":meter_number", $data_report);

    return $stmt->execute();
}

function DeleteReportData($db, $data_id)
// edit
{
    $sql = "
    UPDATE transaction_meter
    SET data_report = NULL,
    data_status = NULL
    WHERE id = :id  ;    
    ";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(":id", $data_id);

    return $stmt->execute();
}
