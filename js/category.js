// js/category.js

// Global variables
let currentDeleteId = null;

/**
 * Load all categories from the server
 */
function loadCategories() {
    showLoading(true);
    
    fetch('../actions/fetch_category_action.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        showLoading(false);
        if (data.success) {
            displayCategories(data.data);
        } else {
            showAlert('Error loading categories: ' + data.message, 'danger');
        }
    })
    .catch(error => {
        showLoading(false);
        console.error('Error:', error);
        showAlert('Error loading categories. Please try again.', 'danger');
    });
}

/**
 * Display categories in the table
 */
function displayCategories(categories) {
    const tbody = document.getElementById('categoriesTableBody');
    tbody.innerHTML = '';
    
    if (categories.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" style="text-align: center;">No categories found. Add your first category!</td></tr>';
        return;
    }
    
    categories.forEach(category => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${category.category_id}</td>
            <td>${escapeHtml(category.category_name)}</td>
            <td>${formatDate(category.created_at)}</td>
            <td>
                <button class="btn btn-warning" onclick="showEditModal(${category.category_id}, '${escapeHtml(category.category_name)}')">Edit</button>
                <button class="btn btn-danger" onclick="showDeleteModal(${category.category_id}, '${escapeHtml(category.category_name)}')">Delete</button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

/**
 * Show the add category modal
 */
function showAddModal() {
    document.getElementById('categoryName').value = '';
    document.getElementById('addModal').style.display = 'block';
    document.getElementById('categoryName').focus();
}

/**
 * Show the edit category modal
 */
function showEditModal(categoryId, categoryName) {
    document.getElementById('editCategoryId').value = categoryId;
    document.getElementById('editCategoryName').value = categoryName;
    document.getElementById('editModal').style.display = 'block';
    document.getElementById('editCategoryName').focus();
}

/**
 * Show the delete confirmation modal
 */
function showDeleteModal(categoryId, categoryName) {
    currentDeleteId = categoryId;
    document.getElementById('deleteCategoryName').textContent = categoryName;
    document.getElementById('deleteModal').style.display = 'block';
}

/**
 * Close a modal
 */
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
    currentDeleteId = null;
}

/**
 * Handle add category form submission
 */
document.addEventListener('DOMContentLoaded', function() {
    const addForm = document.getElementById('addCategoryForm');
    if (addForm) {
        addForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const categoryName = document.getElementById('categoryName').value.trim();
            
            // Validate category name
            if (!validateCategoryName(categoryName)) {
                return;
            }
            
            // Submit the form
            addCategory(categoryName);
        });
    }
    
    const editForm = document.getElementById('editCategoryForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const categoryId = document.getElementById('editCategoryId').value;
            const categoryName = document.getElementById('editCategoryName').value.trim();
            
            // Validate category name
            if (!validateCategoryName(categoryName)) {
                return;
            }
            
            // Submit the form
            updateCategory(categoryId, categoryName);
        });
    }
});

/**
 * Validate category name
 */
function validateCategoryName(name) {
    if (!name) {
        showAlert('Category name is required', 'danger');
        return false;
    }
    
    if (name.length < 2) {
        showAlert('Category name must be at least 2 characters long', 'danger');
        return false;
    }
    
    if (name.length > 100) {
        showAlert('Category name must be less than 100 characters', 'danger');
        return false;
    }
    
    // Check for valid characters (letters, numbers, spaces, hyphens, underscores)
    const validPattern = /^[a-zA-Z0-9\s\-_]+$/;
    if (!validPattern.test(name)) {
        showAlert('Category name can only contain letters, numbers, spaces, hyphens, and underscores', 'danger');
        return false;
    }
    
    return true;
}

/**
 * Add a new category
 */
function addCategory(categoryName) {
    showLoading(true);
    
    fetch('../actions/add_category_action.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            categoryName: categoryName
        })
    })
    .then(response => response.json())
    .then(data => {
        showLoading(false);
        if (data.success) {
            showAlert(data.message, 'success');
            closeModal('addModal');
            loadCategories(); // Reload the categories
        } else {
            showAlert('Error: ' + data.message, 'danger');
        }
    })
    .catch(error => {
        showLoading(false);
        console.error('Error:', error);
        showAlert('Error adding category. Please try again.', 'danger');
    });
}

/**
 * Update a category
 */
function updateCategory(categoryId, categoryName) {
    showLoading(true);
    
    fetch('../actions/update_category_action.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            categoryId: categoryId,
            categoryName: categoryName
        })
    })
    .then(response => response.json())
    .then(data => {
        showLoading(false);
        if (data.success) {
            showAlert(data.message, 'success');
            closeModal('editModal');
            loadCategories(); // Reload the categories
        } else {
            showAlert('Error: ' + data.message, 'danger');
        }
    })
    .catch(error => {
        showLoading(false);
        console.error('Error:', error);
        showAlert('Error updating category. Please try again.', 'danger');
    });
}

/**
 * Confirm and delete a category
 */
function confirmDelete() {
    if (!currentDeleteId) {
        showAlert('No category selected for deletion', 'danger');
        return;
    }
    
    showLoading(true);
    
    fetch('../actions/delete_category_action.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            categoryId: currentDeleteId
        })
    })
    .then(response => response.json())
    .then(data => {
        showLoading(false);
        if (data.success) {
            showAlert(data.message, 'success');
            closeModal('deleteModal');
            loadCategories(); // Reload the categories
        } else {
            showAlert('Error: ' + data.message, 'danger');
        }
    })
    .catch(error => {
        showLoading(false);
        console.error('Error:', error);
        showAlert('Error deleting category. Please try again.', 'danger');
    });
}

/**
 * Show alert message
 */
function showAlert(message, type) {
    const alertContainer = document.getElementById('alertContainer');
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.textContent = message;
    
    // Clear existing alerts
    alertContainer.innerHTML = '';
    alertContainer.appendChild(alertDiv);
    
    // Auto-hide success messages after 3 seconds
    if (type === 'success') {
        setTimeout(() => {
            alertDiv.remove();
        }, 3000);
    }
    
    // Scroll to top to show the alert
    window.scrollTo(0, 0);
}

/**
 * Show/hide loading indicator
 */
function showLoading(show) {
    const loading = document.getElementById('loading');
    loading.style.display = show ? 'block' : 'none';
}

/**
 * Escape HTML to prevent XSS
 */
function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

/**
 * Format date for display
 */
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
}

// Close modals when clicking outside of them
window.onclick = function(event) {
    const modals = ['addModal', 'editModal', 'deleteModal'];
    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (event.target === modal) {
            closeModal(modalId);
        }
    });
}

// Handle escape key to close modals
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modals = ['addModal', 'editModal', 'deleteModal'];
        modals.forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (modal.style.display === 'block') {
                closeModal(modalId);
            }
        });
    }
});
