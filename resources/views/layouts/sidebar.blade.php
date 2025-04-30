<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stable Sidebar Navigation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0074e8;
            --primary-dark: #005ab4;
            --primary-light: #e6f2ff;
            --sidebar-width: 250px;
            --transition-speed: 0.3s;
        }
        
        body {
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
            transition: margin-left var(--transition-speed);
        }
        
        /* Enhanced Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 0;
            left: -250px;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-color), var(--primary-dark));
            padding-top: 20px;
            text-align: center;
            transition: all var(--transition-speed) ease-in-out;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }
        
        .sidebar.open {
            left: 0;
        }
        
        .sidebar img {
            width: 120px;
            height: 120px;
            background-color: white;
            padding: 10px;
            border-radius: 50%;
            margin: 0 auto 20px;
            border: 3px solid white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .sidebar img:hover {
            transform: scale(1.05);
        }
        
        .sidebar .nav {
            flex: 1;
            overflow-y: auto;
            padding: 0 15px;
            margin-top: 20px;
        }
        
        .sidebar .nav-item {
            margin-bottom: 8px;
            border-radius: 8px;
            overflow: hidden;
            height: 44px;
        }
        
        .sidebar .nav-link {
            color: white;
            padding: 12px 15px;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: background-color var(--transition-speed) ease;
            border-radius: 8px;
            font-weight: 500;
            white-space: nowrap;
            height: 100%;
            box-sizing: border-box;
        }
        
        .sidebar .nav-link i {
            width: 24px;
            text-align: center;
            margin-right: 15px;
            font-size: 1.1rem;
            flex-shrink: 0;
            transition: none; /* Remove transition from icons */
        }
        
        .sidebar .nav-link span {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            flex-grow: 1;
            transition: none; /* Remove transition from text */
        }
        
        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
        }
        
        .sidebar .nav-link.active {
            background-color: var(--primary-light);
            color: var(--primary-dark);
            font-weight: 600;
            transform: none; /* Remove any transform */
        }
        
        .sidebar .nav-link.active i {
            color: var(--primary-dark);
            /* No position changes */
        }
        
        /* Ensure all icons have same styling */
        .sidebar .nav-link i.fa-file-invoice,
        .sidebar .nav-link i.fa-history,
        .sidebar .nav-link i.fa-tachometer-alt,
        .sidebar .nav-link i.fa-box,
        .sidebar .nav-link i.fa-users,
        .sidebar .nav-link i.fa-file-contract,
        .sidebar .nav-link i.fa-warehouse {
            width: 24px;
            margin-right: 15px;
            font-size: 1.1rem;
        }
        
        .content {
            margin-left: 0;
            padding: 20px;
            transition: all var(--transition-speed);
            min-height: 100vh;
        }
        
        /* Overlay with animation */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            visibility: hidden;
            transition: opacity var(--transition-speed), visibility var(--transition-speed);
            z-index: 999;
        }
        
        .overlay.show {
            opacity: 1;
            visibility: visible;
        }
        
        /* Enhanced Toggle Button */
        .toggle-btn {
            position: fixed;
            top: 15px;
            left: 15px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 1100;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }
        
        .toggle-btn:hover {
            background-color: var(--primary-dark);
            transform: scale(1.1);
        }
        
        /* Desktop styles */
        @media (min-width: 769px) {
            .sidebar {
                left: 0;
            }
            
            .content {
                margin-left: var(--sidebar-width);
            }
            
            .toggle-btn {
                display: none;
            }
            
            .overlay {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <!-- Toggle Button - Always visible on mobile -->
    <button class="toggle-btn d-lg-none" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Enhanced Sidebar -->
    <div class="sidebar" id="sidebar">
        <img src="{{ asset('EnzLogo.png') }}" alt="Enz Logo" class="logo">
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{route('chart')}}" onclick="handleNavClick(this)">
                    <i class="fas fa-tachometer-alt"></i> 
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('items')}}" onclick="handleNavClick(this)">
                    <i class="fas fa-box"></i> 
                    <span>Inventory</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('user')}}" onclick="handleNavClick(this)">
                    <i class="fas fa-users"></i> 
                    <span>Users</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('assigned_items.index')}}" onclick="handleNavClick(this)">
                    <i class="fas fa-file-invoice"></i> 
                    <span>Accountability</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('instock')}}" onclick="handleNavClick(this)">
                    <i class="fas fa-warehouse"></i> 
                    <span>In Stock</span>
                </a>
            </li> 
            <li class="nav-item">
                <a class="nav-link" href="{{route('assigned_items.forms')}}" onclick="handleNavClick(this)">
                    <i class="fas fa-file-contract"></i> 
                    <span>Forms</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('item.history')}}" onclick="handleNavClick(this)">
                    <i class="fas fa-history"></i> 
                    <span>History</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Overlay -->
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            const overlay = document.getElementById("overlay");
            
            sidebar.classList.toggle("open");
            overlay.classList.toggle("show");
            
            if (sidebar.classList.contains("open")) {
                document.body.style.overflow = "hidden";
            } else {
                document.body.style.overflow = "";
            }
        }
        
        function handleNavClick(clickedLink) {
            // Remove active class from all links
            document.querySelectorAll('.sidebar .nav-link').forEach(link => {
                link.classList.remove('active');
            });
            
            // Add active class to clicked link without changing position
            clickedLink.classList.add('active');
            
            // Close sidebar on mobile
            if (window.innerWidth <= 768) {
                toggleSidebar();
            }
        }
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById("sidebar");
            const overlay = document.getElementById("overlay");
            const toggleBtn = document.querySelector('.toggle-btn');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                event.target !== toggleBtn && 
                sidebar.classList.contains('open')) {
                toggleSidebar();
            }
        });
        
        // Highlight active menu item based on page load
        document.addEventListener('DOMContentLoaded', function() {
            const currentUrl = window.location.href;
            const navLinks = document.querySelectorAll('.sidebar .nav-link');
            
            navLinks.forEach(link => {
                if (currentUrl.includes(link.getAttribute('href'))) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>