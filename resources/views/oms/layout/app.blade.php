<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management System</title>

    <!-- Preconnect for Faster External Resource Loading -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Google Font: Pacifico -->
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

    <!-- Remix Icon CDN -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">

    <!-- Tailwind CSS (Optimized Loading) -->
    <link rel="preload" href="https://cdn.tailwindcss.com" as="script">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.5.0/echarts.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4F46E5',
                        secondary: '#6B7280'
                    },
                    borderRadius: {
                        'none': '0px',
                        'sm': '4px',
                        DEFAULT: '8px',
                        'md': '12px',
                        'lg': '16px',
                        'xl': '20px',
                        '2xl': '24px',
                        '3xl': '32px',
                        'full': '9999px',
                        'button': '8px'
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- ECharts Library (Deferred for Better Performance) -->
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.5.0/echarts.min.js"></script>

    <!-- Inline Critical CSS for Faster Rendering -->
    <style>
        :where([class^="ri-"])::before {
            content: "\f3c2";
        }

        body { visibility: hidden; }
        body.loaded { visibility: visible; }

        .chart-container {
            width: 100%;
            height: 300px;
        }

        .dropdown {
            display: none;
            position: absolute;
            z-index: 50;
        }

        .dropdown.active {
            display: block;
        }

        .loader-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        @media (max-width: 1024px) {
            #sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                z-index: 50;
            }
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-50" onload="document.body.classList.add('loaded'); document.getElementById('loader-overlay').style.display = 'none';">
    <div id="loader-overlay" class="loader-overlay">
        <p>Page is under loading...</p>
    </div>

    <div class="flex h-screen">
        @include('oms.layout.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('oms.layout.header')

            @yield('content')
        </div>
    </div>

    <!-- Interactive JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const userMenuBtn = document.getElementById('userMenuBtn');
            const userMenu = document.getElementById('userMenu');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');

            // Toggle User Menu
            userMenuBtn?.addEventListener('click', () => {
                userMenu?.classList.toggle('active');
            });

            document.addEventListener('click', (e) => {
                if (!userMenuBtn?.contains(e.target) && !userMenu?.contains(e.target)) {
                    userMenu?.classList.remove('active');
                }
            });

            // Sidebar Toggle
            sidebarToggle?.addEventListener('click', () => {
                sidebar?.classList.toggle('hidden');
            });

            document.addEventListener('click', (e) => {
                if (!sidebarToggle?.contains(e.target) && !sidebar?.contains(e.target) && window.innerWidth < 1024) {
                    sidebar?.classList.add('hidden');
                }
            });

            // Auto-hide Sidebar on Resize
            window.addEventListener('resize', () => {
                window.innerWidth >= 1024 ? sidebar?.classList.remove('hidden') : sidebar?.classList.add('hidden');
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
