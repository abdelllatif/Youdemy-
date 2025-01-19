<?php
require_once 'class_user.php';
require_once 'class_database_connexion.php';
class Admin extends User {
    private $pdo;

    public function __construct() {
        $this->pdo = new Data(); 
        $this->pdo->Connection(); 
        }


    
    // User Management Methods
    public function validateTeacherAccount($teacherId,$is_pproved) {
        try {
            if($is_pproved==true){
            $query = "UPDATE users SET is_approved = 'approved' WHERE id = :teacherId AND role = 'teacher'";
            }
            else{
            $query = "UPDATE users SET is_approved = 'rejected' WHERE id = :teacherId AND role = 'teacher'";

            }
            $stmt = $this->pdo->getConnection()->prepare($query);
            $stmt->bindParam(":teacherId", $teacherId);
            
            if($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => 'Teacher account validated successfully'
                ];
            }
            return [
                'success' => false,
                'message' => 'Failed to validate teacher account'
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }

    public function Afficher_teacher() {
        try {
            $query = "SELECT * FROM users WHERE role = 'teacher' ORDER BY created_at DESC";
            $stmt = $this->pdo->getConnection()->prepare($query);
            $stmt->execute();
            
            return ($stmt->rowCount() > 0) ? 
                   $stmt->fetchAll(PDO::FETCH_ASSOC) : 
                   [];
        } catch (PDOException $e) {
            return [];
        }
    }

    public function suspendUser($userId,$status) {
        try {
            if($status==0){
            $query = "UPDATE users SET status = 'suspended' WHERE id = :userId";
            }
            else{
            $query = "UPDATE users SET status = 'active' WHERE id = :userId";
            }
            $stmt = $this->pdo->getConnection()->prepare($query);
            $stmt->bindParam(":userId", $userId);
            
            if($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => 'User has been suspended successfully'
                ];
            }
            return [
                'success' => false,
                'message' => 'Failed to suspend user'
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }

    public function activateUser($userId) {
        try {
            $query = "UPDATE users SET status = 'active' WHERE id = :userId";
            $stmt = $this->pdo->getConnection()->prepare($query);
            $stmt->bindParam(":userId", $userId);
            
            if($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => 'User has been activated successfully'
                ];
            }
            return [
                'success' => false,
                'message' => 'Failed to activate user'
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }

    public function getUserStatus($userId) {
        try {
            $query = "SELECT id, first_name, last_name, email, status, role FROM users WHERE id = :userId";
            $stmt = $this->pdo->getConnection()->prepare($query);
            $stmt->bindParam(":userId", $userId);
            $stmt->execute();
            
            if($stmt->rowCount() > 0) {
                return [
                    'success' => true,
                    'data' => $stmt->fetch(PDO::FETCH_ASSOC)
                ];
            }
            return [
                'success' => false,
                'message' => 'User not found'
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }

    public function getAllUsersByStatus($status = null) {
        try {
            if ($status) {
                $query = "SELECT id, first_name, last_name, email, role, status, created_at 
                         FROM users 
                         WHERE status = :status 
                         ORDER BY created_at DESC";
            $stmt = $this->pdo->getConnection()->prepare($query);
            $stmt->bindParam(":status", $status);
            } else {
                $query = "SELECT id, first_name, last_name, email, role, status, created_at 
                         FROM users 
                         ORDER BY created_at DESC";
            $stmt = $this->pdo->getConnection()->prepare($query);
        }
            
            $stmt->execute();
            
            return [
                'success' => true,
                'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }

     // Get total number of videos
     public function getTotalVideos() {
        $query = "SELECT COUNT(*) as total_videos FROM videos";
        $stmt = $this->pdo->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_videos'];
    }

    // Get total number of documents
    public function getTotalDocuments() {
        $query = "SELECT COUNT(*) as total_documents FROM document";
        $stmt = $this->pdo->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_documents'];
    }

    // Get courses by category
    public function getCoursesByCategory() {
        $query = "
            SELECT c.name as category, COUNT(vc.video_id) + COUNT(dc.document_id) as total_courses
            FROM categories c
            LEFT JOIN video_categories vc ON c.id = vc.category_id
            LEFT JOIN document_categories dc ON c.id = dc.category_id
            GROUP BY c.name
        ";
        $stmt = $this->pdo->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get top course by student count
    public function getTopCourse() {
        $query = "
            SELECT title, student_count FROM (
                SELECT v.title as title, COUNT(e.id) as student_count
                FROM videos v
                JOIN video_enrollments e ON v.id = e.video_id
                GROUP BY v.id
                UNION ALL
                SELECT d.title as title, COUNT(e.id) as student_count
                FROM document d
                JOIN document_enrollments e ON d.id = e.document_id
                GROUP BY d.id
            ) as combined_courses
            ORDER BY student_count DESC
            LIMIT 1
        ";
        $stmt = $this->pdo->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get top 3 teachers by course count
    public function getTopTeachers() {
        $query = "
            SELECT u.first_name, u.last_name, COUNT(v.id) + COUNT(d.id) as course_count
            FROM users u
            LEFT JOIN videos v ON u.id = v.teacher_id
            LEFT JOIN document d ON u.id = d.teacher_id
            WHERE u.role = 'teacher'
            GROUP BY u.id
            ORDER BY course_count DESC
            LIMIT 3
        ";
        $stmt = $this->pdo->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function suspendCourse($courseId, $type, $role) {
        $pdo = new Data();
        $pdo->Connection();
        
        // Check the current status of the course
        if ($type === 'video') {
            $query = "SELECT status FROM videos WHERE id = :courseId";
        } else if ($type === 'document') {
            $query = "SELECT status FROM document WHERE id = :courseId";
        }
        
        // Get the current status of the course
        $stmt = $pdo->getConnection()->prepare($query);
        $stmt->bindParam(':courseId', $courseId, PDO::PARAM_INT);
        $stmt->execute();
        $course = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Determine whether to suspend or activate the course based on its current status
        if ($course['status'] === 'active') {
            // If it's currently active, suspend it
            if ($type === 'video') {
                $query = "UPDATE videos SET status = 'suspended', suspended_by = :role WHERE id = :courseId";
            } else if ($type === 'document') {
                $query = "UPDATE document SET status = 'suspended', suspended_by = :role WHERE id = :courseId";
            }
        } elseif ($course['status'] === 'suspended') {
            // If it's currently suspended, activate it
            if ($type === 'video') {
                $query = "UPDATE videos SET status = 'active', suspended_by = NULL WHERE id = :courseId";
            } else if ($type === 'document') {
                $query = "UPDATE document SET status = 'active', suspended_by = NULL WHERE id = :courseId";
            }
        }
        
        // Prepare the query
        $stmt = $pdo->getConnection()->prepare($query);
        $stmt->bindParam(':courseId', $courseId, PDO::PARAM_INT);
    
        // Bind the 'role' parameter only when suspending
        if ($course['status'] === 'active') {
            $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        }
    
        // Execute the update query to change the status
        return $stmt->execute();
    }
    
    
}