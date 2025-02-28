<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management System</title>

    <!-- Inline loader styles to ensure they load first -->
    <style>
        /* Immediate loader display */
        #page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.3s ease-out;
        }

        /* From Uiverse.io by Rajan1092 */
        .spinner {
            width: 56px;
            height: 56px;
            display: grid;
        }

        .spinner::before,
        .spinner::after {
            content: "";
            grid-area: 1/1;
            background: var(--c) 50% 0,
                var(--c) 50% 100%,
                var(--c) 100% 50%,
                var(--c) 0 50%;
            background-size: 13.4px 13.4px;
            background-repeat: no-repeat;
            animation: spinner-3hs4a3 1s infinite;
        }

        .spinner::before {
            --c: radial-gradient(farthest-side, #4F46E5 92%, #0000);
            margin: 4.5px;
            background-size: 9px 9px;
            animation-timing-function: linear;
        }

        .spinner::after {
            --c: radial-gradient(farthest-side, #4F46E5 92%, #0000);
        }

        @keyframes spinner-3hs4a3 {
            100% {
                transform: rotate(.5turn);
            }
        }

        /* Hide all content until fully loaded */
        .content-wrapper {
            opacity: 0;
            transition: opacity 0.3s ease-in;
        }

        .content-wrapper.loaded {
            opacity: 1;
        }
    </style>

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

    <!-- Script to show loader immediately, before DOM is fully parsed -->
    <script>
        // Create and show loader immediately
        document.write('<div id="page-loader"><div class="spinner"></div><p class="mt-4 text-gray-600 font-medium">Loading...</p></div>');
    </script>

    @stack('styles')
</head>

<body class="bg-gray-50">
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <div class="flex h-screen">
            @include('oms.layout.sidebar')

            <div class="flex-1 flex flex-col overflow-hidden">
                @include('oms.layout.header')

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Interactive JavaScript -->
    <script>
        // Wait for all resources to load
// Wait for all resources to load
window.addEventListener('load', () => {
    const loader = document.getElementById('page-loader');
    const contentWrapper = document.querySelector('.content-wrapper');

    // Show content
    contentWrapper.classList.add('loaded');

    // Set a delay before starting to hide the loader
    setTimeout(() => {
        // Start fade out
        loader.style.opacity = '0';

        // Remove from DOM after transition completes
        setTimeout(() => {
            loader.style.display = 'none';
        }, 300); // This matches your transition time
    }, 500); // Set this to how long you want the loader to show (5 seconds in this example)
});

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
