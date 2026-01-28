@extends('layouts.app')

@section('title', 'Upload File - Perencanaan')

@section('header-title')
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Upload File</h1>
        <p class="text-sm text-gray-600">Tambahkan dokumen baru ke perencanaan</p>
    </div>
@endsection

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">

        <!-- Breadcrumb Navigation -->
        <nav class="flex items-center gap-2 text-sm bg-white rounded-lg shadow-sm p-4">
            <a href="{{ route('perencanaan') }}" class="text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                </svg>
                Beranda
            </a>
            @if(count($breadcrumbs) > 0)
                @foreach($breadcrumbs as $breadcrumb)
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <a href="{{ route('perencanaan', ['folder' => $breadcrumb->id_folder_per]) }}" class="text-blue-600 hover:text-blue-700 font-medium">
                        {{ $breadcrumb->nama_folder_per }}
                    </a>
                @endforeach
            @endif
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-600 font-medium">Upload File</span>
        </nav>

        <!-- Upload Form -->
        <div class="bg-white rounded-lg shadow-sm p-8">
            <form action="{{ route('perencanaan.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                @csrf

                <!-- Hidden Input untuk Folder -->
                <input type="hidden" name="id_folder_per" value="{{ request('folder') }}">

                <!-- Nama File -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama File <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="nama_file"
                           id="nama_file"
                           required
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('nama_file') border-red-500 @enderror"
                           placeholder="Contoh: Laporan Anggaran Q1 2024"
                           value="{{ old('nama_file') }}"
                           maxlength="255">
                    @error('nama_file')
                        <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Upload File -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Pilih File <span class="text-red-500">*</span>
                    </label>

                    <!-- File Input Custom -->
                    <div class="relative">
                        <input type="file"
                               name="file"
                               id="file"
                               required
                               accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png"
                               class="hidden"
                               onchange="updateFileName(this)">

                        <label for="file" class="flex items-center justify-center w-full px-4 py-8 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition @error('file') border-red-500 @enderror">
                            <div class="text-center">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <p class="text-sm text-gray-600 mb-1">
                                    <span class="text-blue-600 font-semibold">Klik untuk upload</span> atau drag & drop
                                </p>
                                <p class="text-xs text-gray-500" id="fileInfo">
                                    PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, JPG, PNG (Max: 10MB)
                                </p>
                            </div>
                        </label>
                    </div>

                    <!-- Selected File Preview -->
                    <div id="filePreview" class="hidden mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900" id="selectedFileName"></p>
                                    <p class="text-xs text-gray-500" id="selectedFileSize"></p>
                                </div>
                            </div>
                            <button type="button" onclick="clearFile()" class="text-red-600 hover:text-red-700">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    @error('file')
                        <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Info Box -->
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div class="text-sm text-blue-800">
                            <p class="font-semibold mb-1">Informasi Upload:</p>
                            <ul class="space-y-1 text-blue-700">
                                <li>• File akan tersimpan dengan aman di server</li>
                                <li>• Ukuran maksimal file adalah 10MB</li>
                                <li>• Format yang didukung: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, JPG, PNG</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex items-center gap-3">
                    <button type="submit"
                            id="submitBtn"
                            class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-md hover:shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Upload File
                    </button>
                    <a href="{{ route('perencanaan', ['folder' => request('folder')]) }}"
                       class="px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Update file name display
        function updateFileName(input) {
            const filePreview = document.getElementById('filePreview');
            const fileName = document.getElementById('selectedFileName');
            const fileSize = document.getElementById('selectedFileSize');
            const fileInfo = document.getElementById('fileInfo');

            if (input.files && input.files[0]) {
                const file = input.files[0];

                // Show preview
                filePreview.classList.remove('hidden');

                // Display file name
                fileName.textContent = file.name;

                // Display file size
                const sizeInMB = (file.size / (1024 * 1024)).toFixed(2);
                fileSize.textContent = `${sizeInMB} MB`;

                // Update info text
                fileInfo.textContent = `File terpilih: ${file.name}`;

                // Auto-fill nama_file jika kosong
                const namaFileInput = document.getElementById('nama_file');
                if (!namaFileInput.value) {
                    // Remove extension from filename
                    const nameWithoutExt = file.name.replace(/\.[^/.]+$/, '');
                    namaFileInput.value = nameWithoutExt;
                }
            }
        }

        // Clear file selection
        function clearFile() {
            const fileInput = document.getElementById('file');
            const filePreview = document.getElementById('filePreview');
            const fileInfo = document.getElementById('fileInfo');

            fileInput.value = '';
            filePreview.classList.add('hidden');
            fileInfo.textContent = 'PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, JPG, PNG (Max: 10MB)';
        }

        // Form validation & loading state
        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const fileInput = document.getElementById('file');

            // Check if file is selected
            if (!fileInput.files || !fileInput.files[0]) {
                e.preventDefault();
                alert('Silakan pilih file terlebih dahulu!');
                return;
            }

            // Check file size (10MB = 10485760 bytes)
            if (fileInput.files[0].size > 10485760) {
                e.preventDefault();
                alert('Ukuran file terlalu besar! Maksimal 10MB.');
                return;
            }

            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Mengupload...
            `;
        });

        // Drag & Drop
        const dropZone = document.querySelector('label[for="file"]');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.add('border-blue-500', 'bg-blue-50');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.remove('border-blue-500', 'bg-blue-50');
            }, false);
        });

        dropZone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            document.getElementById('file').files = files;
            updateFileName(document.getElementById('file'));
        }, false);
    </script>
@endsection
