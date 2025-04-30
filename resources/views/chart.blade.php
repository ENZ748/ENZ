@extends('layouts.app')

@section('content')
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
        <div class="card-indicator indicator-{{ $itemsChange > 0 ? 'up' : ($itemsChange < 0 ? 'down' : 'neutral') }}">
            @if($itemsChange > 0)
                ↑ {{$itemsChange}}% from last month
            @elseif($itemsChange < 0)
                ↓ {{abs($itemsChange)}}% from last month
            @else
                → No change from last month
            @endif
        </div>
    </div>
    
    <!-- TOTAL CATEGORIES Card -->
    <div class="card card-categories" onclick="showModal('categories')">
        <div class="card-icon">
            <span class="icon">🏷️</span>
        </div>
        <div class="card-title">TOTAL CATEGORIES</div>
        <div class="card-value">{{$count_categories}}</div>
        <div class="card-indicator indicator-{{ $newCategoriesThisMonth > 0 ? 'up' : 'neutral' }}">
            @if($newCategoriesThisMonth > 0)
                ↑ {{$newCategoriesThisMonth}} new categories this month
            @else
                → No new categories this month
            @endif
        </div>
    </div>
    
    <!-- RETURNED Card -->
    <div class="card card-returned" onclick="showModal('returned')">
        <div class="card-icon">
            <span class="icon">↩️</span>
        </div>
        <div class="card-title">RETURNED</div>
        <div class="card-value">{{$count_returned_items}}</div>
        <div class="card-indicator indicator-{{ $returnsChange > 0 ? 'up' : ($returnsChange < 0 ? 'down' : 'neutral') }}">
            @if($returnsChange > 0)
                ↑ {{$returnsChange}}% from last month
            @elseif($returnsChange < 0)
                ↓ {{abs($returnsChange)}}% from last month
            @else
                → No change from last month
            @endif
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
            {{$stockPercentage}}% of total inventory
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
            <p><strong>Added this month:</strong> {{$currentMonthItems}} items</p>
            <p><strong>Last month total:</strong> {{$lastMonthItems}} items</p>
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
            @if($largestCategory)
                <p><strong>Largest Category:</strong> {{$largestCategory->category_name}} ({{$largestCategory->items_count}} items)</p>
            @endif
            @if($smallestCategory && $smallestCategory->id != $largestCategory->id)
                <p><strong>Smallest Category:</strong> {{$smallestCategory->category_name}} ({{$smallestCategory->items_count}} items)</p>
            @endif
            <p><strong>Average items per category:</strong> 
                {{$count_categories > 0 ? round($count_items / $count_categories, 1) : 0}}
            </p>
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
            <p><strong>Returns this month:</strong> {{$returnedThisMonth}}</p>
            <p><strong>Overall return rate:</strong> {{$returnRate}}%</p>
        </div>
    </div>
</div>

<!-- Modal for Stock -->
<div id="modal-stock" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeModal('stock')">&times;</span>
        <h2 class="modal-title">In Stock Details</h2>
        <div class="modal-details">
            <p><strong>Items In Stock:</strong> {{$count_inStock}}</p>
            <p><strong>Low Stock Items (≤{{$lowStockThreshold}}):</strong> {{$lowStockItems}}</p>
            <p><strong>Out of Stock Items:</strong> {{$outOfStockItems}}</p>
        </div>
    </div>
</div>
  </div>
   
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Year Selection Dropdown - Now sorted newest first -->
    <div class="flex justify-end my-3">
        <select id="yearSelector" class="px-4 py-2 rounded-lg border border-gray-300 text-base mr-20">
            @foreach(array_reverse(array_keys($yearlyData)) as $year)
                <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>
                    {{ $year }}
                </option>
            @endforeach
        </select>
    </div>

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
            Last updated: {{ $lastUpdated }}
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
            Last updated: {{ $lastUpdated }}
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
            Last updated: {{ $lastUpdated }}
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
            Last updated: {{ $lastUpdated }}
        </div>
    </div>
</div>

<script>
    // Store all chart data by year
    const chartDataByYear = {
        @foreach($yearlyData as $year => $data)
            {{ $year }}: {
                equipment: {
                    labels: @json($data['equipment']['labels']),
                    values: @json($data['equipment']['values'])
                },
                users: {
                    labels: @json($data['users']['labels']),
                    values: @json($data['users']['values'])
                },
                returned: {
                    labels: @json($data['returned']['labels']),
                    values: @json($data['returned']['values'])
                },
                damaged: {
                    labels: @json($data['damaged']['labels']),
                    values: @json($data['damaged']['values'])
                }
            },
        @endforeach
    };

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

    // Chart instances
    let chart1, chart2, chart3, chart4;

    // Initialize all charts with consistent height
    function initializeCharts(year) {
        const dataForYear = chartDataByYear[year];
        
        if (!dataForYear) {
            console.error(`No data available for year ${year}`);
            return;
        }
        
        // Equipment Chart
        if (chart1) chart1.destroy();
        chart1 = new Chart(document.getElementById('chart1'), {
            type: 'bar',
            data: {
                labels: dataForYear.equipment.labels,
                datasets: [{
                    label: 'Equipment Count',
                    data: dataForYear.equipment.values,
                    backgroundColor: colors.blue.bg,
                    borderColor: colors.blue.border,
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: chartOptions
        });

        // User Chart
        if (chart2) chart2.destroy();
        chart2 = new Chart(document.getElementById('chart2'), {
            type: 'line',
            data: {
                labels: dataForYear.users.labels,
                datasets: [{
                    label: 'Active Users',
                    data: dataForYear.users.values,
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
        if (chart3) chart3.destroy();
        chart3 = new Chart(document.getElementById('chart3'), {
            type: 'pie',
            data: {
                labels: dataForYear.returned.labels,
                datasets: [{
                    label: 'Returned Items',
                    data: dataForYear.returned.values,
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
        if (chart4) chart4.destroy();
        chart4 = new Chart(document.getElementById('chart4'), {
            type: 'doughnut',
            data: {
                labels: dataForYear.damaged.labels,
                datasets: [{
                    label: 'Damaged Items',
                    data: dataForYear.damaged.values,
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
    document.addEventListener('DOMContentLoaded', function() {
        initializeCharts({{ $currentYear }});
        
        // Add event listener for year selector
        document.getElementById('yearSelector').addEventListener('change', function() {
            const selectedYear = parseInt(this.value);
            initializeCharts(selectedYear);
        });
    });
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