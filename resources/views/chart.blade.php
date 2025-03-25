@extends('layouts.app')

@section('content')
<!-- From Uiverse.io by Lokesh1379 -->
<body> 
<div class="container">
    <h1 class="dashboard-title">Inventory Overview</h1>
    <div class="cards">
      <!-- TOTAL ITEMS Card -->
      <div class="card card-items" onclick="showModal('items')">
        <div class="card-icon">
          <span class="icon">📦</span>
        </div>
        <div class="card-title">TOTAL ITEMS</div>
        <div class="card-value">{{$count_items}}</div>
        <div class="card-indicator indicator-up">
          ↑ 12.3% from last month
        </div>
      </div>
      
      <!-- TOTAL CATEGORIES Card -->
      <div class="card card-categories" onclick="showModal('categories')">
        <div class="card-icon">
          <span class="icon">🏷️</span>
        </div>
        <div class="card-title">TOTAL CATEGORIES</div>
        <div class="card-value">{{$count_categories}}</div>
        <div class="card-indicator indicator-up">
          ↑ 4 new categories
        </div>
      </div>
      
      <!-- RETURNED Card -->
      <div class="card card-returned" onclick="showModal('returned')">
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
      <div class="card card-stock" onclick="showModal('stock')">
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
  
  <!-- Modal for Items -->
  <div id="modal-items" class="modal">
    <div class="modal-content">
      <span class="close-modal" onclick="closeModal('items')">&times;</span>
      <h2 class="modal-title">Total Items Details</h2>
      <div class="modal-details">
        <p><strong>Current Total:</strong> {{$count_items}} items</p>
        <p><strong>Change:</strong> +12.3% from last month (21,850 items)</p>
        <p><strong>New Additions:</strong> 3,145 items this month</p>
        <p><strong>Discontinued:</strong> 457 items this month</p>
      </div>
    </div>
  </div>
  
  <!-- Modal for Categories -->
  <div id="modal-categories" class="modal">
    <div class="modal-content">
      <span class="close-modal" onclick="closeModal('categories')">&times;</span>
      <h2 class="modal-title">Categories Details</h2>
      <div class="modal-details">
        <p><strong>Total Categories:</strong> {{$count_categories}}</p>
        <p><strong>New Categories:</strong> Electronics, Home Décor, Outdoor Tools, Personal Care</p>
        <p><strong>Largest Category:</strong> Kitchen Appliances (2,345 items)</p>
        <p><strong>Smallest Category:</strong> Specialty Tools (78 items)</p>
      </div>
    </div>
  </div>
  
  <!-- Modal for Returned Items -->
  <div id="modal-returned" class="modal">
    <div class="modal-content">
      <span class="close-modal" onclick="closeModal('returned')">&times;</span>
      <h2 class="modal-title">Returned Items Details</h2>
      <div class="modal-details">
        <p><strong>Total Returns:</strong> 1,245 items</p>
        <p><strong>Change:</strong> -2.4% from last month (1,275 items)</p>
        <p><strong>Top Return Reason:</strong> Product defect (42%)</p>
        <p><strong>Most Returned Category:</strong> Electronics (23% of returns)</p>
      </div>
    </div>
  </div>
  
  <!-- Modal for Stock -->
  <div id="modal-stock" class="modal">
    <div class="modal-content">
      <span class="close-modal" onclick="closeModal('stock')">&times;</span>
      <h2 class="modal-title">In Stock Details</h2>
      <div class="modal-details">
        <p><strong>Items In Stock:</strong> 18,756 (76.4% of total)</p>
        <p><strong>Low Stock Alert:</strong> 342 items below minimum threshold</p>
        <p><strong>Out of Stock:</strong> 125 items</p>
        <p><strong>Restock Expected:</strong> 532 items arriving next week</p>
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
  
   {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    body {
      background-color: #f5f7fb;
      padding: 20px;
    }
    
    .container {
      max-width: 1200px;
      margin: 0 auto;
      margin-bottom: 70px;
    }
    
    .dashboard-title {
      color: #333;
      margin-bottom: 24px;
      font-size: 28px;
      font-weight: 600;
    }
    
    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
      gap: 20px;
    }
    
    .card {
      background-color: white;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      cursor: pointer;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }
    
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }
    
    .card:active {
      transform: translateY(0);
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    .card::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 4px;
      background-color: #ddd;
    }
    
    .card-items::after {
      background-color: #4caf50;
    }
    
    .card-categories::after {
      background-color: #2196f3;
    }
    
    .card-returned::after {
      background-color: #ff9800;
    }
    
    .card-stock::after {
      background-color: #9c27b0;
    }
    
    .card-icon {
      margin-bottom: 15px;
      font-size: 24px;
    }
    
    .icon {
      display: inline-block;
      padding: 12px;
      border-radius: 50%;
      background-color: rgba(0, 0, 0, 0.05);
    }
    
    .card-title {
      color: #888;
      font-size: 14px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 10px;
    }
    
    .card-value {
      color: #333;
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 10px;
    }
    
    .card-indicator {
      font-size: 14px;
      font-weight: 500;
    }
    
    .indicator-up {
      color: #4caf50;
    }
    
    .indicator-down {
      color: #f44336;
    }
    
    .indicator-neutral {
      color: #607d8b;
    }
    
    /* Modal styles for when cards are clicked */
    .modal {
      display: none;
      position: fixed;
      z-index: 999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      align-items: center;
      justify-content: center;
    }
    
    .modal-content {
      background-color: white;
      padding: 30px;
      border-radius: 12px;
      width: 90%;
      max-width: 600px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
      position: relative;
    }
    
    .close-modal {
      position: absolute;
      top: 15px;
      right: 15px;
      font-size: 20px;
      color: #888;
      cursor: pointer;
      transition: color 0.2s;
    }
    
    .close-modal:hover {
      color: #333;
    }
    
    .modal-title {
      font-size: 24px;
      margin-bottom: 20px;
      color: #333;
    }
    
    .modal-details {
      margin-bottom: 20px;
    } 
    </style>
    
    <script>
     function showModal(type) {
      document.getElementById('modal-' + type).style.display = 'flex';
    }
    
    function closeModal(type) {
      document.getElementById('modal-' + type).style.display = 'none';
    }
    
    // Close modal when clicking outside of it
    window.onclick = function(event) {
      const modals = document.getElementsByClassName('modal');
      for (let i = 0; i < modals.length; i++) {
        if (event.target === modals[i]) {
          modals[i].style.display = 'none';
        }
      }
    }
    </script>
</body>
@endsection
