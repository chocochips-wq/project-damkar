<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - PEP DAMKAR</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">

        {{-- Sidebar --}}
        @include('components.sidebar')

        {{-- Mobile Overlay --}}
        <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden md:hidden transition-opacity duration-300 opacity-0"></div>

        {{-- Main --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- Header --}}
            @include('components.header')

            {{-- Content --}}
            <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
                @yield('content')
            </main>

        </div>
    </div>

    {{-- SCRIPT HALAMAN (WAJIB ADA) --}}
    @yield('scripts')

    {{-- Universal context menu component (reads window.ContextMenuConfig) --}}
    @include('components.context-menu')

    {{-- Modal Components untuk Sidebar New Menu --}}
    @include('components.modals')

    {{-- App Scripts --}}
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const burgerBtn = document.getElementById('burgerBtn');
            const closeSidebarBtn = document.getElementById('closeSidebarBtn');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            function openSidebar() {
                sidebar.classList.remove('hidden', '-translate-x-full');
                sidebar.classList.add('flex', 'translate-x-0');
                overlay.classList.remove('hidden');
                // Small delay to allow transition
                setTimeout(() => {
                    overlay.classList.remove('opacity-0');
                }, 10);
            }

            function closeSidebar() {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('opacity-0');
                
                // Wait for transition to finish before hiding
                setTimeout(() => {
                    sidebar.classList.add('hidden');
                    sidebar.classList.remove('flex');
                    overlay.classList.add('hidden');
                }, 300);
            }

            if (burgerBtn) {
                burgerBtn.addEventListener('click', openSidebar);
            }

            if (closeSidebarBtn) {
                closeSidebarBtn.addEventListener('click', closeSidebar);
            }

            if (overlay) {
                overlay.addEventListener('click', closeSidebar);
            }
        });
    </script>

</body>
</html>
