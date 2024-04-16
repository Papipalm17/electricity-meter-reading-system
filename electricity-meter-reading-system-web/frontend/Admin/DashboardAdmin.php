<title>Dashboard</title>
<?php include_once "../layouts/header_admin.php" ?>
<link rel="stylesheet" href="../../style/StyleDashboard.css">
<?php include('..\login_check.php');
include_once "../../backend/function.php";
$perUnit = 4.00;
?>

<div class="all-chart">

    <div class="all-box">
        <div class="bg-elec" id="box-day">
            <div class="all-unit">
                <span id="num-unit-day"><?= calculateReport() != 0 ? calculateReport() : '0'; ?></span>
                <span>รายงานทั้งหมด</span>
            </div>
        </div>

        <div class="elec-cost">
            <div class="bg-elec" id="box-cost">
                <div class="all-elec-cost">
                    <?php
                    $monthlyData = calculateAllMonthly();

                    $totalCost = 0;
                    foreach ($monthlyData as $data) {
                        $totalCost += $data["num"] * $perUnit;
                    }
                    ?>
                    <span id="num-cost"><?= number_format($totalCost, 2) ?></span>
                    <span>บาท</span>
                </div>
                <div class="all-elec-unit">
                    <span id="num-unit"><?= number_format($perUnit, 2) ?> บาท/หน่วย</span>
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="max-height:500px;">
        <div>
            <div id="sectionChartMonth" class="sectionCharts">
                <canvas id="ChartMonth"></canvas>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        action = "getChartMonthlyAll";
        $.ajax({
            url: '../../Backend/action.php',
            type: 'POST',
            data: {
                action: action,
            },
            success: function(res) {
                console.log(res);
                const data = JSON.parse(res);
                console.log(data)
                bindChart(data["labels"], data["data"], "ChartMonth", "รายเดือน");
            }
        });
    });

    function bindChart(p_labels, p_data, id, typeStr = "รายวัน") {
        const ctx = document.getElementById(id).getContext('2d');
        const data = {
            labels: p_labels,
            datasets: [{
                label: typeStr,
                data: p_data,
                fill: false,
                tension: 0.1
            }]
        };

        // Check if a Chart instance already exists for the given canvas ID
        const existingChart = Chart.getChart(ctx);
        if (existingChart) {
            existingChart.destroy(); // Destroy the existing Chart instance
        }

        const config = {
            type: 'bar',
            data: data,
        };

        new Chart(ctx, config);
    }

    // function ddlFilterChart_Change(_this) {
    //     $ddl = $(_this);
    //     $filterType = $ddl.val();
    //     $('.sectionCharts').fadeOut();
    //     switch (parseInt($filterType)) {
    //         case 1:
    //             $('#sectionChartDayly').fadeIn();
    //             break;
    //         case 2:
    //             $('#sectionChartWeekly').fadeIn();
    //             break;
    //         default:
    //             $('#sectionChartMonth').fadeIn();
    //             break;
    //     }
    // }
</script>

<?php include('./footer.php'); ?>