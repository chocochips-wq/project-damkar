<!-- Advanced Search & Filter Component -->
<div class="space-y-4">
    <!-- Search Input -->
    <div class="flex flex-col md:flex-row gap-3">
        <form method="GET" class="flex-1 relative">
            <!-- Preserve all query parameters except 'search' -->
            @foreach(request()->query() as $key => $value)
                @if($key !== 'search')
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endforeach

            <svg class="absolute left-3 top-3 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="search" id="searchInput" placeholder="{{ $placeholder ?? 'Cari...' }}" 
                value="{{ request('search') }}"
                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
        </form>

        <div class="flex gap-2">
            <!-- Filter Button -->
            <button type="button" id="filterToggle" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition flex items-center justify-center gap-2 flex-1 md:flex-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filter
            </button>

            <!-- Clear Filter -->
            @if(request('search') || request('start_date') || request('end_date'))
                <a href="{{ request()->url() }}" class="px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg font-medium transition flex items-center justify-center gap-2 flex-1 md:flex-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Bersihkan
                </a>
            @endif
        </div>
    </div>

    <!-- Filter Panel (Hidden by default) -->
    <div id="filterPanel" class="hidden space-y-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
        <form method="GET" class="space-y-3">
            <!-- Preserve other query parameters -->
            @foreach(request()->query() as $key => $value)
                @if(!in_array($key, ['search', 'start_date', 'end_date', 'folder']))
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endforeach
            
            @if(request('folder'))
                <input type="hidden" name="folder" value="{{ request('folder') }}">
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <!-- Search Input -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                    <input type="text" name="search" placeholder="Cari nama file atau folder..."
                        value="{{ request('search') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                </div>

                <!-- Date Range -->
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                        <input type="date" name="start_date" 
                            value="{{ request('start_date') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date"
                            value="{{ request('end_date') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-2 justify-end pt-2">
                <button type="button" id="filterClose" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    Tutup
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1H3zm0 3h14v9a2 2 0 01-2 2H5a2 2 0 01-2-2V6z" clip-rule="evenodd"/>
                    </svg>
                    Terapkan Filter
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const filterToggle = document.getElementById('filterToggle');
    const filterPanel = document.getElementById('filterPanel');
    const filterClose = document.getElementById('filterClose');

    if (filterToggle && filterPanel && filterClose) {
        filterToggle.addEventListener('click', function() {
            filterPanel.classList.toggle('hidden');
        });

        filterClose.addEventListener('click', function() {
            filterPanel.classList.add('hidden');
        });

        // Close filter when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('#filterToggle') && 
                !event.target.closest('#filterPanel')) {
                filterPanel.classList.add('hidden');
            }
        });
    }
</script>
