<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart Example</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div style="width: 70%; margin: auto;">
        <canvas id="myChart"></canvas>
    </div>

    <script>
        // Sample Data (You can pass this dynamically from Laravel)
        const labels = @json($labels);
        const dataValues = @json($values);

        // Chart.js Configuration
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar', // Change to 'line', 'pie', etc.
            data: {
                labels: labels,
                datasets: [{
                    label: 'Dataset Example',
                    data: dataValues,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
