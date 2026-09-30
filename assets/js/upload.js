// ============================================
// UPLOAD — Multi-photo drag-drop + form
// ============================================

let uploadedPhotos = []; // Array of {id, file, dataUrl}

function initUpload() {
    const dropZone = document.getElementById('dropZone');
    const photoInput = document.getElementById('photoInput');
    const uploadForm = document.getElementById('uploadForm');
    
    if (!dropZone) return;
    
    // Click to browse
    dropZone.addEventListener('click', () => photoInput.click());
    
    // File selection
    photoInput.addEventListener('change', (e) => handleFiles(e.target.files));
    
    // Drag & drop
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('dragover');
    });
    
    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('dragover');
    });
    
    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('dragover');
        handleFiles(e.dataTransfer.files);
    });
    
    // Form submit
    uploadForm.addEventListener('submit', handleUploadSubmit);
}

function handleFiles(files) {
    Array.from(files).forEach(file => {
        if (!file.type.startsWith('image/')) return;
        if (file.size > 10 * 1024 * 1024) {
            showToast('File too large: ' + file.name, 'error');
            return;
        }
        
        const reader = new FileReader();
        reader.onload = (e) => {
            uploadedPhotos.push({
                id: 'photo_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9),
                file: file,
                dataUrl: e.target.result,
                name: file.name
            });
            renderPhotoPreviews();
        };
        reader.readAsDataURL(file);
    });
}

function renderPhotoPreviews() {
    const grid = document.getElementById('photoPreviewGrid');
    grid.innerHTML = '';
    
    uploadedPhotos.forEach((photo, index) => {
        const div = document.createElement('div');
        div.className = 'photo-preview' + (index === 0 ? ' cover' : '');
        div.innerHTML = `
            <img src="${photo.dataUrl}" alt="${photo.name}">
            ${index === 0 ? '<span class="cover-badge">Cover</span>' : ''}
            <button type="button" class="remove-photo" onclick="removePhoto('${photo.id}')">×</button>
        `;
        grid.appendChild(div);
    });
}

function removePhoto(id) {
    uploadedPhotos = uploadedPhotos.filter(p => p.id !== id);
    renderPhotoPreviews();
}

function handleUploadSubmit(e) {
    e.preventDefault();
    
    if (uploadedPhotos.length === 0) {
        showToast('Please add at least one photo', 'error');
        return;
    }
    
    const item = {
        id: 'item_' + Date.now(),
        name: document.getElementById('itemName').value,
        price: parseFloat(document.getElementById('itemPrice').value),
        category: document.getElementById('itemCategory').value,
        description: document.getElementById('itemDescription').value,
        photos: uploadedPhotos.map(p => ({
            id: p.id,
            dataUrl: p.dataUrl,
            name: p.name
        })),
        sellerId: getCurrentUser()?.id || 'demo',
        createdAt: new Date().toISOString(),
        updatedAt: new Date().toISOString()
    };
    
    // Save to localStorage (in production: POST to /api/items)
    const items = getItems();
    items.push(item);
    localStorage.setItem('alliluxe_items', JSON.stringify(items));
    
    // Reset form
    document.getElementById('uploadForm').reset();
    uploadedPhotos = [];
    renderPhotoPreviews();
    
    showToast('Listing published successfully!', 'success');
    
    // Switch to listings view
    setTimeout(() => {
        showSection('listings');
        renderListings();
    }, 600);
}

// Helper
function getItems() {
    try {
        return JSON.parse(localStorage.getItem('alliluxe_items')) || [];
    } catch {
        return [];
    }
}

document.addEventListener('DOMContentLoaded', initUpload);