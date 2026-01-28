@php
    // This component renders a universal context menu and its JS.
    // Runtime configuration is read from `window.ContextMenuConfig`.
    // Example to set per-page (put in a @section('scripts') in the page):
    // <script>window.ContextMenuConfig = { createUrl: '...', fileUploadUrl: '...', folderUploadUrl: '...', currentFolder: '123' };</script>
@endphp

<!-- Universal Context Menu -->
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
    
    <button id="ctxFileUploadBtn" class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-green-50 flex items-center gap-3 transition group">
        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition">
            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
            </svg>
        </div>
        <span class="font-medium">File Upload</span>
    </button>
    
    <button id="ctxFolderUploadBtn" class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-purple-50 flex items-center gap-3 transition group">
        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition">
            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
            </svg>
        </div>
        <span class="font-medium">Folder Upload</span>
    </button>
</div>

<!-- Hidden File Inputs (used by the context menu) -->
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
    // Helper to read config (set by each page, default safe values)
    function getCtxConfig() {
        return window.ContextMenuConfig || {};
    }

    // Toggle Dropdown helpers from original file (kept minimal)
    function toggleDropdown(id) {
        const dropdown = document.getElementById(id);
        const allDropdowns = document.querySelectorAll('[id^="folder-"], [id^="file-"]');

        allDropdowns.forEach(d => {
            if (d.id !== id) d.classList.add('hidden');
        });

        if (dropdown) dropdown.classList.toggle('hidden');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('button')) {
            document.querySelectorAll('[id^="folder-"], [id^="file-"]').forEach(d => {
                d.classList.add('hidden');
            });
        }
    });

    // Context menu show/hide logic (shows only when clicking in page body but not on links/buttons)
    document.addEventListener('contextmenu', function(e) {
        // allow per-page config to provide a selector where contextmenu should be enabled
        const cfg = getCtxConfig();
        const allowedSelector = cfg.allowedSelector || 'body';

        const isAllowed = e.target.closest(allowedSelector);
        if (isAllowed && !e.target.closest('a') && !e.target.closest('button')) {
            e.preventDefault();
            const menu = document.getElementById('contextMenu');
            const clickX = e.pageX;
            const clickY = e.pageY;
            // basic viewport collision avoid
            const menuRect = { width: 260, height: 200 };
            const docW = document.documentElement.clientWidth;
            const docH = document.documentElement.clientHeight;
            let left = clickX;
            let top = clickY;
            if (clickX + menuRect.width > docW) left = docW - menuRect.width - 10;
            if (clickY + menuRect.height > docH) top = docH - menuRect.height - 10;
            menu.style.left = left + 'px';
            menu.style.top = top + 'px';
            menu.classList.remove('hidden');
        }
    });

    document.addEventListener('click', function(e) {
        if (!e.target.closest('#contextMenu')) {
            const m = document.getElementById('contextMenu');
            if (m) m.classList.add('hidden');
        }
    });

    // Modal helpers
    function openCreateFolder() {
        document.getElementById('contextMenu').classList.add('hidden');
        document.getElementById('modalCreateFolder').classList.remove('hidden');
        setTimeout(() => {
            const input = document.getElementById('folderNameInput');
            if (input) { input.focus(); input.select(); }
        }, 100);
    }

    function closeModal(modalId) {
        const m = document.getElementById(modalId);
        if (m) m.classList.add('hidden');
    }

    // CSRF helper
    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.content : '';
    }

    // Form Create Folder submit
    document.addEventListener('submit', async function(e) {
        if (e.target && e.target.id === 'formCreateFolder') {
            e.preventDefault();
            const cfg = getCtxConfig();
            const createUrl = cfg.createUrl;
            const folderName = document.getElementById('folderNameInput').value;
            const currentFolder = cfg.currentFolder || '';

            if (!createUrl) {
                alert('Create folder endpoint belum dikonfigurasi untuk halaman ini.');
                return;
            }

            try {
                const res = await fetch(createUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ nama_folder: folderName, id_parent: currentFolder || null })
                });
                const data = await res.json();
                if (data.success) {
                    closeModal('modalCreateFolder');
                    location.reload();
                } else {
                    alert(data.message || 'Gagal membuat folder');
                }
            } catch (err) {
                console.error(err);
                alert('Terjadi kesalahan saat membuat folder');
            }
        }
    });

    // Generic delete folder/file functions used by inline buttons across pages
    // Do not override page-specific implementations if they exist.
    window.deleteFolder = window.deleteFolder || async function(id, name, url) {
        if (!confirm(`Hapus folder "${name}"? Ini akan menghapus semua isi di dalamnya.`)) return;
        const cfg = getCtxConfig();
        if (!url) {
            // try configured base path, else derive from current pathname
            let base = cfg.basePath || ('/' + window.location.pathname.split('/').filter(Boolean)[0]);
            if (!base.startsWith('/')) base = '/' + base;
            url = `${base}/folder/${id}`;
        }

        try {
            const res = await fetch(url, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': getCsrfToken() }
            });
            const data = await res.json();
            if (data.success) location.reload();
            else alert(data.message || 'Gagal menghapus folder');
        } catch (err) {
            console.error(err);
            alert('Terjadi kesalahan saat menghapus folder');
        }
    };

    window.deleteFile = window.deleteFile || async function(id, name, url) {
        if (!confirm(`Hapus file "${name}"?`)) return;
        const cfg = getCtxConfig();
        if (!url) {
            let base = cfg.basePath || ('/' + window.location.pathname.split('/').filter(Boolean)[0]);
            if (!base.startsWith('/')) base = '/' + base;
            url = `${base}/file/${id}`;
        }

        try {
            const res = await fetch(url, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': getCsrfToken() }
            });
            const data = await res.json();
            if (data.success) location.reload();
            else alert(data.message || 'Gagal menghapus file');
        } catch (err) {
            console.error(err);
            alert('Terjadi kesalahan saat menghapus file');
        }
    };

    // File upload handler
    async function handleFileUpload(event) {
        const cfg = getCtxConfig();
        const uploadUrl = cfg.fileUploadUrl;
        const currentFolder = cfg.currentFolder || '';
        const files = event.target.files;
        if (!uploadUrl) { alert('File upload belum dikonfigurasi untuk halaman ini.'); return; }
        if (!files || files.length === 0) return;

        document.getElementById('contextMenu').classList.add('hidden');
        document.getElementById('uploadProgress').classList.remove('hidden');
        document.getElementById('uploadStatus').textContent = `Uploading ${files.length} file(s)...`;

        for (let i = 0; i < files.length; i++) {
            const formData = new FormData();
            formData.append('file', files[i]);
            formData.append('id_folder', currentFolder || '');

            try {
                await fetch(uploadUrl, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': getCsrfToken() },
                    body: formData
                });

                const progress = ((i + 1) / files.length) * 100;
                document.getElementById('uploadProgressBar').style.width = progress + '%';
                document.getElementById('uploadStatus').textContent = `Uploading ${i + 1}/${files.length}...`;
            } catch (err) {
                console.error('Upload error:', err);
            }
        }

        setTimeout(() => { document.getElementById('uploadProgress').classList.add('hidden'); location.reload(); }, 500);
    }

    // Folder upload handler
    async function handleFolderUpload(event) {
        const cfg = getCtxConfig();
        const uploadUrl = cfg.folderUploadUrl;
        const currentFolder = cfg.currentFolder || '';
        const files = event.target.files;
        if (!uploadUrl) { alert('Folder upload belum dikonfigurasi untuk halaman ini.'); return; }
        if (!files || files.length === 0) return;

        document.getElementById('contextMenu').classList.add('hidden');
        document.getElementById('uploadProgress').classList.remove('hidden');
        document.getElementById('uploadStatus').textContent = `Uploading ${files.length} file(s)...`;

        for (let i = 0; i < files.length; i++) {
            const formData = new FormData();
            formData.append('file', files[i]);
            formData.append('id_folder', currentFolder || '');

            try {
                await fetch(uploadUrl, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': getCsrfToken() },
                    body: formData
                });

                const progress = ((i + 1) / files.length) * 100;
                document.getElementById('uploadProgressBar').style.width = progress + '%';
                document.getElementById('uploadStatus').textContent = `Uploading ${i + 1}/${files.length}...`;
            } catch (err) {
                console.error('Upload error:', err);
            }
        }

        setTimeout(() => { document.getElementById('uploadProgress').classList.add('hidden'); location.reload(); }, 500);
    }

    // Wire up context menu buttons to hidden inputs (once the DOM is ready)
    document.addEventListener('DOMContentLoaded', function() {
        const fileBtn = document.getElementById('ctxFileUploadBtn');
        const folderBtn = document.getElementById('ctxFolderUploadBtn');
        if (fileBtn) fileBtn.addEventListener('click', () => document.getElementById('fileInput').click());
        if (folderBtn) folderBtn.addEventListener('click', () => document.getElementById('folderInput').click());
    });
</script>
