<title>Home</title>
<?php include_once "../layouts/header_admin.php" ?>
<link rel="stylesheet" href="../../style/StyleHomeAdmin.css">
<?php include('..\login_check.php');
include_once "../../backend/function.php";
$perUnit = 4.00;
?>

<div class="all-card ">
    <div class="all-row">
        <?php
        $stmt = $db->prepare("SELECT * FROM tb_user");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <div class="card">
                <h5 data-id="<?= $row["user_id"] ?>" id="meter-id">No. <?= $row["user_meter_id"] ?></h5>
                <img src="../../icon/meter1.png" class="card-img-top" id="img-user" />
                <div class="card-body">
                    <h4 data-id="<?= $row["user_id"] ?>"><?= $row["user_first_name"] ?> <?= $row["user_last_name"] ?></h4>
                </div>
                <div class="box-bottom">
                    <button id="btn-dashboard" data-id="<?= $row["user_id"] ?>" data-meter-id="<?= $row["user_meter_id"] ?>" onclick='btnDashboardModal(this)'><img src="../../icon/chart.png" id="img-dashboard"></button>
                    <button id="btn-delete" onclick='btnDeleteUser(<?= $row["user_id"] ?>)'><img src="../../icon/delete.png" id="img-delete"></button>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<!-- Dashboard Modal -->
<div class="modal fade" id="dashboardModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-dashboard" role="document">
        <div class="modal-content">
            <div class="modal-header dashboard-modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <img src="../../icon/close.png">
                </button>
            </div>
            <div class="modal-body dashboard-modal-body">
                <div class="all-chart">

                    <div class="all-box">
                        <div class="bg-elec" id="box-day">
                            <div class="all-unit">
                                <span id="num-unit-day"><?= calculateDaily() != 0 ? calculateDaily() : '0'; ?></span>
                                <span>หน่วย / วัน</span>
                            </div>
                        </div>
                        <div class="bg-elec" id="box-month">
                            <div class="all-unit">
                                <span id="num-unit-month"><?= calculateMonthly() != 0 ? calculateMonthly() : '0'; ?></span>
                                <span>หน่วย / เดือน</span>
                            </div>
                        </div>
                        <div class="elec-cost">
                            <div class="bg-elec" id="box-cost">
                                <div class="all-elec-cost">
                                    <span id="num-cost"><?= number_format(calculateMonthly() * $perUnit, 2)  ?></span>
                                    <span>บาท</span>
                                </div>
                                <div class="all-elec-unit">
                                    <span id="num-unit"><?= number_format($perUnit, 2) ?> บาท/หน่วย</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container" style="max-height:500px;">
                        <div class="d-flex justify-content-start">
                            <select class="form-select" id="ddlFilterChart" aria-label="Default select example" style="max-width: 400px;" onchange="ddlFilterChart_Change(this)">
                                <option value="1" selected>รายวัน</option>
                                <option value="2">รายสัปดาห์</option>
                                <option value="3">รายเดือน</option>
                            </select>
                        </div>
                        <div>
                            <div id="sectionChartDayly" class="sectionCharts">
                                <canvas id="ChartDayly"></canvas>
                            </div>
                            <div id="sectionChartWeekly" class="sectionCharts" style="display: none;">
                                <canvas id="ChartWeekly"></canvas>
                            </div>
                            <div id="sectionChartMonth" class="sectionCharts" style="display: none;">
                                <canvas id="ChartMonth"></canvas>
                            </div>
                        </div>
                    </div>

                </div>
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
    function btnDeleteUser(userId) {
        if (confirm("คุณต้องการลบผู้ใช้นี้ใช่หรือไม่?")) {
            // ให้ใช้ AJAX เพื่อส่ง user_id ไปยัง PHP script
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // ทำอะไรก็ตามหลังจากที่รับข้อมูลจาก PHP script
                    alert(this.responseText); // เพื่อตรวจสอบการทำงาน (สามารถลบบรรทัดนี้ได้)
                    location.reload(true);
                }
            };
            xhttp.open("GET", "../../backend/delete_user.php?user_id=" + userId, true);
            xhttp.send();
        }
    }

    function btnDashboardModal(_this) {
        let id = $(_this).attr("data-id");
        $("#dashboardModal").modal("show");
        console.log(id);

        let action = "getChartDaily";
        let meter_id = $(_this).attr("data-meter-id");

        $.ajax({
            url: '../../Backend/action.php',
            type: 'POST',
            data: {
                action: action,
                meter_id: meter_id
            },
            success: function(res) {
                console.log(res);
                const data = JSON.parse(res);
                bindChart(data[0], data[1], "ChartDayly");

            }
        });

        action = "getChartMonthly";
        $.ajax({
            url: '../../Backend/action.php',
            type: 'POST',
            data: {
                action: action,
                meter_id: meter_id
            },
            success: function(res) {
                console.log(res);
                const data = JSON.parse(res);
                bindChart(data[0], data[1], "ChartMonth", "รายเดือน");
            }
        });

        action = "getChartWeekly";
        $.ajax({
            url: '../../Backend/action.php',
            type: 'POST',
            data: {
                action: action,
                meter_id: meter_id
            },
            success: function(res) {
                console.log(res);
                const data = JSON.parse(res);
                bindChart(data[0].reverse(), data[1].reverse(), "ChartWeekly", "รายสัปดาห์");
            }
        });

        //Reset Text Card
        $('#num-unit-day').text("0");
        $('#num-unit-month').text("0");
        $('.all-elec-cost').find("span").first().text("0");

        //binding Card
        $.ajax({
            url: '../../Backend/action.php',
            type: 'POST',
            data: {
                action: "calculateDaily",
                meter_id: meter_id
            },
            success: function(res) {
                let json = JSON.parse(res);
                console.log(json)
                if (json.code == 200) {
                    $('#num-unit-day').text(json.data);
                } else {
                    alert(json.error);
                }
            }
        });

        $.ajax({
            url: '../../Backend/action.php',
            type: 'POST',
            data: {
                action: "calculateMonthly",
                meter_id: meter_id
            },
            success: function(res) {
                let json = JSON.parse(res);
                if (json.code == 200) {
                    $('#num-unit-month').text(json.data);
                    let unit = Number(json.data);
                    let pricePerUnit = Number('<?= $perUnit ?>');
                    $('.all-elec-cost').find("span").first().text((pricePerUnit * unit).toFixed(2));
                } else {
                    alert(json.error);
                }
            }
        });

    }

    function bindChart(p_labels, p_data, id, typeStr = "รายวัน") {
        const ctx = document.getElementById(id).getContext('2d');
        const data = {
            labels: p_labels,
            datasets: [{
                    label: typeStr,
                    data: p_data.map(value => parseInt(value)),
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }
            ]
        };

        // Check if a Chart instance already exists for the given canvas ID
        const existingChart = Chart.getChart(ctx);
        if (existingChart) {
            existingChart.destroy(); // Destroy the existing Chart instance
        }

        const config = {
            type: 'line',
            data: data,
        };

        new Chart(ctx, config);
    }

    function ddlFilterChart_Change(_this) {
        $ddl = $(_this);
        $filterType = $ddl.val();
        $('.sectionCharts').fadeOut();
        switch (parseInt($filterType)) {
            case 1:
                $('#sectionChartDayly').fadeIn();
                break;
            case 2:
                $('#sectionChartWeekly').fadeIn();
                break;
            default:
                $('#sectionChartMonth').fadeIn();
                break;
        }
    }
</script>

<?php include('./footer.php'); ?>