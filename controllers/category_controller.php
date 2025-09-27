<?php
// controllers/category_controller.php
require_once __DIR__ . '/../classes/category_class.php';

function add_category_ctr($kwargs) {
    $category = new category_class();
    
    // Validate input
    if (!isset($kwargs['name']) || empty(trim($kwargs['name']))) {
        return [
            'success' => false,
            'message' => 'Category name is required'
        ];
    }
    
    if (!isset($kwargs['user_id']) || empty($kwargs['user_id'])) {
        return [
            'success' => false,
            'message' => 'User ID is required'
        ];
    }
    
    $name = trim($kwargs['name']);
    $user_id = $kwargs['user_id'];
    
    // Validate category name length
    if (strlen($name) < 2) {
        return [
            'success' => false,
            'message' => 'Category name must be at least 2 characters long'
        ];
    }
    
    if (strlen($name) > 100) {
        return [
            'success' => false,
            'message' => 'Category name must be less than 100 characters'
        ];
    }
    
    $result = $category->add_category($name, $user_id);
    
    if ($result) {
        return [
            'success' => true,
            'message' => 'Category added successfully',
            'category_id' => $result
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Failed to add category. Category name may already exist.'
        ];
    }
}

function get_categories_ctr($user_id) {
    $category = new category_class();
    
    if (empty($user_id)) {
        return [
            'success' => false,
            'message' => 'User ID is required'
        ];
    }
    
    $result = $category->get_categories($user_id);
    
    if ($result !== false) {
        return [
            'success' => true,
            'message' => 'Categories retrieved successfully',
            'data' => $result
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Failed to retrieve categories'
        ];
    }
}

function get_category_ctr($kwargs) {
    $category = new category_class();
    
    if (!isset($kwargs['category_id']) || !isset($kwargs['user_id'])) {
        return [
            'success' => false,
            'message' => 'Category ID and User ID are required'
        ];
    }
    
    $result = $category->get_category($kwargs['category_id'], $kwargs['user_id']);
    
    if ($result) {
        return [
            'success' => true,
            'message' => 'Category retrieved successfully',
            'data' => $result
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Category not found'
        ];
    }
}

function update_category_ctr($kwargs) {
    $category = new category_class();
    
    // Validate input
    if (!isset($kwargs['category_id']) || !isset($kwargs['name']) || !isset($kwargs['user_id'])) {
        return [
            'success' => false,
            'message' => 'Category ID, name, and User ID are required'
        ];
    }
    
    if (empty(trim($kwargs['name']))) {
        return [
            'success' => false,
            'message' => 'Category name is required'
        ];
    }
    
    $category_id = $kwargs['category_id'];
    $name = trim($kwargs['name']);
    $user_id = $kwargs['user_id'];
    
    // Validate category name length
    if (strlen($name) < 2) {
        return [
            'success' => false,
            'message' => 'Category name must be at least 2 characters long'
        ];
    }
    
    if (strlen($name) > 100) {
        return [
            'success' => false,
            'message' => 'Category name must be less than 100 characters'
        ];
    }
    
    // Check if category exists and belongs to user
    if (!$category->category_exists($category_id, $user_id)) {
        return [
            'success' => false,
            'message' => 'Category not found'
        ];
    }
    
    $result = $category->edit_category($category_id, $name, $user_id);
    
    if ($result) {
        return [
            'success' => true,
            'message' => 'Category updated successfully'
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Failed to update category. Category name may already exist.'
        ];
    }
}

function delete_category_ctr($kwargs) {
    $category = new category_class();
    
    if (!isset($kwargs['category_id']) || !isset($kwargs['user_id'])) {
        return [
            'success' => false,
            'message' => 'Category ID and User ID are required'
        ];
    }
    
    $category_id = $kwargs['category_id'];
    $user_id = $kwargs['user_id'];
    
    // Check if category exists and belongs to user
    if (!$category->category_exists($category_id, $user_id)) {
        return [
            'success' => false,
            'message' => 'Category not found'
        ];
    }
    
    $result = $category->delete_category($category_id, $user_id);
    
    if ($result) {
        return [
            'success' => true,
            'message' => 'Category deleted successfully'
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Failed to delete category'
        ];
    }
}

function get_category_count_ctr($user_id) {
    $category = new category_class();
    
    if (empty($user_id)) {
        return [
            'success' => false,
            'message' => 'User ID is required'
        ];
    }
    
    $count = $category->get_category_count($user_id);
    
    return [
        'success' => true,
        'message' => 'Category count retrieved successfully',
        'count' => $count
    ];
}
?>
