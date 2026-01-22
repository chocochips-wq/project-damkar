@extends('layouts.app')

@section('title', 'Monitoring & Pelaporan')

@section('header-title')
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Monitoring & Pelaporan</h1>
        <p class="text-sm text-gray-600">Dokumen monitoring dan pelaporan kegiatan</p>
    </div>
@endsection

@section('content')
    <div class="space-y-6">

        <!-- Search Bar -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            @include('components.search', ['placeholder' => 'Cari dokumen atau folder...'])
        </div>

        <!-- Breadcrumb Navigation -->
        @if(count($breadcrumbs) > 0)
            <nav class="flex items-center gap-2 text-sm bg-white rounded-lg shadow-sm p-4">
                <a href="{{ route('monitoring') }}" class="text-green-600 hover:text-green-700 font-medium flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                    </svg>
                    Beranda
                </a>
                @foreach($breadcrumbs as $breadcrumb)
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <a href="{{ route('monitoring', ['folder' => $breadcrumb->id_folder_mon]) }}" class="text-green-600 hover:text-green-700 font-medium">
                        {{ $breadcrumb->nama_folder_mon }}
                    </a>
                @endforeach
            </nav>
        @endif

        <!-- Folders Grid -->
        @if(count($folders) > 0)
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
                    </svg>
                    Folder
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach($folders as $folder)
                        <div class="group relative bg-gradient-to-br from-red-400 to-red-500 rounded-xl p-6 hover:from-red-500 hover:to-red-600 transition-all duration-300 shadow-md hover:shadow-xl transform hover:-translate-y-1">

                            <!-- Link ke folder -->
                            <a href="{{ route('monitoring', ['folder' => $folder->id_folder_mon, 'search' => request('search')]) }}" class="block">
                                <!-- Icon Folder -->
                                <div class="flex items-center justify-center mb-4">
                                    <div class="w-16 h-16 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                                        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Nama Folder -->
                                <h4 class="text-white font-semibold text-center text-sm leading-tight line-clamp-2 min-h-[40px] mb-3">
                                    {{ $folder->nama_folder_mon }}
                                </h4>

                                <!-- Info -->
                                <div class="flex items-center justify-between text-xs text-white/80">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $folder->files->count() }} file
                                    </span>
                                    <span>{{ $folder->created->format('Y') }}</span>
                                </div>
                            </a>

                            <!-- More Button -->
                            <div class="absolute top-3 right-3 z-20">
                                <button onclick="event.preventDefault(); event.stopPropagation(); toggleDropdown('folder-{{ $folder->id_folder_mon }}')" class="w-6 h-6 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center backdrop-blur-sm transition">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"/>
                                    </svg>
                                </button>

                                <!-- Dropdown Menu -->
                                <div id="folder-{{ $folder->id_folder_mon }}" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl z-50 border border-gray-200">
                                    <div class="py-1">
                                        <button onclick="renameFolder('{{ $folder->id_folder_mon }}', '{{ addslashes($folder->nama_folder_mon) }}')" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Rename
                                        </button>
                                        <button onclick="deleteFolder('{{ $folder->id_folder_mon }}', '{{ addslashes($folder->nama_folder_mon) }}')" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Files List -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                </svg>
                Dokumen
                @if($files->total() > 0)
                    <span class="text-sm text-gray-500">({{ $files->total() }})</span>
                @endif
            </h3>

            <div class="space-y-3">
                @forelse($files as $file)
                    <div class="relative p-4 border-2 border-gray-200 rounded-xl hover:border-green-400 hover:bg-green-50 transition-all duration-300 group">
                        <div class="flex items-center justify-between">
                            <a href="{{ $file->link }}" target="_blank" class="flex items-center gap-4 flex-1 min-w-0">
                                <!-- Icon -->
                                <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-md group-hover:shadow-lg transition-shadow">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                    </svg>
                                </div>

                                <!-- Info -->
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-gray-900 truncate group-hover:text-green-700 transition">
                                        {{ $file->nama_file }}
                                    </p>
                                    <div class="flex items-center gap-3 mt-1 text-sm text-gray-500">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $file->pemilik }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $file->created->format('d M Y H:i') }}
                                        </span>
                                    </div>
                                </div>
                            </a>

                            <!-- More Button -->
                            <div class="relative">
                                <button onclick="event.preventDefault(); event.stopPropagation(); toggleDropdown('file-{{ $file->id_monitoring }}')" class="p-2 hover:bg-gray-100 rounded-lg transition">
                                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"/>
                                    </svg>
                                </button>

                                <!-- Dropdown Menu -->
                                <div id="file-{{ $file->id_monitoring }}" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl z-50 border border-gray-200">
                                    <div class="py-1">
                                        <a href="{{ $file->link }}" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                            </svg>
                                            Download
                                        </a>
                                        <button onclick="renameFile('{{ $file->id_monitoring }}', '{{ addslashes($file->nama_file) }}')" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Rename
                                        </button>
                                        <button onclick="deleteFile('{{ $file->id_monitoring }}', '{{ addslashes($file->nama_file) }}')" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Tidak ada dokumen</h4>
                        <p class="text-gray-500">
                            @if(request('search'))
                                Tidak ada hasil untuk "{{ request('search') }}"
                            @else
                                Folder ini belum memiliki dokumen
                            @endif
                        </p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($files->hasPages())
                <div class="mt-6 border-t pt-4">
                    {{ $files->appends(['search' => request('search'), 'folder' => request('folder')])->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Context Menu (Google Drive Style) -->
    <div id="contextMenu" class="hidden fixed bg-white rounded-xl shadow-2xl border border-gray-200 py-2 z-50 min-w-[220px]">
        <button onclick="openCreateFolder()" class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 flex items-center gap-3 transition group">
            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <span class="font-medium">New Folder</span>
        </button>
        
        <div class="border-t border-gray-200 my-1"></div>
        
        <button onclick="document.getElementById('fileInput').click()" class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-green-50 flex items-center gap-3 transition group">
            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
            </div>
            <span class="font-medium">File Upload</span>
        </button>
        
        <button onclick="document.getElementById('folderInput').click()" class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-purple-50 flex items-center gap-3 transition group">
            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition">
                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                </svg>
            </div>
            <span class="font-medium">Folder Upload</span>
        </button>
    </div>

    <!-- Hidden File Inputs -->
    <input type="file" id="fileInput" multiple class="hidden" onchange="handleFileUpload(event)">
    <input type="file" id="folderInput" webkitdirectory directory multiple class="hidden" onchange="handleFolderUpload(event)">

    <!-- Modal Create Folder -->
    <div id="modalCreateFolder" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4 rounded-t-2xl">
                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                    </svg>
                    New Folder
                </h3>
            </div>
            <form id="formCreateFolder" class="p-6">
                <input 
                    type="text" 
                    id="folderNameInput"
                    name="nama_folder" 
                    required 
                    maxlength="255"
                    placeholder="Untitled folder"
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                >
                <div class="flex gap-3 mt-6">
                    <button 
                        type="button" 
                        onclick="closeModal('modalCreateFolder')" 
                        class="flex-1 px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition"
                    >
                        Cancel
                    </button>
                    <button 
                        type="submit" 
                        class="flex-1 bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition shadow-lg"
                    >
                        Create
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Upload Progress Modal -->
    <div id="uploadProgress" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Uploading...</h3>
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <div class="animate-spin rounded-full h-8 w-8 border-4 border-blue-500 border-t-transparent"></div>
                    <span id="uploadStatus" class="text-sm text-gray-600">Processing files...</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div id="uploadProgressBar" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle Dropdown
        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            const allDropdowns = document.querySelectorAll('[id^="folder-"], [id^="file-"]');

            allDropdowns.forEach(d => {
                if (d.id !== id) d.classList.add('hidden');
            });

            dropdown.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('button')) {
                document.querySelectorAll('[id^="folder-"], [id^="file-"]').forEach(d => {
                    d.classList.add('hidden');
                });
            }
        });

        // Context Menu
        document.addEventListener('contextmenu', function(e) {
            const isValidArea = e.target.closest('.space-y-6') || 
                               e.target.closest('.bg-white') || 
                               e.target.classList.contains('bg-gray-50');
            
            if (isValidArea && !e.target.closest('a') && !e.target.closest('button')) {
                e.preventDefault();
                const menu = document.getElementById('contextMenu');
                menu.style.left = e.pageX + 'px';
                menu.style.top = e.pageY + 'px';
                menu.classList.remove('hidden');
            }
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('#contextMenu')) {
                document.getElementById('contextMenu').classList.add('hidden');
            }
        });

        // Create Folder
        function openCreateFolder() {
            document.getElementById('contextMenu').classList.add('hidden');
            document.getElementById('modalCreateFolder').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('folderNameInput').focus();
                document.getElementById('folderNameInput').select();
            }, 100);
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        document.getElementById('formCreateFolder').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            const currentFolder = '{{ request("folder") }}';

            try {
                const response = await fetch('{{ route("monitoring.folder.create") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        nama_folder: formData.get('nama_folder'),
                        id_parent: currentFolder || null
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    closeModal('modalCreateFolder');
                    location.reload();
                } else {
                    alert(data.message);
                }
            } catch (error) {
                alert('Terjadi kesalahan');
            }
        });

        // File Upload
        async function handleFileUpload(event) {
            const files = event.target.files;
            if (files.length === 0) return;

            document.getElementById('contextMenu').classList.add('hidden');
            document.getElementById('uploadProgress').classList.remove('hidden');
            document.getElementById('uploadStatus').textContent = `Uploading ${files.length} file(s)...`;

            const currentFolder = '{{ request("folder") }}';

            for (let i = 0; i < files.length; i++) {
                const formData = new FormData();
                formData.append('file', files[i]);
                formData.append('id_folder', currentFolder || '');

                try {
                    await fetch('{{ route("monitoring.file.upload") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    });

                    const progress = ((i + 1) / files.length) * 100;
                    document.getElementById('uploadProgressBar').style.width = progress + '%';
                    document.getElementById('uploadStatus').textContent = `Uploading ${i + 1}/${files.length}...`;

                } catch (error) {
                    console.error('Upload error:', error);
                }
            }

            setTimeout(() => {
                document.getElementById('uploadProgress').classList.add('hidden');
                location.reload();
            }, 500);
        }

        // Folder Upload
        async function handleFolderUpload(event) {
            const files = event.target.files;
            if (files.length === 0) return;

            document.getElementById('contextMenu').classList.add('hidden');
            document.getElementById('uploadProgress').classList.remove('hidden');
            document.getElementById('uploadStatus').textContent = `Uploading ${files.length} file(s)...`;

            const currentFolder = '{{ request("folder") }}';

            for (let i = 0; i < files.length; i++) {
                const formData = new FormData();
                formData.append('file', files[i]);
                formData.append('id_folder', currentFolder || '');

                try {
                    await fetch('{{ route("monitoring.folder.upload") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    });

                    const progress = ((i + 1) / files.length) * 100;
                    document.getElementById('uploadProgressBar').style.width = progress + '%';
                    document.getElementById('uploadStatus').textContent = `Uploading ${i + 1}/${files.length}...`;

                } catch (error) {
                    console.error('Upload error:', error);
                }
            }

            setTimeout(() => {
                document.getElementById('uploadProgress').classList.add('hidden');
                location.reload();
            }, 500);
        }
    </script>
@endsection