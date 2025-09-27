<?php
// actions/delete_category_action.php
session_start();
require_once __DIR__ . '/../controllers/category_controller.php';

// Set content type to JSON
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'User not logged in'
    ]);
    exit();
}

// Check if user is admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 1) {
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'message' => 'Access denied. Admin privileges required.'
    ]);
    exit();
}

// Check if request method is POST or DELETE
if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed. Use POST or DELETE.'
    ]);
    exit();
}

try {
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    
    // If JSON input is not available, try POST data
    if (!$input) {
        $input = $_POST;
    }
    
    // Also check GET parameters for category ID
    if (!isset($input['categoryId']) && isset($_GET['categoryId'])) {
        $input['categoryId'] = $_GET['categoryId'];
    }
    
    // Validate input
    if (!isset($input['categoryId']) || empty($input['categoryId'])) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Category ID is required'
        ]);
        exit();
    }
    
    // Prepare data for controller
    $kwargs = [
        'category_id' => $input['categoryId'],
        'user_id' => $_SESSION['user_id']
    ];
    
    $result = delete_category_ctr($kwargs);
    
    if ($result['success']) {
        http_response_code(200);
    } else {
        http_response_code(400);
    }
    
    echo json_encode($result);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Internal server error: ' . $e->getMessage()
    ]);
}
?>
