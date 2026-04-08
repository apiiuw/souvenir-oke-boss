<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin' }} | Souvenir Oke Boss</title>
    <link rel="icon" type="image/png" href="{{ asset('img/icon/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/icon/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar-item-active {
            background-color: #fce7f3; /* pink-100 */
            color: #ec4899; /* pink-500 */
            border-right: 4px solid #ec4899;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 overflow-x-hidden">
    @include('partials.admin.sidebar')

    <!-- Main Content -->
    <main class="lg:ml-64 min-h-screen transition-all">
        @include('partials.admin.header')

        <!-- Page Content -->

        <!-- Page Content -->
        <div class="p-6 md:p-10">
            @yield('admin_container')
        </div>
    </main>

    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        
        sidebarToggle?.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });

        // Close sidebar on mobile when clicking outside
        document.addEventListener('click', (e) => {
            if (window.innerWidth < 1024 && !sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                sidebar.classList.add('-translate-x-full');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
