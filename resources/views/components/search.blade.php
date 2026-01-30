<form method="GET" 
      class="flex gap-2 bg-white/80 backdrop-blur-sm p-2 rounded-xl shadow-sm border border-gray-200">

    <input 
        type="text" 
        name="search" 
        value="{{ $search ?? '' }}" 
        placeholder="{{ $placeholder ?? 'Cari dokumen...' }}" 
        class="flex-1 min-w-0 px-3 py-2 md:px-4 text-sm bg-transparent border border-gray-300 rounded-lg
               focus:ring-2 focus:ring-purple-500 focus:border-transparent placeholder-gray-400"
    >

    <button type="submit"
        class="px-6 py-2 bg-gradient-to-r from-purple-600 to-red-600
               text-white rounded-lg hover:from-purple-700 hover:to-red-700
               transition shadow">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
    </button>
</form>
