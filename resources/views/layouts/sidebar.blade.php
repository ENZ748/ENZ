<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Sidebar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 220px;
            background-color: rgb(0, 116, 232);
            padding-top: 20px;
            text-align: center;
            transition: 0.3s;
        }
        .sidebar img {
            width: 120px;
            height: 120px;
            background-color: white;
            padding: 10px;
            border-radius: 50%;
            display: block;
            margin: 0 auto 20px;
        }
        .sidebar a {
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        .sidebar a i {
            margin-right: 10px;
        }
        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        .content {
            margin-left: 240px;
            padding: 20px;
            transition: 0.3s;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                overflow: hidden;
            }
            .content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <button class="btn btn-primary d-md-none" onclick="toggleSidebar()" style="position: fixed; top: 10px; left: 10px; z-index: 1000;">
        <i class="fas fa-bars"></i>
    </button>
    
    <div class="sidebar" id="sidebar">
        <img src="EnzLogo.png" alt="Enz Logo">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{route('chart')}}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('inventory')}}">
                    <i class="fas fa-box"></i> Inventory
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('user')}}">
                    <i class="fas fa-users"></i> Users
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="accountability">
                    <i class="fas fa-file-invoice"></i> Accountability
                </a>
            </li>
        </ul>
    </div>
    
    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById("sidebar");
            if (sidebar.style.width === "220px") {
                sidebar.style.width = "0";
            } else {
                sidebar.style.width = "220px";
            }
        }
    </script>
</body>
</html>
