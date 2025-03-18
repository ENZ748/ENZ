@extends('layouts.app')

@section('content')
<!-- From Uiverse.io by Lokesh1379 -->
<body> 

        <div class="container">
            <h1 class="dashboard-title">Inventory Overview</h1>
            <div class="cards">
            <!-- TOTAL ITEMS Card -->
            <div class="card card-items">
                <div class="card-icon">
                <span class="icon">📦</span>
                </div>
                <div class="card-title">TOTAL ITEMS</div>
                <div class="card-value">24,538</div>
                <div class="card-indicator indicator-up">
                ↑ 12.3% from last month
                </div>
            </div>
            
            <!-- TOTAL CATEGORIES Card -->
            <div class="card card-categories">
                <div class="card-icon">
                <span class="icon">🏷️</span>
                </div>
                <div class="card-title">TOTAL CATEGORIES</div>
                <div class="card-value">128</div>
                <div class="card-indicator indicator-up">
                ↑ 4 new categories
                </div>
            </div>
            
            <!-- RETURNED Card -->
            <div class="card card-returned">
                <div class="card-icon">
                <span class="icon">↩️</span>
                </div>
                <div class="card-title">RETURNED</div>
                <div class="card-value">1,245</div>
                <div class="card-indicator indicator-down">
                ↓ 2.4% from last month
                </div>
            </div>
            
            <!-- STOCK Card -->
            <div class="card card-stock">
                <div class="card-icon">
                <span class="icon">📊</span>
                </div>
                <div class="card-title">IN STOCK</div>
                <div class="card-value">18,756</div>
                <div class="card-indicator indicator-neutral">
                76.4% of total inventory
                </div>
            </div>
            </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



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

<style>
  
  /* From Uiverse.io by Lokesh1379 */ 
  .parent {
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: right;
    align-items: right;
  }
  
  .child {
    width: 50px;
    height: 50px;
    display: flex;
    justify-content: center;
    align-items: center;
    transform-style: preserve-3d;
    transition: all 0.5s ease-in-out;
    border-radius: 50%;
    margin: 0 5px;
  }
  
  .child:hover {
    background-color: white;
    background-position: -100px 100px, -100px 100px;
    transform: rotate3d(0.5, 1, 0, 30deg);
    transform: perspective(180px) rotateX(60deg) translateY(2px);
    box-shadow: 0px 10px 10px rgb(1, 49, 182);
  }
  
  button {
    border: none;
    background-color: transparent;
    font-size: 20px;
  }
  
  .button:hover {
    width: inherit;
    height: inherit;
    display: flex;
    justify-content: center;
    align-items: center;
    transform: translate3d(0px, 0px, 15px) perspective(180px) rotateX(-35deg) translateY(2px);
    border-radius: 50%;
  }
  
  
      * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      }
      
      body {
        background-color: #f5f7fa;
        padding: 20px;
      }
      
      .container {
        max-width: 1200px;
        margin: 0 auto;
        margin-bottom: 80px;
      }
      
      .dashboard-title {
        font-size: 24px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 20px;
      }
      
      .cards {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
      }
      
      .card {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        padding: 20px;
        width: calc(25% - 15px);
        min-width: 220px;
        transition: transform 0.2s, box-shadow 0.2s;
      }
      
      .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
      }
      
      .card-title {
        color: #64748b;
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
      }
      
      .card-value {
        color: #0f172a;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 15px;
      }
      
      .card-indicator {
        display: flex;
        align-items: center;
        font-size: 14px;
        margin-top: 5px;
      }
      
      .indicator-up {
        color: #10b981;
      }
      
      .indicator-down {
        color: #ef4444;
      }
      
      .indicator-neutral {
        color: #6b7280;
      }
      
      .card-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
      }
      
      /* Card specific styles */
      .card-items .card-icon {
        background-color: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
      }
      
      .card-categories .card-icon {
        background-color: rgba(139, 92, 246, 0.1);
        color: #8b5cf6;
      }
      
      .card-returned .card-icon {
        background-color: rgba(249, 115, 22, 0.1);
        color: #f97316;
      }
      
      .card-stock .card-icon {
        background-color: rgba(16, 185, 129, 0.1);
        color: #10b981;
      }
      
      .icon {
        font-size: 20px;
      }
    </style>
</body>
@endsection
