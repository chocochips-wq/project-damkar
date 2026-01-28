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

</body>
</html>
