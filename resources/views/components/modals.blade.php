{{-- Create Folder Modal --}}
<div id="createFolderModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="flex items-center justify-between p-6 border-b">
            <h2 class="text-lg font-semibold text-gray-900">Buat Folder Baru</h2>
            <button onclick="closeModal('createFolderModal')" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form onsubmit="submitCreateFolder(event)" class="p-6">
            <div class="mb-4">
                <label for="folderName" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Folder
                </label>
                <input
                    type="text"
                    id="folderName"
                    name="folderName"
                    required
                    placeholder="Masukkan nama folder..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>

            <div class="flex gap-3">
                <button
                    type="button"
                    onclick="closeModal('createFolderModal')"
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Batal
                </button>
                <button
                    type="submit"
                    class="flex-1 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                    Buat Folder
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Upload File Modal --}}
<div id="uploadFileModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="flex items-center justify-between p-6 border-b">
            <h2 class="text-lg font-semibold text-gray-900">Upload File</h2>
            <button onclick="closeModal('uploadFileModal')" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form onsubmit="submitUploadFile(event)" class="p-6">
            <div class="mb-4">
                <label for="fileInput" class="block text-sm font-medium text-gray-700 mb-2">
                    Pilih File
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-purple-500 transition">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <input
                        type="file"
                        id="fileInput"
                        name="fileInput"
                        class="hidden"
                        onchange="onFileSelected()">
                    <label for="fileInput" class="cursor-pointer">
                        <span class="text-sm text-purple-600 font-medium">Klik untuk memilih file</span>
                    </label>
                    <p id="fileName" class="text-xs text-gray-500 mt-2">Tidak ada file dipilih</p>
                    <p id="fileSize" class="text-xs text-gray-400 mt-1"></p>
                </div>
            </div>

            <!-- Progress Bar -->
            <div id="uploadProgress" class="hidden mb-4">
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div id="progressBar" class="bg-purple-600 h-2 rounded-full" style="width: 0%"></div>
                </div>
                <p id="progressText" class="text-xs text-gray-600 mt-1">Mengunggah...</p>
            </div>

            <div class="flex gap-3">
                <button
                    type="button"
                    onclick="closeModal('uploadFileModal')"
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"
                    id="uploadFileCancel">
                    Batal
                </button>
                <button
                    type="submit"
                    class="flex-1 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700"
                    id="uploadFileBtn">
                    Upload
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Upload Folder Modal --}}
<div id="uploadFolderModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="flex items-center justify-between p-6 border-b">
            <h2 class="text-lg font-semibold text-gray-900">Upload Folder</h2>
            <button onclick="closeModal('uploadFolderModal')" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form onsubmit="submitUploadFolder(event)" class="p-6">
            <div class="mb-4">
                <label for="folderInput" class="block text-sm font-medium text-gray-700 mb-2">
                    Pilih Folder
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-purple-500 transition">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                    <input
                        type="file"
                        id="folderInput"
                        name="folderInput"
                        webkitdirectory
                        directory
                        mozdirectory
                        class="hidden"
                        onchange="onFolderSelected()">
                    <label for="folderInput" class="cursor-pointer">
                        <span class="text-sm text-purple-600 font-medium">Klik untuk memilih folder</span>
                    </label>
                    <p id="folderName" class="text-xs text-gray-500 mt-2">Tidak ada folder dipilih</p>
                    <p id="folderFileCount" class="text-xs text-gray-400 mt-1"></p>
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    📝 Catatan: Hanya browser modern (Chrome, Firefox, Edge) yang mendukung upload folder
                </p>
            </div>

            <!-- Progress Bar -->
            <div id="folderUploadProgress" class="hidden mb-4">
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div id="folderProgressBar" class="bg-purple-600 h-2 rounded-full" style="width: 0%"></div>
                </div>
                <p id="folderProgressText" class="text-xs text-gray-600 mt-1">Mengunggah...</p>
            </div>

            <div class="flex gap-3">
                <button
                    type="button"
                    onclick="closeModal('uploadFolderModal')"
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"
                    id="uploadFolderCancel">
                    Batal
                </button>
                <button
                    type="submit"
                    class="flex-1 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700"
                    id="uploadFolderBtn">
