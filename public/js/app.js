// ============================================
// MODAL FUNCTIONS FOR SIDEBAR NEW MENU
// ============================================

// File selection handler
function onFileSelected() {
    const fileInput = document.getElementById('fileInput');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');

    if (fileInput.files.length > 0) {
        const file = fileInput.files[0];
        const sizeMB = (file.size / 1024 / 1024).toFixed(2);
        fileName.textContent = '✓ ' + file.name;
        fileSize.textContent = '(' + sizeMB + ' MB)';
        fileName.parentElement.parentElement.classList.add('border-green-300', 'bg-green-50');
        fileName.parentElement.parentElement.classList.remove('border-gray-300');
    }
}

// Folder selection handler
function onFolderSelected() {
    const folderInput = document.getElementById('folderInput');
    const folderName = document.getElementById('folderName');
    const folderFileCount = document.getElementById('folderFileCount');

    if (folderInput.files.length > 0) {
        const totalSize = Array.from(folderInput.files).reduce((sum, file) => sum + file.size, 0);
        const sizeMB = (totalSize / 1024 / 1024).toFixed(2);
        folderName.textContent = '✓ ' + folderInput.files[0].webkitRelativePath.split('/')[0];
        folderFileCount.textContent = folderInput.files.length + ' file (' + sizeMB + ' MB)';
        folderName.parentElement.parentElement.classList.add('border-green-300', 'bg-green-50');
        folderName.parentElement.parentElement.classList.remove('border-gray-300');
    }
}

// Open Create Folder Modal
function openCreateFolderModal() {
    const modal = document.getElementById('createFolderModal');
    if (modal) {
        modal.classList.remove('hidden');
        // Close dropdown when modal opens
        const dropdown = document.getElementById('newMenu');
        if (dropdown) dropdown.classList.add('hidden');
    }
}

// Open Upload File Modal
function openUploadFileModal() {
    const modal = document.getElementById('uploadFileModal');
    if (modal) {
        modal.classList.remove('hidden');
        // Reset form
        document.getElementById('fileInput').value = '';
        document.getElementById('fileName').textContent = 'Tidak ada file dipilih';
        document.getElementById('fileSize').textContent = '';
        document.getElementById('uploadProgress').classList.add('hidden');
        // Reset styling
        const dropholder = document.getElementById('fileName').parentElement.parentElement;
        dropholder.classList.remove('border-green-300', 'bg-green-50');
        dropholder.classList.add('border-gray-300');
        // Close dropdown when modal opens
        const dropdown = document.getElementById('newMenu');
        if (dropdown) dropdown.classList.add('hidden');
    }
}

// Open Upload Folder Modal
function openUploadFolderModal() {
    const modal = document.getElementById('uploadFolderModal');
    if (modal) {
        modal.classList.remove('hidden');
        // Reset form
        document.getElementById('folderInput').value = '';
        document.getElementById('folderName').textContent = 'Tidak ada folder dipilih';
        document.getElementById('folderFileCount').textContent = '';
        document.getElementById('folderUploadProgress').classList.add('hidden');
        // Reset styling
        const dropholder = document.getElementById('folderName').parentElement.parentElement;
        dropholder.classList.remove('border-green-300', 'bg-green-50');
        dropholder.classList.add('border-gray-300');
        // Close dropdown when modal opens
        const dropdown = document.getElementById('newMenu');
        if (dropdown) dropdown.classList.add('hidden');
    }
}

// Close Modal Function (generic)
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
    }
}

// Submit Create Folder Form
async function submitCreateFolder(event) {
    event.preventDefault();

    const folderName = document.getElementById('folderName').value.trim();
    if (!folderName) {
        alert('Nama folder tidak boleh kosong');
        return;
    }

    const currentFolder = window.ContextMenuConfig?.currentFolder || null;

    try {
        let url = window.ContextMenuConfig?.createUrl || '/perencanaan/folder/create';

        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                nama_folder: folderName,
                id_parent: currentFolder
            })
        });

        // Check if response is ok
        if (!response.ok) {
            const errorText = await response.text();
            console.error('Server Error:', errorText);
            alert('Terjadi kesalahan: ' + response.status + ' ' + response.statusText);
            return;
        }

        const data = await response.json();
        if (data.success) {
            alert(data.message || 'Folder berhasil dibuat');
            closeModal('createFolderModal');
            document.getElementById('folderName').value = ''; // Clear input
            location.reload();
        } else {
            alert(data.message || 'Terjadi kesalahan');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan: ' + error.message);
    }
}

// Submit Upload File Form
async function submitUploadFile(event) {
    event.preventDefault();

    const fileInput = document.getElementById('fileInput');
    if (!fileInput.files.length) {
        alert('Pilih file terlebih dahulu');
        return;
    }

    const currentFolder = window.ContextMenuConfig?.currentFolder || null;
    const formData = new FormData();
    formData.append('file', fileInput.files[0]);
    if (currentFolder) {
        formData.append('id_folder', currentFolder);
    }

    // Show progress
    const progressDiv = document.getElementById('uploadProgress');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    const uploadBtn = document.getElementById('uploadFileBtn');
    const cancelBtn = document.getElementById('uploadFileCancel');

    progressDiv.classList.remove('hidden');
    uploadBtn.disabled = true;
    cancelBtn.disabled = true;

    try {
        let url = window.ContextMenuConfig?.fileUploadUrl || '/perencanaan/file/upload';

        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        });

        // Simulate progress
        progressBar.style.width = '90%';
        progressText.textContent = 'Memproses...';

        // Check if response is ok
        if (!response.ok) {
            const errorText = await response.text();
            console.error('Server Error:', errorText);
            progressDiv.classList.add('hidden');
            uploadBtn.disabled = false;
            cancelBtn.disabled = false;
            alert('❌ Terjadi kesalahan: ' + response.status + ' ' + response.statusText);
            return;
        }

        const data = await response.json();
        if (data.success) {
            progressBar.style.width = '100%';
            progressText.textContent = '✓ Berhasil!';
            setTimeout(() => {
                alert('✓ ' + (data.message || 'File berhasil diupload'));
                closeModal('uploadFileModal');
                location.reload();
            }, 500);
        } else {
            progressDiv.classList.add('hidden');
            uploadBtn.disabled = false;
            cancelBtn.disabled = false;
            alert('❌ ' + (data.message || 'Terjadi kesalahan'));
        }
    } catch (error) {
        console.error('Error:', error);
        progressDiv.classList.add('hidden');
        uploadBtn.disabled = false;
        cancelBtn.disabled = false;
        alert('❌ Terjadi kesalahan: ' + error.message);
    }
}

// Submit Upload Folder Form
async function submitUploadFolder(event) {
    event.preventDefault();

    const folderInput = document.getElementById('folderInput');
    if (!folderInput.files.length) {
        alert('Pilih folder terlebih dahulu');
        return;
    }

    const currentFolder = window.ContextMenuConfig?.currentFolder || null;
    const formData = new FormData();

    // Add all files from folder with their paths
    for (let i = 0; i < folderInput.files.length; i++) {
        const file = folderInput.files[i];
        formData.append('files[]', file);
        // Get the file's webkitRelativePath (folder structure path)
        const path = file.webkitRelativePath || file.name;
        formData.append('paths[]', path);
        console.log('Uploading:', path);
    }

    if (currentFolder) {
        formData.append('id_parent', currentFolder);
    }

    // Show progress
    const progressDiv = document.getElementById('folderUploadProgress');
    const progressBar = document.getElementById('folderProgressBar');
    const progressText = document.getElementById('folderProgressText');
    const uploadBtn = document.getElementById('uploadFolderBtn');
    const cancelBtn = document.getElementById('uploadFolderCancel');

    progressDiv.classList.remove('hidden');
    uploadBtn.disabled = true;
    cancelBtn.disabled = true;

    try {
        let url = window.ContextMenuConfig?.folderUploadUrl || '/perencanaan/folder/upload';

        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        });

        // Simulate progress
        progressBar.style.width = '90%';
        progressText.textContent = 'Memproses...';

        // Check if response is ok
        if (!response.ok) {
            const errorText = await response.text();
            console.error('Server Error:', errorText);
            progressDiv.classList.add('hidden');
            uploadBtn.disabled = false;
            cancelBtn.disabled = false;
            alert('❌ Terjadi kesalahan: ' + response.status + ' ' + response.statusText);
            return;
        }

        const data = await response.json();
        if (data.success) {
            progressBar.style.width = '100%';
            progressText.textContent = '✓ Berhasil!';
            setTimeout(() => {
                alert('✓ ' + (data.message || 'Folder berhasil diupload'));
                closeModal('uploadFolderModal');
                location.reload();
            }, 500);
        } else {
            progressDiv.classList.add('hidden');
            uploadBtn.disabled = false;
            cancelBtn.disabled = false;
            alert('❌ ' + (data.message || 'Terjadi kesalahan'));
        }
    } catch (error) {
        console.error('Error:', error);
        progressDiv.classList.add('hidden');
        uploadBtn.disabled = false;
        cancelBtn.disabled = false;
        alert('❌ Terjadi kesalahan: ' + error.message);
    }
}

// Close modal when clicking outside of it
document.addEventListener('DOMContentLoaded', function() {
    // List of modal IDs
    const modalIds = ['createFolderModal', 'uploadFileModal', 'uploadFolderModal'];

    modalIds.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.addEventListener('click', function(e) {
                // Close modal if clicking on the modal background (not the content)
                if (e.target === this) {
                    closeModal(modalId);
                }
            });
        }
    });
});
