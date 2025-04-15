@extends('layouts.superAdminApp')

@section('content')
<h1>Hello Super Admin</h1>

<div class="container">
    <div class="cards">
        <!-- Card for Admin -->
        <div class="card card-items" onclick="showModal('items')">
            <div class="card-icon">
            <span class="icon">📦</span>
            </div>
            <div class="card-title">TOTAL Admin</div>
            <div class="card-value">{{$count_admin}}</div>
            <div class="card-indicator indicator-up">
            ↑ 12.3% from last month
            </div>
        </div>
    </div>
</div>

      <!-- Modal for Admin -->
        <div id="modal-items" class="modal">
            <div class="modal-content">
            <span class="close-modal" onclick="closeModal('items')">&times;</span>
            <h2 class="modal-title">Total Admin</h2>
            <div class="modal-details">
                <p><strong>Current Total:</strong> {{$count_admin}} Admin</p>

            </div>
            </div>
        </div>

<div style="width: 45%; padding: 15px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1); background: #fff; position: relative;">
            <h3 style="position: absolute; top: 10px; left: 15px; margin: 0; font-size: 14px; color: #333;">Damaged Items</h3>
            <canvas id="chart1" style="margin-top: 25px;"></canvas>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Equipments
    const labels = @json($labels);
    const dataValues = @json($values);

    // Function to create a chart (Make sure the chart name matches the one you're calling)
    function createChartDamagedItems(chartId, chartType, label, bgColor, borderColor) {
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

    // Call the chart creation function correctly
    createChartDamagedItems('chart1', 'bar', 'Admin', 'rgba(54, 162, 235, 0.5)', 'rgba(54, 162, 235, 1)');
</script>

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

@endsection