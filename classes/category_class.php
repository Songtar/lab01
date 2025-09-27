<?php
// classes/category_class.php
require_once __DIR__ . '/../settings/db_class.php';

class category_class extends db_connection {
    
    public function add_category($name, $user_id) {
        try {
            // Check if category name already exists for this user
            $check_sql = "SELECT category_id FROM categories WHERE category_name = ? AND user_id = ?";
            $check_stmt = $this->db->prepare($check_sql);
            $check_stmt->execute([$name, $user_id]);
            
            if ($check_stmt->rowCount() > 0) {
                return false; // Category already exists
            }
            
            // Insert new category
            $sql = "INSERT INTO categories (category_name, user_id, created_at) VALUES (?, ?, NOW())";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([$name, $user_id]);
            
            if ($result) {
                return $this->db->lastInsertId();
            }
            return false;
        } catch (PDOException $e) {
            error_log("Error adding category: " . $e->getMessage());
            return false;
        }
    }
    
    public function get_categories($user_id) {
        try {
            $sql = "SELECT category_id, category_name, created_at FROM categories WHERE user_id = ? ORDER BY category_name ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$user_id]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching categories: " . $e->getMessage());
            return false;
        }
    }
    
    public function get_category($category_id, $user_id) {
        try {
            $sql = "SELECT category_id, category_name, created_at FROM categories WHERE category_id = ? AND user_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$category_id, $user_id]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching category: " . $e->getMessage());
            return false;
        }
    }
    
    public function edit_category($category_id, $name, $user_id) {
        try {
            // Check if new name already exists for this user (excluding current category)
            $check_sql = "SELECT category_id FROM categories WHERE category_name = ? AND user_id = ? AND category_id != ?";
            $check_stmt = $this->db->prepare($check_sql);
            $check_stmt->execute([$name, $user_id, $category_id]);
            
            if ($check_stmt->rowCount() > 0) {
                return false; // Category name already exists
            }
            
            // Update category
            $sql = "UPDATE categories SET category_name = ? WHERE category_id = ? AND user_id = ?";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([$name, $category_id, $user_id]);
            
            return $result && $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error updating category: " . $e->getMessage());
            return false;
        }
    }
    
    public function delete_category($category_id, $user_id) {
        try {
            $sql = "DELETE FROM categories WHERE category_id = ? AND user_id = ?";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([$category_id, $user_id]);
            
            return $result && $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error deleting category: " . $e->getMessage());
            return false;
        }
    }
    
    public function category_exists($category_id, $user_id) {
        try {
            $sql = "SELECT category_id FROM categories WHERE category_id = ? AND user_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$category_id, $user_id]);
            
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error checking category existence: " . $e->getMessage());
            return false;
        }
    }
    
    public function get_category_count($user_id) {
        try {
            $sql = "SELECT COUNT(*) as count FROM categories WHERE user_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$user_id]);
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (PDOException $e) {
            error_log("Error counting categories: " . $e->getMessage());
            return 0;
        }
    }
}
?>
