// ============================================
// DASHBOARD — Listings, Edit, Delete
// ============================================

function initDashboard() {
    if (!document.getElementById('listingsGrid')) return;
    renderListings();
}

function showSection(sectionName) {
    document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
    document.querySelectorAll('.menu-item').forEach(m => m.classList.remove('active'));
    
    if (sectionName === 'listings') {
        document.getElementById('listingsSection').classList.add('active');
        document.querySelector('.menu-item:nth-child(1)').classList.add('active');
        renderListings();
    } else if (sectionName === 'upload') {
        document.getElementById('uploadSection').classList.add('active');
        document.querySelector('.menu-item:nth-child(2)').classList.add('active');
    }
}

function renderListings() {
    const grid = document.getElementById('listingsGrid');
    const emptyState = document.getElementById('emptyState');
    const totalEl = document.getElementById('totalListings');
    
    const items = getItems().filter(item => 
        item.sellerId === (getCurrentUser()?.id || 'demo')
    );
    
    totalEl.textContent = items.length;
    
    if (items.length === 0) {
        grid.innerHTML = '';
        emptyState.classList.remove('hidden');
        return;
    }
    
    emptyState.classList.add('hidden');
    
    grid.innerHTML = items.map(item => {
        const coverPhoto = item.photos[0];
        const photoCount = item.photos.length;
        const priceFormatted = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 0
        }).format(item.price);
        
        return `
            <div class="listing-card" data-id="${item.id}">
                <div class="listing-photos">
                    <img src="${coverPhoto.dataUrl}" alt="${item.name}" 
                         onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22320%22 height=%22220%22><rect fill=%22%23f0ebe3%22 width=%22320%22 height=%22220%22/><text fill=%22%239a9590%22 x=%2250%%22 y=%2250%%22 text-anchor=%22middle%22 dy=%22.3em%22>No Image</text></svg>'">
                    ${photoCount > 1 ? `<span class="photo-counter">📷 ${photoCount}</span>` : ''}
                </div>
                <div class="listing-info">
                    <div class="listing-header">
                        <h3 class="listing-name">${escapeHtml(item.name)}</h3>
                        <span class="listing-price">${priceFormatted}</span>
                    </div>
                    <span class="listing-category">${formatCategory(item.category)}</span>
                    <p class="listing-description">${escapeHtml(item.description)}</p>
                    <div class="listing-actions">
                        <button onclick="openEditModal('${item.id}')">✏️ Edit</button>
                        <button class="btn-delete" onclick="openDeleteModal('${item.id}')">🗑️ Delete</button>
                    </div>
                </div>
            </div>
        `;
    }).join('');
}

// ============================================
// EDIT
// ============================================

function openEditModal(itemId) {
    const items = getItems();
    const item = items.find(i => i.id === itemId);
    if (!item) return;
    
    document.getElementById('editId').value = item.id;
    document.getElementById('editName').value = item.name;
    document.getElementById('editPrice').value = item.price;
    document.getElementById('editCategory').value = item.category;
    document.getElementById('editDescription').value = item.description;
    
    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

document.getElementById('editForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const itemId = document.getElementById('editId').value;
    const items = getItems();
    const index = items.findIndex(i => i.id === itemId);
    
    if (index === -1) return;
    
    items[index] = {
        ...items[index],
        name: document.getElementById('editName').value,
        price: parseFloat(document.getElementById('editPrice').value),
        category: document.getElementById('editCategory').value,
        description: document.getElementById('editDescription').value,
        updatedAt: new Date().toISOString()
    };
    
    localStorage.setItem('alliluxe_items', JSON.stringify(items));
    closeEditModal();
    renderListings();
    showToast('Listing updated successfully', 'success');
});

// ============================================
// DELETE
// ============================================

let deleteTargetId = null;

function openDeleteModal(itemId) {
    const items = getItems();
    const item = items.find(i => i.id === itemId);
    if (!item) return;
    
    deleteTargetId = itemId;
    document.getElementById('deleteItemName').textContent = item.name;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    deleteTargetId = null;
}

document.getElementById('confirmDeleteBtn')?.addEventListener('click', function() {
    if (!deleteTargetId) return;
    
    const items = getItems().filter(i => i.id !== deleteTargetId);
    localStorage.setItem('alliluxe_items', JSON.stringify(items));
    
    closeDeleteModal();
    renderListings();
    showToast('Listing removed', 'success');
});

// ============================================
// UTILITIES
// ============================================

function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.className = 'toast ' + type;
    
    setTimeout(() => {
        toast.classList.add('hidden');
    }, 3000);
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function formatCategory(cat) {
    const map = {
        seating: 'Seating',
        tables: 'Tables',
        storage: 'Storage',
        lighting: 'Lighting',
        decor: 'Decor & Accessories',
        bedroom: 'Bedroom'
    };
    return map[cat] || cat;
}

// Re-export for upload.js
function getItems() {
    try {
        return JSON.parse(localStorage.getItem('alliluxe_items')) || [];
    } catch {
        return [];
    }
}

document.addEventListener('DOMContentLoaded', initDashboard);