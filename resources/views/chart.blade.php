@extends('layouts.app')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<body>
    <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px;">
        <div style="width: 45%; padding: 15px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1); background: #fff; position: relative;">
            <h3 style="position: absolute; top: 10px; left: 15px; margin: 0; font-size: 14px; color: #333;">Equipment</h3>
            <canvas id="chart1" style="margin-top: 25px;"></canvas>
        </div>
        <div style="width: 45%; padding: 15px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1); background: #fff; position: relative;">
            <h3 style="position: absolute; top: 10px; left: 15px; margin: 0; font-size: 14px; color: #333;">Users</h3>
            <canvas id="chart2" style="margin-top: 25px;"></canvas>
        </div>
        <div style="width: 45%; padding: 15px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1); background: #fff; position: relative;">
            <h3 style="position: absolute; top: 10px; left: 15px; margin: 0; font-size: 14px; color: #333;">Returned Items</h3>
            <canvas id="chart3" style="margin-top: 25px;"></canvas>
        </div>
        <div style="width: 45%; padding: 15px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1); background: #fff; position: relative;">
            <h3 style="position: absolute; top: 10px; left: 15px; margin: 0; font-size: 14px; color: #333;">Damaged Items</h3>
            <canvas id="chart4" style="margin-top: 25px;"></canvas>
        </div>
    </div>

    <script>
        // Sample Data (You can pass this dynamically from Laravel)
        const labels = @json($labels);
        const dataValues = @json($values);

        // Chart Configurations
        function createChart(chartId, chartType, label, bgColor, borderColor) {
            const ctx = document.getElementById(chartId).getContext('2d');
            new Chart(ctx, {
                type: chartType,
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: dataValues,
                        backgroundColor: bgColor,
                        borderColor: borderColor,
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Create Multiple Charts
        createChart('chart1', 'bar', 'Equipment', 'rgba(54, 162, 235, 0.5)', 'rgba(54, 162, 235, 1)');
        createChart('chart2', 'line', 'Users', 'rgba(255, 99, 132, 0.5)', 'rgba(255, 99, 132, 1)');
        createChart('chart3', 'pie', 'Returned Items', ['rgba(75, 192, 192, 0.5)', 'rgba(153, 102, 255, 0.5)', 'rgba(255, 206, 86, 0.5)'], ['rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 206, 86, 1)']);
        createChart('chart4', 'doughnut', 'Damaged Items', ['rgba(255, 159, 64, 0.5)', 'rgba(201, 203, 207, 0.5)'], ['rgba(255, 159, 64, 1)', 'rgba(201, 203, 207, 1)']);
    </script>
</body>
@endsection
