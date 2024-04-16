<title>Report</title>
<link rel="stylesheet" href="../../style/StyleReportAdmin.css">
<?php include('..\login_check.php'); ?>

<body>
    <?php include('./NavbarAdmin.php'); ?>

    <div class="head-table">
        <button id="head-btn" disabled>Current State</button>
    </div>
    <div class="div-data">
        <table class="table align-middle table-bordered table-data" id="table-data">
            <thead>
                <tr class="text-center">
                    <th class="align-middle">ID</th>
                    <th class="align-middle">Date Time</th>
                    <th class="align-middle">Result Image</th>
                    <th class="align-middle">Result Number</th>
                    <th class="align-middle">Report Number</th>
                    <th class="align-middle">Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $db->prepare("SELECT * FROM  transaction_meter where  data_status = 'REPORT' ");
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr class="text-center">
                        <th class="align-middle"><?= $row["id"] ?></th>
                        <th class="align-middle"><?= $row["input_timestamp"] ?></th>
                        <th class="align-middle"><img style="max-width: 300px;" src=" <?= str_replace('C:\xampp\htdocs','http://localhost', $row['meter_image']) ?>" alt="<?=   str_replace('C:\xampp\htdocs','localhost', $row['meter_image']) ?>"></th>
                        <th class="align-middle"><?= $row["meter_number"] ?></th>
                        <th class="align-middle" id><?= $row["data_report"] ?></th>
                        <th class="align-middle">
                            <div class="detail-edit">
                                <button type="button" class="btn" id="btnSaveDetail" onclick='btnEditClick()' data-id="<?= $row["id"] ?>" data-report="<?= $row["data_report"] ?>">แก้ไข</button>
                                <button type="button" class="btn" id="btnDelete" onclick='btnDeleteReportClick()' data-id="<?= $row["id"] ?>">ลบ</button>
                            </div>
                        </th>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>


    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- filter table -->
    <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>

    <script>
        function btnEditClick() {
            let id = $("#btnSaveDetail").attr("data-id");
            let number = $("#btnSaveDetail").attr("data-report");

            console.log(id);
            console.log(number);


            let action = "edit_data";

            if (id && number) {
                let text = "กรุณายืนยันการแก้ไขข้อมูล";
                if (confirm(text) == true) {
                    $.ajax({
                        url: '../../Backend/action.php',
                        type: 'POST',
                        data: {
                            action,
                            id,
                            number
                        },
                        success: function(res) {
                            console.log(res);

                            let report = JSON.parse(res);
                            console.log(report);

                            if (report.code == 200) {
                                let id = $("#btnSaveDetail").attr("data-id");

                                let dataAjax = {};
                                dataAjax = {
                                    id,
                                    mode: "send_approve_mail",
                                }
                                $.ajax({
                                    url: "../../Backend/mail_report.php",
                                    method: "POST",
                                    data: dataAjax,
                                    success: function(res) {
                                        console.log("sended!!");
                                        console.log(res);
                                        let json = JSON.parse(res);
                                        console.log(json);

                                        if (json.code == 200) {
                                            alert("ทำการแก้ไขข้อมูล และเมลจะถูกส่งไปยังผู้ใช้");
                                            location.reload(true);
                                        } else {
                                            alert("ส่งเมลไม่สำเร็จ")
                                        }
                                    }
                                });

                            } else {
                                alert("แก้ไขข้อมูลไม่สำเร็จ");
                            }
                        }
                    });
                }
            }
        }

        function btnDeleteReportClick() {
            let id = $("#btnDelete").attr("data-id");

            console.log(id);


            let action = "delete_report_data";

            if (id) {
                let text = "กรุณายืนยันการลบการแก้ไขข้อมูล";
                if (confirm(text) == true) {
                    $.ajax({
                        url: '../../Backend/action.php',
                        type: 'POST',
                        data: {
                            action,
                            id
                        },
                        success: function(res) {
                            console.log(res);

                            let report = JSON.parse(res);
                            console.log(report);

                            if (report.code == 200) {
                                let id = $("#btnDelete").attr("data-id");

                                let dataAjax = {};
                                dataAjax = {
                                    id,
                                    mode: "send_reject_mail",
                                }
                                $.ajax({
                                    url: "../../Backend/mail_report.php",
                                    method: "POST",
                                    data: dataAjax,
                                    success: function(res) {
                                        console.log("sended!!");
                                        console.log(res);
                                        let json = JSON.parse(res);
                                        console.log(json);

                                        if (json.code == 200) {
                                            alert("ทำการยกเลิกการแก้ไขข้อมูล และเมลจะถูกส่งไปยังผู้ใช้");
                                            location.reload(true);
                                        } else {
                                            alert("ส่งเมลไม่สำเร็จ")
                                        }
                                    }
                                });

                            } else {
                                alert("แก้ไขข้อมูลไม่สำเร็จ");
                            }
                        }
                    });
                }
            }
        }

        $(document).ready(function() {
            let table = new DataTable('#table-data', {
                lengthChange: false, // ปิดฟังก์ชันแสดงจำนวนรายการต่อหน้า
                ordering: true
            });
        });
    </script>

    <?php include('./footer.php'); ?>