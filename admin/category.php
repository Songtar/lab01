<?php
// admin/category.php
require_once '../settings/core.php';

// Check if user is logged in and is an admin
requireAdmin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Category Management</h1>
            <div>
                <button class="btn btn-success" onclick="showAddModal()">Add New Category</button>
                <a href="../index.php" class="btn btn-primary">Back to Home</a>
            </div>
        </div>

        <div id="alertContainer"></div>
        <div id="loading">Loading...</div>

        <!-- Categories Table -->
        <div id="categoriesSection">
            <h3>Your Categories</h3>
            <table class="table" id="categoriesTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category Name</th>
                        <th>Created Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="categoriesTableBody">
                    <!-- Categories will be loaded here -->
                </tbody>
            </table>
        </div>

        <!-- Add Category Modal -->
        <div id="addModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('addModal')">&times;</span>
                <h2>Add New Category</h2>
                <form id="addCategoryForm">
                    <div class="form-group">
                        <label for="categoryName">Category Name:</label>
                        <input type="text" id="categoryName" name="categoryName" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Add Category</button>
                        <button type="button" class="btn btn-primary" onclick="closeModal('addModal')">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Category Modal -->
        <div id="editModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('editModal')">&times;</span>
                <h2>Edit Category</h2>
                <form id="editCategoryForm">
                    <input type="hidden" id="editCategoryId" name="categoryId">
                    <div class="form-group">
                        <label for="editCategoryName">Category Name:</label>
                        <input type="text" id="editCategoryName" name="categoryName" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-warning">Update Category</button>
                        <button type="button" class="btn btn-primary" onclick="closeModal('editModal')">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div id="deleteModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('deleteModal')">&times;</span>
                <h2>Confirm Delete</h2>
                <p>Are you sure you want to delete this category?</p>
                <p><strong id="deleteCategoryName"></strong></p>
                <div class="form-group">
                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">Delete</button>
                    <button type="button" class="btn btn-primary" onclick="closeModal('deleteModal')">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/category.js"></script>
    <script>
        // Load categories when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadCategories();
        });
    </script>
</body>
</html>
