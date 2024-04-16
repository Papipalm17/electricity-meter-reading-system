<title>Home</title>

<?php include_once "../layouts/header.php" ?>
<link rel="stylesheet" href="../../style/StyleHome.css">

<?php 
include('..\login_check.php');
include_once "../../backend/function.php";
$perUnit = 4.00;
?>

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
                    <span id="num-cost"><?= number_format(calculateMonthly() * $perUnit,2)  ?></span>
                    <span>บาท</span>
                </div>
                <div class="all-elec-unit">
                    <span id="num-unit"><?= number_format($perUnit,2) ?> บาท/หน่วย</span>
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



<script>
    $(document).ready(function() {
        console.log("onload...");

        let action = "getChartDaily";
        let meter_id = "<?php echo $_SESSION['meter']; ?>";

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
    });

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
            }]
        };

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

<?php include_once "../layouts/footer.php"; ?>