<?php
require_once 'class_database_connexion.php';
class TeacherStatistics  {
    private $conn;
    
    public function __construct() {
        $this->conn = new Data();
        $this->conn->Connection();
    }
    
    public function getTotalVideoStudents($teacherId) {
        $query = "SELECT COUNT(DISTINCT student_id) as total_students 
                  FROM video_enrollments 
                  WHERE teacher_id = :teacherId";

        $stmt = $this->conn->getConnection()->prepare($query);
        $stmt->bindValue(":teacherId", $teacherId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['total_students'] : 0;
    }

    public function getTotalDocumentStudents($teacherId) {
        $query = "SELECT COUNT(DISTINCT student_id) as total_students 
                  FROM document_enrollments 
                  WHERE teacher_id = :teacherId";

        $stmt = $this->conn->getConnection()->prepare($query);
        $stmt->bindValue(":teacherId", $teacherId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['total_students'] : 0;
    }
    
    public function getTotalVideos($teacherId) {
        $query = "SELECT COUNT(*) as total_videos 
                  FROM videos 
                  WHERE teacher_id = :teacherId AND status = 'active'";

        $stmt = $this->conn->getConnection()->prepare($query);
        $stmt->bindValue(":teacherId", $teacherId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['total_videos'] : 0;
    }
    
    public function getTotalDocuments($teacherId) {
        $query = "SELECT COUNT(*) as total_documents 
                  FROM document 
                  WHERE teacher_id = :teacherId AND status = 'active'";

        $stmt = $this->conn->getConnection()->prepare($query);
        $stmt->bindValue(":teacherId", $teacherId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['total_documents'] : 0;
    }
    
    public function getTopVideos($teacherId) {
        $query = "SELECT v.title, COUNT(ve.student_id) as enrollment_count 
                  FROM videos v 
                  LEFT JOIN video_enrollments ve ON v.id = ve.video_id 
                  WHERE v.teacher_id = :teacherId AND v.status = 'active'
                  GROUP BY v.id 
                  ORDER BY enrollment_count DESC 
                  LIMIT 5";

        $stmt = $this->conn->getConnection()->prepare($query);
        $stmt->bindValue(":teacherId", $teacherId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }public function getEnrolledStudents($teacherId) {
        $query = "SELECT DISTINCT s.id, s.first_name,s.last_name, s.email 
                  FROM users s
                  INNER JOIN video_enrollments ve ON s.id = ve.student_id
                  INNER JOIN document_enrollments de ON s.id = de.student_id
                  WHERE ve.teacher_id = :teacherId OR de.teacher_id = :teacherId";
        
        $stmt = $this->conn->getConnection()->prepare($query);
        $stmt->bindValue(":teacherId", $teacherId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getTeacherProfile($teacherId) {
        $query = "SELECT first_name,last_name,avatar_path, specialty, age, email 
                  FROM users 
                  WHERE id = :teacherId";
        
        $stmt = $this->conn->getConnection()->prepare($query);
        $stmt->bindValue(":teacherId", $teacherId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

}
