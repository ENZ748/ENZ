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
        <div class="card-value">{{$count_returned_items}}</div>
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
        <div class="card-value">{{$count_inStock}}</div>
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
        <p><strong>Total Returns:</strong> {{$count_returned_items}} items</p>
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
        <p><strong>Items In Stock:</strong> {{$count_inStock}} total</p>
        <p><strong>Low Stock Alert:</strong> 342 items below minimum threshold</p>
        <p><strong>Out of Stock:</strong> 125 items</p>
        <p><strong>Restock Expected:</strong> 532 items arriving next week</p>
      </div>
    </div>
  </div>
   
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;">
    <!-- Equipment Chart -->
    <div style="width: 45%; min-width: 300px; padding: 20px; border: 1px solid #e0e0e0; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); background: #fff;">
        <h3 style="margin: 0 0 15px 0; font-size: 16px; color: #444; font-weight: 600; display: flex; align-items: center;">
            <span style="display: inline-block; width: 12px; height: 12px; background: #3a7bd5; margin-right: 8px; border-radius: 3px;"></span>
            Equipment Status
        </h3>
        <div style="height: 300px; position: relative;">
            <canvas id="chart1"></canvas>
        </div>
        <div style="text-align: right; margin-top: 8px; font-size: 12px; color: #777;">
            Last updated: <?php echo date('M d, Y'); ?>
        </div>
    </div>
    
    <!-- User Chart -->
    <div style="width: 45%; min-width: 300px; padding: 20px; border: 1px solid #e0e0e0; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); background: #fff;">
        <h3 style="margin: 0 0 15px 0; font-size: 16px; color: #444; font-weight: 600; display: flex; align-items: center;">
            <span style="display: inline-block; width: 12px; height: 12px; background: #ff6b6b; margin-right: 8px; border-radius: 3px;"></span>
            User Activity
        </h3>
        <div style="height: 300px; position: relative;">
            <canvas id="chart2"></canvas>
        </div>
        <div style="text-align: right; margin-top: 8px; font-size: 12px; color: #777;">
            Last updated: <?php echo date('M d, Y'); ?>
        </div>
    </div>
    
    <!-- Returned Items Chart -->
    <div style="width: 45%; min-width: 300px; padding: 20px; border: 1px solid #e0e0e0; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); background: #fff;">
        <h3 style="margin: 0 0 15px 0; font-size: 16px; color: #444; font-weight: 600; display: flex; align-items: center;">
            <span style="display: inline-block; width: 12px; height: 12px; background: #4ecdc4; margin-right: 8px; border-radius: 3px;"></span>
            Returned Items
        </h3>
        <div style="height: 300px; position: relative;">
            <canvas id="chart3"></canvas>
        </div>
        <div style="text-align: right; margin-top: 8px; font-size: 12px; color: #777;">
            Last updated: <?php echo date('M d, Y'); ?>
        </div>
    </div>
    
    <!-- Damaged Items Chart -->
    <div style="width: 45%; min-width: 300px; padding: 20px; border: 1px solid #e0e0e0; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); background: #fff;">
        <h3 style="margin: 0 0 15px 0; font-size: 16px; color: #444; font-weight: 600; display: flex; align-items: center;">
            <span style="display: inline-block; width: 12px; height: 12px; background: #ffa502; margin-right: 8px; border-radius: 3px;"></span>
            Damaged Items
        </h3>
        <div style="height: 300px; position: relative;">
            <canvas id="chart4"></canvas>
        </div>
        <div style="text-align: right; margin-top: 8px; font-size: 12px; color: #777;">
            Last updated: <?php echo date('M d, Y'); ?>
        </div>
    </div>
</div>

<script>
    // Preserve all original data variables
    // Equipments
    const labels = @json($labels);
    const dataValues = @json($values);

    // Users
    const userLabels = @json($userLabels);
    const userdataValues = @json($userValues);

    // Returned Items
    const returnedItemsLabels = @json($returnedItemsLabels);
    const returnedItemsdataValues = @json($returnedValues);

    // Damaged Items
    const damagedlabels = @json($damagedlabels);
    const damagedItemsdataValues = @json($damagedvalues);

    // Modern color palette
    const colors = {
        blue: { bg: 'rgba(58, 123, 213, 0.7)', border: 'rgba(58, 123, 213, 1)' },
        red: { bg: 'rgba(255, 107, 107, 0.7)', border: 'rgba(255, 107, 107, 1)' },
        teal: { bg: 'rgba(78, 205, 196, 0.7)', border: 'rgba(78, 205, 196, 1)' },
        orange: { bg: 'rgba(255, 165, 2, 0.7)', border: 'rgba(255, 165, 2, 1)' },
        purple: { bg: 'rgba(136, 84, 208, 0.7)', border: 'rgba(136, 84, 208, 1)' },
        green: { bg: 'rgba(46, 204, 113, 0.7)', border: 'rgba(46, 204, 113, 1)' }
    };

    // Chart configuration with fixed height
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: '#333',
                titleFont: { size: 14 },
                bodyFont: { size: 12 },
                padding: 12,
                displayColors: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0, 0, 0, 0.05)'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    };

    // Initialize all charts with consistent height
    function initializeCharts() {
        // Equipment Chart
        new Chart(document.getElementById('chart1'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Equipment Count',
                    data: dataValues,
                    backgroundColor: colors.blue.bg,
                    borderColor: colors.blue.border,
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: chartOptions
        });

        // User Chart
        new Chart(document.getElementById('chart2'), {
            type: 'line',
            data: {
                labels: userLabels,
                datasets: [{
                    label: 'Active Users',
                    data: userdataValues,
                    backgroundColor: colors.red.bg,
                    borderColor: colors.red.border,
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: chartOptions
        });

        // Returned Items Chart
        new Chart(document.getElementById('chart3'), {
            type: 'pie',
            data: {
                labels: returnedItemsLabels,
                datasets: [{
                    label: 'Returned Items',
                    data: returnedItemsdataValues,
                    backgroundColor: [
                        colors.teal.bg,
                        colors.purple.bg,
                        colors.orange.bg
                    ],
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            },
            options: {
                ...chartOptions,
                plugins: {
                    ...chartOptions.plugins,
                    legend: {
                        position: 'right',
                        labels: {
                            boxWidth: 12,
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                }
            }
        });

        // Damaged Items Chart
        new Chart(document.getElementById('chart4'), {
            type: 'doughnut',
            data: {
                labels: damagedlabels,
                datasets: [{
                    label: 'Damaged Items',
                    data: damagedItemsdataValues,
                    backgroundColor: [
                        colors.orange.bg,
                        'rgba(201, 203, 207, 0.7)'
                    ],
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            },
            options: {
                ...chartOptions,
                plugins: {
                    ...chartOptions.plugins,
                    legend: {
                        position: 'right',
                        labels: {
                            boxWidth: 12,
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                },
                cutout: '70%'
            }
        });
    }

    // Initialize charts when DOM is loaded
    document.addEventListener('DOMContentLoaded', initializeCharts);
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
