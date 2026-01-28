import './bootstrap';

// ============================================
// MODAL FUNCTIONS FOR SIDEBAR NEW MENU
// ============================================

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
                name: folderName,
                parent_id: currentFolder
            })
        });

        const data = await response.json();
        if (data.success) {
            alert(data.message || 'Folder berhasil dibuat');
            closeModal('createFolderModal');
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
        formData.append('parent_id', currentFolder);
    }

    try {
        let url = window.ContextMenuConfig?.fileUploadUrl || '/perencanaan/file/upload';

        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        });

        const data = await response.json();
        if (data.success) {
            alert(data.message || 'File berhasil diupload');
            closeModal('uploadFileModal');
            location.reload();
        } else {
            alert(data.message || 'Terjadi kesalahan');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan: ' + error.message);
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

    // Add all files from folder
    for (let file of folderInput.files) {
        formData.append('files[]', file);
    }

    if (currentFolder) {
        formData.append('parent_id', currentFolder);
    }

    try {
        let url = window.ContextMenuConfig?.folderUploadUrl || '/perencanaan/folder/upload';

        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        });

        const data = await response.json();
        if (data.success) {
            alert(data.message || 'Folder berhasil diupload');
            closeModal('uploadFolderModal');
            location.reload();
        } else {
            alert(data.message || 'Terjadi kesalahan');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan: ' + error.message);
    }
}

// Make functions globally available
window.openCreateFolderModal = openCreateFolderModal;
window.openUploadFileModal = openUploadFileModal;
window.openUploadFolderModal = openUploadFolderModal;
window.closeModal = closeModal;
window.submitCreateFolder = submitCreateFolder;
window.submitUploadFile = submitUploadFile;
window.submitUploadFolder = submitUploadFolder;

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
