<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Sidebar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 220px;
            background-color: rgb(0, 116, 232);
            padding-top: 20px;
            text-align: center;
            transition: all 0.3s ease-in-out;
            z-index: 1000;
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
            background-color: rgb(0, 90, 180);
        }
        
        .content {
            margin-left: 220px;
            padding: 20px;
            transition: all 0.3s;
        }

        /* Responsive Sidebar */
        @media (max-width: 768px) {
            .sidebar {
                left: -220px;
            }
            .sidebar.open {
                left: 0;
            }
            .content {
                margin-left: 0;
            }
            .overlay {
                display: block;
            }
        }

        /* Button for toggling sidebar */
        .toggle-btn {
            position: fixed;
            top: 15px;
            left: 15px;
            background-color: rgb(0, 116, 232);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            z-index: 1100;
        }

        /* Overlay to cover content when sidebar is open */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 999;
        }
        .overlay.show {
            display: block;
        }

        /* Keep sidebar visible on larger screens */
        @media (min-width: 769px) {
            .sidebar {
                left: 0;
            }
            .content {
                margin-left: 220px;
            }
        }
    </style>
</head>
<body>

    <!-- Toggle Button -->
    <button class="toggle-btn d-md-none" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <img src="EnzLogo.png" alt="Enz Logo">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{route('chart')}}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('items')}}">
                    <i class="fas fa-box"></i> Inventory
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('user')}}">
                    <i class="fas fa-users"></i> Users
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('assigned_items.index')}}">
                    <i class="fas fa-file-invoice"></i> Accountability
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('item.history')}}">
                    <i class="fas fa-file-invoice"></i> History
                </a>
            </li>
        </ul>
    </div>

    <!-- Overlay -->
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("open");
            document.getElementById("overlay").classList.toggle("show");
        }
    </script>

</body>
</html>
