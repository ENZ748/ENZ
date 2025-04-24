<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Sidebar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 220px;
            --sidebar-bg: rgb(0, 116, 232);
            --sidebar-hover: rgb(0, 90, 180);
            --transition-speed: 0.3s;
        }

        /* Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            padding-top: 1.5rem;
            text-align: center;
            transition: all var(--transition-speed) ease;
            z-index: 1000;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar img {
            width: 120px;
            height: 120px;
            background-color: white;
            padding: 10px;
            border-radius: 50%;
            display: block;
            margin: 0 auto 1.5rem;
            object-fit: contain;
        }

        .sidebar .nav {
            width: 100%;
        }

        .sidebar .nav-item {
            width: 100%;
        }

        .sidebar .nav-link {
            color: white;
            padding: 0.75rem 1.5rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
            margin: 0.25rem 0;
        }

        .sidebar .nav-link i {
            width: 24px;
            text-align: center;
            margin-right: 12px;
            font-size: 1.1rem;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link:focus {
            background-color: var(--sidebar-hover);
            border-left-color: white;
        }

        /* Content area */
        .content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: margin var(--transition-speed) ease;
            min-height: 100vh;
        }

        /* Toggle Button */
        .toggle-btn {
            position: fixed;
            top: 15px;
            left: 15px;
            background-color: var(--sidebar-bg);
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 12px;
            cursor: pointer;
            z-index: 1100;
            transition: all var(--transition-speed) ease;
            display: none;
        }

        .toggle-btn:hover {
            background-color: var(--sidebar-hover);
            transform: scale(1.05);
        }

        /* Overlay */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            visibility: hidden;
            transition: opacity var(--transition-speed) ease, visibility var(--transition-speed) ease;
            z-index: 999;
            cursor: pointer;
        }

        .overlay.show {
            opacity: 1;
            visibility: visible;
        }

        /* Responsive Behavior */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .content {
                margin-left: 0;
            }

            .toggle-btn {
                display: block;
            }

            .sidebar.open ~ .toggle-btn {
                left: calc(var(--sidebar-width) + 15px);
            }
        }

        /* Smooth transitions for larger screens */
        @media (min-width: 769px) {
            .sidebar {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body>
    <!-- Toggle Button (hidden on desktop) -->
    <button class="toggle-btn" onclick="toggleSidebar()" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <img src="{{ asset('EnzLogo.png') }}" alt="Enz Logo">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{route('superAdmin.dashboard')}}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin')}}">
                    <i class="fas fa-users"></i> Admin Accounts
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.activityLogs')}}">
                    <i class="fas fa-file-invoice"></i> Activity Logs
                </a>
            </li>   
        </ul>
    </nav>

    <!-- Overlay (for mobile) -->
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            const overlay = document.getElementById("overlay");
            
            sidebar.classList.toggle("open");
            overlay.classList.toggle("show");
            
            // Prevent scrolling when sidebar is open
            document.body.style.overflow = sidebar.classList.contains("open") ? 'hidden' : '';
        }

        // Close sidebar when clicking on a nav link (for mobile)
        document.querySelectorAll('.sidebar .nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    toggleSidebar();
                }
            });
        });
    </script>
</body>
</html>