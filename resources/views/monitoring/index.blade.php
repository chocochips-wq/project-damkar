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

        <!-- Search & Filter Bar -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            @include('components.advanced-search', ['placeholder' => 'Cari dokumen atau folder...'])
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
                                        <button class="btn-delete-folder w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2"
                                                data-id="{{ $folder->id_folder_mon }}"
                                                data-name="{{ $folder->nama_folder_mon }}"
                                                data-url="{{ route('monitoring.folder.delete', $folder->id_folder_mon) }}">
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
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                    </svg>
                    Dokumen
                    @if($files->total() > 0)
                        <span class="text-sm text-gray-500">({{ $files->total() }})</span>
                    @endif
                </h3>
                <button onclick="showAddLinkModal()" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Link
                </button>
            </div>
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
                                        <a href="{{ route('monitoring.file.download', $file->id_monitoring) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
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
                                        <button class="btn-delete-file w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2"
                                                data-id="{{ $file->id_monitoring }}"
                                                data-name="{{ $file->nama_file }}"
                                                data-url="{{ route('monitoring.file.delete', $file->id_monitoring) }}">
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

@endsection

@section('scripts')
    {{-- context menu config as JSON to avoid embedding Blade tokens inside JS source (helps editors/linters) --}}
    <script id="context-menu-config" type="application/json">
        {!! json_encode([
            'createUrl' => Route::has('monitoring.folder.create') ? route('monitoring.folder.create') : '',
            'fileUploadUrl' => Route::has('monitoring.file.upload') ? route('monitoring.file.upload') : '',
            'folderUploadUrl' => Route::has('monitoring.folder.upload') ? route('monitoring.folder.upload') : '',
            'currentFolder' => request('folder'),
            'allowedSelector' => '.space-y-6'
        ]) !!}
    </script>
    <script>
        try {
            const cfgEl = document.getElementById('context-menu-config');
            window.ContextMenuConfig = cfgEl ? JSON.parse(cfgEl.textContent) : {};
        } catch (e) {
            window.ContextMenuConfig = {};
        }
    </script>
    <script>
        // Rename Folder
        async function renameFolder(id, currentName) {
            showRenameModal('Folder', currentName, async (newName) => {
                if (newName && newName !== currentName) {
                    try {
                        const response = await fetch(`/monitoring/folder/${id}/rename`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ name: newName })
                        });

                        const data = await response.json();
                        hideRenameModal();
                        if (data.success) {
                            showSuccessNotif(data.message);
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            showErrorNotif(data.message);
                        }
                    } catch (error) {
                        hideRenameModal();
                        showErrorNotif('Terjadi kesalahan');
                    }
                }
            });
        }

        // Rename File
        async function renameFile(id, currentName) {
            showRenameModal('File', currentName, async (newName) => {
                if (newName && newName !== currentName) {
                    try {
                        const response = await fetch(`/monitoring/file/${id}/rename`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ name: newName })
                        });

                        const data = await response.json();
                        hideRenameModal();
                        if (data.success) {
                            showSuccessNotif(data.message);
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            showErrorNotif(data.message);
                        }
                    } catch (error) {
                        hideRenameModal();
                        showErrorNotif('Terjadi kesalahan');
                    }
                }
            });
        }

        // Delete Folder (with modal confirmation)
        async function deleteFolder(id, name, url) {
            showDeleteModal('Folder', name, async () => {
                try {
                    const endpoint = url || `/monitoring/folder/${id}`;
                    const response = await fetch(endpoint, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    const data = await response.json();
                    hideDeleteModal();
                    if (data.success) {
                        showSuccessNotif(data.message);
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showErrorNotif(data.message);
                    }
                } catch (error) {
                    hideDeleteModal();
                    showErrorNotif('Terjadi kesalahan');
                }
            });
        }

        // Delete File (with modal confirmation)
        async function deleteFile(id, name, url) {
            showDeleteModal('File', name, async () => {
                try {
                    const endpoint = url || `/monitoring/file/${id}`;
                    const response = await fetch(endpoint, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    const data = await response.json();
                    hideDeleteModal();
                    if (data.success) {
                        showSuccessNotif(data.message);
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showErrorNotif(data.message);
                    }
                } catch (error) {
                    hideDeleteModal();
                    showErrorNotif('Terjadi kesalahan');
                }
            });
        }

        // Modal Functions
        function showDeleteModal(type, name, onConfirm) {
            const modal = document.getElementById('deleteModal');
            const modalTitle = document.getElementById('deleteModalTitle');
            const modalText = document.getElementById('deleteModalText');
            const confirmBtn = document.getElementById('confirmDeleteBtn');
            
            modalTitle.textContent = `Hapus ${type}`;
            modalText.innerHTML = `Apakah Anda yakin ingin menghapus <strong>${name}</strong>?<br><span class="text-sm text-gray-500">Tindakan ini tidak dapat dibatalkan.</span>`;
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            confirmBtn.onclick = onConfirm;
        }

        function hideDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function showSuccessNotif(message) {
            const notif = document.getElementById('successNotif');
            const notifText = document.getElementById('successNotifText');
            notifText.textContent = message;
            notif.classList.remove('hidden', 'translate-x-full');
            setTimeout(() => {
                notif.classList.add('translate-x-full');
                setTimeout(() => notif.classList.add('hidden'), 300);
            }, 3000);
        }

        function showErrorNotif(message) {
            const notif = document.getElementById('errorNotif');
            const notifText = document.getElementById('errorNotifText');
            notifText.textContent = message;
            notif.classList.remove('hidden', 'translate-x-full');
            setTimeout(() => {
                notif.classList.add('translate-x-full');
                setTimeout(() => notif.classList.add('hidden'), 300);
            }, 3000);
        }

        // Setup modal event listeners with delegation - delayed to ensure DOM is ready
        setTimeout(function() {
            document.addEventListener('click', function(e) {
                // Handle cancel button click
                const cancelBtn = e.target.closest('#cancelDeleteBtn');
                if (cancelBtn) {
                    e.preventDefault();
                    e.stopPropagation();
                    hideDeleteModal();
                    return;
                }

                // Handle clicking outside modal (on the dark overlay)
                const modal = document.getElementById('deleteModal');
                if (modal && e.target === modal) {
                    e.preventDefault();
                    e.stopPropagation();
                    hideDeleteModal();
                    return;
                }
            });
        }, 100);

        // Delegate delete button clicks to shared handlers
        document.addEventListener('click', function (e) {
            const btnFile = e.target.closest('.btn-delete-file');
            if (btnFile) {
                e.preventDefault();
                e.stopPropagation();
                deleteFile(btnFile.dataset.id, btnFile.dataset.name, btnFile.dataset.url);
                return;
            }

            const btnFolder = e.target.closest('.btn-delete-folder');
            if (btnFolder) {
                e.preventDefault();
                e.stopPropagation();
                deleteFolder(btnFolder.dataset.id, btnFolder.dataset.name, btnFolder.dataset.url);
                return;
            }
        });
    </script>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full transform transition-all">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-5 rounded-t-2xl flex items-center gap-3">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 id="deleteModalTitle" class="text-lg font-bold">Hapus Item</h3>
            </div>

            <!-- Modal Body -->
            <div class="px-6 py-6">
                <p id="deleteModalText" class="text-gray-700 text-center leading-relaxed"></p>
            </div>

            <!-- Modal Footer -->
            <div class="bg-gray-50 px-6 py-4 rounded-b-2xl flex gap-3 justify-end">
                <button id="cancelDeleteBtn" type="button" class="px-5 py-2.5 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium transition-colors">
                    Batal
                </button>
                <button id="confirmDeleteBtn" type="button" class="px-5 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-white font-medium transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Hapus
                </button>
            </div>
        </div>
    </div>

    <!-- Success Notification -->
    <div id="successNotif" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 transform transition-transform duration-300 translate-x-full z-40">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <span id="successNotifText">Success</span>
    </div>

    <!-- Error Notification -->
    <div id="errorNotif" class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 transform transition-transform duration-300 translate-x-full z-40">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
        </svg>
        <span id="errorNotifText">Error</span>
    </div>

    <!-- Rename Modal -->
    <div id="renameModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full transform transition-all">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-5 rounded-t-2xl flex items-center gap-3">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                <h3 id="renameModalTitle" class="text-lg font-bold">Ubah Nama</h3>
            </div>

            <!-- Modal Body -->
            <div class="px-6 py-6">
                <input type="text" id="renameInput" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Masukkan nama baru">
            </div>

            <!-- Modal Footer -->
            <div class="flex gap-3 px-6 py-4 border-t border-gray-200 rounded-b-2xl">
                <button id="cancelRenameBtn" class="flex-1 px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition">Batal</button>
                <button id="confirmRenameBtn" class="flex-1 px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded-lg font-medium transition">Simpan</button>
            </div>
        </div>
    </div>

    <script>
        let renameCallback = null;

        function showRenameModal(type, currentName, onConfirm) {
            const modal = document.getElementById('renameModal');
            const modalTitle = document.getElementById('renameModalTitle');
            const input = document.getElementById('renameInput');

            modalTitle.textContent = `Ubah Nama ${type}`;
            input.value = currentName;
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            renameCallback = onConfirm;
            
            // Focus input after modal appears
            setTimeout(() => input.focus(), 50);
        }

        function hideRenameModal() {
            const modal = document.getElementById('renameModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            renameCallback = null;
        }

        function confirmRename() {
            const input = document.getElementById('renameInput');
            const newName = input.value.trim();
            if (newName && renameCallback) {
                renameCallback(newName);
            }
        }

        // Event listeners for rename modal
        document.addEventListener('DOMContentLoaded', function() {
            const renameInput = document.getElementById('renameInput');
            const confirmRenameBtn = document.getElementById('confirmRenameBtn');
            const cancelRenameBtn = document.getElementById('cancelRenameBtn');
            const renameModal = document.getElementById('renameModal');

            // Confirm button click
            confirmRenameBtn.addEventListener('click', confirmRename);

            // Cancel button click
            cancelRenameBtn.addEventListener('click', hideRenameModal);

            // Enter key to confirm
            renameInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    confirmRename();
                }
            });

            // Escape key to cancel
            renameInput.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    hideRenameModal();
                }
            });

            // Click outside modal to close
            renameModal.addEventListener('click', (e) => {
                if (e.target === renameModal) {
                    hideRenameModal();
                }
            });
        });

        // Add Link Modal
        function showAddLinkModal() {
            const modal = document.getElementById('addLinkModal');
            const input = document.getElementById('addLinkInput');
            const nameInput = document.getElementById('addLinkNameInput');
            
            nameInput.value = '';
            input.value = '';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => nameInput.focus(), 50);
        }

        function hideAddLinkModal() {
            const modal = document.getElementById('addLinkModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function confirmAddLink() {
            const nameInput = document.getElementById('addLinkNameInput');
            const urlInput = document.getElementById('addLinkInput');
            const folderId = '{{ request('folder') }}';
            
            const namaFile = nameInput.value.trim();
            const link = urlInput.value.trim();
            
            if (!namaFile || !link) {
                showErrorNotif('Nama dan link harus diisi');
                return;
            }
            
            // Validate URL
            try {
                new URL(link);
            } catch (e) {
                showErrorNotif('URL tidak valid');
                return;
            }
            
            fetch('{{ route('monitoring.link.add') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    nama_file: namaFile,
                    link: link,
                    id_folder_mon: folderId || null
                })
            })
            .then(response => response.json())
            .then(data => {
                hideAddLinkModal();
                if (data.success) {
                    showSuccessNotif(data.message);
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showErrorNotif(data.message);
                }
            })
            .catch(error => {
                hideAddLinkModal();
                showErrorNotif('Terjadi kesalahan');
            });
        }

        // Add Link Modal Event Listeners
        document.addEventListener('DOMContentLoaded', function() {
            const addLinkInput = document.getElementById('addLinkInput');
            const addLinkNameInput = document.getElementById('addLinkNameInput');
            const addLinkModal = document.getElementById('addLinkModal');
            const confirmAddLinkBtn = document.getElementById('confirmAddLinkBtn');
            const cancelAddLinkBtn = document.getElementById('cancelAddLinkBtn');

            confirmAddLinkBtn?.addEventListener('click', confirmAddLink);
            cancelAddLinkBtn?.addEventListener('click', hideAddLinkModal);

            addLinkInput?.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    confirmAddLink();
                }
            });

            addLinkInput?.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    hideAddLinkModal();
                }
            });

            addLinkModal?.addEventListener('click', (e) => {
                if (e.target === addLinkModal) {
                    hideAddLinkModal();
                }
            });
        });
    </script>

    <!-- Add Link Modal -->
    <div id="addLinkModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full transform transition-all">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-5 rounded-t-2xl flex items-center gap-3">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.658 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                </svg>
                <h3 class="text-lg font-bold">Tambah Link</h3>
            </div>

            <!-- Modal Body -->
            <div class="px-6 py-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Link</label>
                    <input type="text" id="addLinkNameInput" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Contoh: Laporan Monitoring">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">URL/Link</label>
                    <input type="url" id="addLinkInput" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="https://drive.google.com/... atau https://...">
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex gap-3 px-6 py-4 border-t border-gray-200 rounded-b-2xl">
                <button id="cancelAddLinkBtn" class="flex-1 px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition">Batal</button>
                <button id="confirmAddLinkBtn" class="flex-1 px-4 py-2 text-white bg-green-600 hover:bg-green-700 rounded-lg font-medium transition">Simpan</button>
            </div>
        </div>
    </div>
@endsection