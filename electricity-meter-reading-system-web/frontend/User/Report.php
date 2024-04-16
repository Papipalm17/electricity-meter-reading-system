<title>Report</title>
<link rel="stylesheet" href="../../style/StyleReportUser.css">
<?php include('..\login_check.php'); ?>

<body>
    <?php include('./NavbarUser.php'); ?>

    <div class="head-table">
        <button id="head-btn" disabled>Current State</button>
    </div>
    <div class="div-data">
        <table class="table align-middle table-bordered table-data" id="table-data">
            <thead>
                <tr class="text-center">
                    <th class="align-middle">No.</th>
                    <th class="align-middle">Date Time</th>
                    <th class="align-middle">Result Number</th>
                    <th class="align-middle">Result Image</th>
                    <th class="align-middle">Report</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $db->prepare("SELECT * FROM  transaction_meter where  meter_serial = ? ORDER BY meter_number DESC ");
                $stmt->execute([$_SESSION['meter']]);
                $i = 1;
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr class="text-center">
                        <th class="align-middle"><?= $i ?></th>
                        <th class="align-middle"><?= $row["input_timestamp"] ?></th>
                        <th class="align-middle"><?= $row["meter_number"] ?></th>
                        <th class="align-middle"><img style="max-width: 300px;" src=" <?= str_replace('C:\xampp\htdocs','http://localhost', $row['meter_image']) ?>" alt="<?=   str_replace('C:\xampp\htdocs','localhost', $row['meter_image']) ?>"></th>
                        <th class="align-middle">
                            <div class="status">
                                <button id="btn-report" class="status  <?= ($row["data_status"] == NULL) ? "nomal-status" : "report-status"  ?>" onclick='btnReportModal(<?= $row["id"] ?>)' <?= ($row["data_status"] == "REPORT") ? "disabled" : "" ?> ><img src="../../icon/report2.png" id="img-report"></button>
                            </div>
                        </th>
                    </tr>
                <?php $i++; } ?>
            </tbody>
        </table>
    </div>

    <!-- Report Modal -->
    <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-report" role="document">
            <div class="modal-content">
                <div class="modal-header report-modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <img src="../../icon/close.png">
                    </button>
                </div>
                <div class="modal-body report-modal-body">
                    <h2>Report</h2>
                    <div class="detail-report">
                        <input type="number" id="detail"></input>
                        <button type="button" class="btn" id="btnSaveDetail" onclick="btnReportClick();">ยืนยัน</button>
                    </div>
                    <p>*******************************************************************<br>
                        กรอกตัวเลขที่ถูกต้อง เพื่อทำการแก้ไขโดยผู้ดูแล<br>
                        หากสถานะเป็นสีแดง หมายถึง รอผู้ดูแลตรวจสอบและยืนยัน<br>
                        เมื่อผู้ดูแลได้ตรวจสอบและยืนยันการแก้ไขแล้ว สถานะจะกลับมาเป็นสีเขียว</p>
                </div>
            </div>
        </div>
    </div>


    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- filter table -->
    <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>

    <script>
        function btnReportModal(id) {
            let action = "get_report_data";

            $.ajax({
                url: '../../backend/action.php',
                type: 'post',
                data: {
                    action,
                    id
                },
                success: function(res) {
                    console.log(res);

                    let report = JSON.parse(res);
                    console.log(report);

                    if (report.code == 200) {
                        let reportData = report.reportData
                        $("#btnSaveDetail").attr("data-id", reportData.id);
                        $("#reportModal").modal("show");
                    }
                }
            });
        }

        function btnReportClick() {
            let id = $("#btnSaveDetail").attr("data-id");
            let detail = $("#detail").val();

            if (detail != "") {
                let action = "save_report_data";

            $.ajax({
                url: '../../Backend/action.php',
                type: 'POST',
                data: {
                    detail,
                    action,
                    id
                },
                success: function(res) {
                    console.log(res);

                    let report = JSON.parse(res);
                    console.log(report);

                    if (report.code == 200) {
                        alert("ทำการแจ้งเรื่องไปยังผู้ดูแลเรียบร้อยแล้ว โปรดรอผู้ดูแลดำเนินการ");
                        $("#reportModal").modal("hide");
                        location.reload(true);
                    } 
                    else {
                        alert("แจ้งข้อมูลไม่สำเร็จ");
                    }
                }
            });
            } 
            else {
                alert ("กรุณากรอกข้อมูลให้ครบถ้วน !!")
                return;
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