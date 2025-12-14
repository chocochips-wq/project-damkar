<header class="bg-white border-b border-gray-200">
    <div class="flex items-center justify-between px-6 py-3 gap-6">

        {{-- JUDUL HALAMAN --}}
        <div class="flex-shrink-0">
            @yield('header-title')
        </div>

        {{-- SEARCH BAR (PAKAI KOMPONEN) --}}
        <div class="flex-1 max-w-xl">
            @include('components.search', [
                'placeholder' => 'Cari dokumen atau folder...'
            ])
        </div>

        {{-- USER INFO --}}
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-purple-100 rounded-full flex items-center justify-center">
                    <span class="text-purple-900 font-semibold text-sm">
                        {{ substr(Auth::guard('admin')->user()->nama_admin, 0, 1) }}
                    </span>
                </div>
                <div class="hidden md:block">
                    <p class="text-sm font-medium text-gray-900">
                        {{ Auth::guard('admin')->user()->nama_admin }}
                    </p>
                    <p class="text-xs text-gray-500">Administrator</p>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="p-2 rounded-lg hover:bg-gray-100 transition">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>

    </div>
</header>
