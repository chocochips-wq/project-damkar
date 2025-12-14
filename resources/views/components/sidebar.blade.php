<aside class="w-64 bg-gray-100 border-r border-gray-200 flex flex-col">

    {{-- LOGO --}}
    <div class="h-16 flex items-center gap-3 px-6 border-b bg-white">
        <img src="{{ asset('images/logo-damkar.png') }}" alt="Logo" class="h-8">
        <div>
            <h1 class="text-sm font-bold text-gray-900">PEP DAMKAR</h1>
            <p class="text-xs text-gray-500">Manajemen Dokumen</p>
        </div>
    </div>

    {{-- NEW BUTTON --}}
    <div class="px-4 py-4">
        <button
            onclick="document.getElementById('newMenu').classList.toggle('hidden')"
            class="w-full flex items-center gap-2 px-4 py-2 bg-white border rounded-lg shadow-sm
                   hover:bg-gray-50 text-sm font-medium text-gray-700">

            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4v16m8-8H4"/>
            </svg>
            New
        </button>

        {{-- DROPDOWN NEW --}}
        <div id="newMenu"
             class="hidden mt-2 bg-white border rounded-lg shadow-lg text-sm">

            <a href="#" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100">
                📁 Folder baru
            </a>

            <a href="#" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100">
                📄 Upload file
            </a>

            <a href="#" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100">
                📂 Upload folder
            </a>
        </div>
    </div>

    {{-- MENU --}}
    <nav class="flex-1 px-2 space-y-1 text-sm">

        {{-- Beranda --}}
        <a href="{{ route('beranda') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-lg
           {{ request()->routeIs('beranda') ? 'bg-purple-100 text-purple-700' : 'text-gray-700 hover:bg-gray-200' }}">
            🏠 Beranda
        </a>

        {{-- Perencanaan --}}
        <a href="{{ route('perencanaan') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-lg
           {{ request()->routeIs('perencanaan*') ? 'bg-purple-100 text-purple-700' : 'text-gray-700 hover:bg-gray-200' }}">
            📑 Perencanaan
        </a>

        {{-- Monitoring --}}
        <a href="{{ route('monitoring') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-lg
           {{ request()->routeIs('monitoring*') ? 'bg-purple-100 text-purple-700' : 'text-gray-700 hover:bg-gray-200' }}">
            📊 Monitoring & Pelaporan
        </a>

        {{-- Mekanisme --}}
        <a href="{{ route('mekanisme') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-lg
           {{ request()->routeIs('mekanisme*') ? 'bg-purple-100 text-purple-700' : 'text-gray-700 hover:bg-gray-200' }}">
            ⚙️ Mekanisme
        </a>

        {{-- Dokumentasi --}}
        <a href="{{ route('dokumentasi') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-lg
           {{ request()->routeIs('dokumentasi*') ? 'bg-purple-100 text-purple-700' : 'text-gray-700 hover:bg-gray-200' }}">
            🖼️ Dokumentasi
        </a>

        {{-- Dasar Hukum --}}
        <a href="{{ route('dasar-hukum') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-lg
           {{ request()->routeIs('dasar-hukum*') ? 'bg-purple-100 text-purple-700' : 'text-gray-700 hover:bg-gray-200' }}">
            📚 Dasar Hukum
        </a>
    </nav>

    {{-- PENGATURAN --}}
    <div class="px-2 py-3 border-t">
        <a href="{{ route('pengaturan') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-lg
           {{ request()->routeIs('pengaturan') ? 'bg-purple-100 text-purple-700' : 'text-gray-700 hover:bg-gray-200' }}">
            ⚙️ Pengaturan
        </a>
    </div>

</aside>
