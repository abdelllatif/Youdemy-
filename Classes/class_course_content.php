<?php
require_once 'class_database_connexion.php';
abstract class CourseContent {
    protected $title;
    protected $description;
    protected $teacherId;

    public function __construct($title, $description) {
        $this->title = $title;
        $this->description = $description;
    }

    abstract public function getContent();
    abstract public function ajouter();
    abstract public function afficher();
}

class VideoHandler extends CourseContent {
    private $allowedVideoFormats = ['video/mp4', 'video/webm', 'video/ogg'];
    private $allowedImageFormats = ['image/jpeg', 'image/png', 'image/gif'];
    private $maxVideoSize = 938860800;
    private $maxImageSize = 12097152;  
    private $uploadDir = 'uploads/videos/';
    private $thumbnailDir = 'uploads/thumbnails/';
    private $videopath;
    private $thumbnailpath;
    private $fileSize;
    private $duration;

    public function __construct($title = '', $description = '') {
        parent::__construct($title, $description);
            if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
        if (!file_exists($this->thumbnailDir)) {
            mkdir($this->thumbnailDir, 0777, true);
        }
    }

    public function getContent() {
        return "Video: {$this->videopath}";
    }

    public function handleVideoUpload($videoFile, $thumbnailFile, $title, $description, $teacherId, $duration) {
        try {
            $videoValidation = $this->validateVideo($videoFile);
            if (!$videoValidation['success']) {
                return $videoValidation;
            }

            $thumbnailValidation = $this->validateThumbnail($thumbnailFile);
            if (!$thumbnailValidation['success']) {
                return $thumbnailValidation;
            }

            $this->fileSize = $videoFile['size'];

            $videoFileName = uniqid() . '_' . basename($videoFile['name']);
            $thumbnailFileName = uniqid() . '_' . basename($thumbnailFile['name']);

            move_uploaded_file($videoFile['tmp_name'], $this->uploadDir . $videoFileName);
            move_uploaded_file($thumbnailFile['tmp_name'], $this->thumbnailDir . $thumbnailFileName);

            $this->title = $title;
            $this->description = $description;
            $this->videopath = $this->uploadDir . $videoFileName;
            $this->thumbnailpath = $this->thumbnailDir . $thumbnailFileName;
            $this->duration = $duration;
            $this->teacherId = $teacherId;

            $result = $this->ajouter();


            return $result;

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Upload error: ' . $e->getMessage()
            ];
        }
    }

    public function addCategoriestoved($videoId, $categoryId) {
        try {
            $pdo = new Data();
            $pdo->Connection();
    
            // Log the input values
            error_log("Adding category - Video ID: $videoId, Category ID: $categoryId");
    
            $query = "INSERT INTO video_categories (video_id, category_id) 
                     VALUES (:video_id, :category_id)";
            
            $stmt = $pdo->getConnection()->prepare($query);
            
            $stmt->bindValue(':video_id', $videoId, PDO::PARAM_INT);
            $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
            
            $result = $stmt->execute();
            
            if (!$result) {
                $errorInfo = $stmt->errorInfo();
                error_log("Database error: " . print_r($errorInfo, true));
                throw new PDOException("Database error: " . $errorInfo[2]);
            }
            
            return true;
    
        } catch (PDOException $e) {
            error_log("Error in addCategoriestoved: " . $e->getMessage());
            throw new Exception("Category insertion failed: " . $e->getMessage());
        }
    }

    public function afficherByUserId($userId) {
        $pdo = new Data();
        $pdo->Connection();
        
        // Query to fetch videos
        $query = "SELECT v.*, u.first_name, u.last_name, u.avatar_path, u.role 
                  FROM videos v
                  INNER JOIN users u ON v.teacher_id = u.id
                  INNER JOIN video_enrollments ve ON v.id = ve.video_id
                  WHERE ve.student_id = :userId AND v.status != 'suspended'";
        $stmt = $pdo->getConnection()->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Fetch learning, categories, tags, and enrollments for each video
        foreach ($videos as &$video) {
            // Fetch learning objectives
            $query = "SELECT learning FROM video_learnings WHERE video_id = :video_id";
            $stmt = $pdo->getConnection()->prepare($query);
            $stmt->bindParam(':video_id', $video['id'], PDO::PARAM_INT);
            $stmt->execute();
            $learning = $stmt->fetchAll(PDO::FETCH_COLUMN);
            $video['learning'] = $learning;
    
            // Fetch categories
            $query = "SELECT c.name 
                      FROM categories c
                      INNER JOIN video_categories cc ON c.id = cc.category_id
                      WHERE cc.video_id = :video_id";
            $stmt = $pdo->getConnection()->prepare($query);
            $stmt->bindParam(':video_id', $video['id'], PDO::PARAM_INT);
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_COLUMN);
            $video['categories'] = $categories;
    
            // Fetch tags
            $query = "SELECT t.name 
                      FROM tags t
                      INNER JOIN video_tags ct ON t.id = ct.tag_id
                      WHERE ct.video_id = :video_id";
            $stmt = $pdo->getConnection()->prepare($query);
            $stmt->bindParam(':video_id', $video['id'], PDO::PARAM_INT);
            $stmt->execute();
            $tags = $stmt->fetchAll(PDO::FETCH_COLUMN);
            $video['tags'] = $tags;
    
            // Fetch enrollments count
            $query = "SELECT COUNT(*) as enrollments FROM video_enrollments WHERE video_id = :video_id";
            $stmt = $pdo->getConnection()->prepare($query);
            $stmt->bindParam(':video_id', $video['id'], PDO::PARAM_INT);
            $stmt->execute();
            $enrollments = $stmt->fetch(PDO::FETCH_ASSOC);
            $video['enrollments'] = $enrollments['enrollments'];
        }
    
        return $videos ?: []; // Return empty array if no videos are found
    }
    



    public function addTagstovd($videoId, $tags) {
        $pdo = new Data();
        $pdo->Connection();

        $query = "INSERT INTO video_tags (video_id, tag_id) VALUES (:video_id, :tag_id)";
        try {
            $stmt = $pdo->getConnection()->prepare($query);

            
                $stmt->execute([
                    ':video_id' => $videoId,
                    ':tag_id' => $tags
                ]);
            
        } catch (PDOException $e) {
            error_log("Error adding tags: " . $e->getMessage());
        }
    }
    function addLearning($videoId, $learning) {
        $pdo = new Data();
        $pdo->Connection();
        
        $query = "INSERT INTO video_learnings (video_id, learning) VALUES (:video_id, :learning)";
        
        try {
            $stmt = $pdo->getConnection()->prepare($query);
            $stmt->execute([
                ':video_id' => $videoId,
                ':learning' => $learning
            ]);
        } catch (PDOException $e) {
            error_log("Error adding learning: " . $e->getMessage());
        }
    }
    public function ajouter() {
        $pdo = new Data();
        $pdo->Connection();

        $query = "INSERT INTO videos (title, description, teacher_id, video_path, thumbnail_path, file_size, duration) 
                  VALUES (:title, :description, :teacher_id, :video_path, :thumbnail_path, :file_size, :duration)";

        try {
            $stmt = $pdo->getConnection()->prepare($query);
            $stmt->execute([
                ':title' => $this->title,
                ':description' => $this->description,
                ':teacher_id' => $this->teacherId,
                ':video_path' => $this->videopath,
                ':thumbnail_path' => $this->thumbnailpath,
                ':file_size' => $this->fileSize,
                ':duration' => $this->duration
            ]);
            return [
                'success' => true,
                'message' => 'Video content added successfully!',
                'video_id' => $pdo->getConnection()->lastInsertId()
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => "Error: " . $e->getMessage()
            ];
        }
    }
    
    


    private function validateVideo($file) {
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            return ['success' => false, 'message' => 'No video file uploaded'];
        }

        if ($file['size'] > $this->maxVideoSize) {
            return ['success' => false, 'message' => 'Video file is too large (max 800MB)'];
        }
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $this->allowedVideoFormats)) {
            return ['success' => false, 'message' => 'Invalid video format'];
        }
        return ['success' => true];
        }

    private function validateThumbnail($file) {
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            return ['success' => false, 'message' => 'No thumbnail file uploaded'];
        }
        if ($file['size'] > $this->maxImageSize) {
            return ['success' => false, 'message' => 'Thumbnail file is too large (max 2MB)'];
        }
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $this->allowedImageFormats)) {
            return ['success' => false, 'message' => 'Invalid thumbnail format'];
        }

        return ['success' => true];
    }



//******************************************************************** */











    public function afficher() {
        $pdo = new Data();
        $pdo->Connection();
    
        $query = "SELECT v.*, u.first_name, u.last_name, u.avatar_path, u.role 
          FROM videos v
          INNER JOIN users u ON v.teacher_id = u.id
          WHERE v.status != 'suspended'";
        $stmt = $pdo->getConnection()->prepare($query);
        $stmt->execute();
        $videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($videos as &$video) {
            // Get learnings
            $query = "SELECT learning FROM video_learnings WHERE video_id = :video_id";
            $stmt = $pdo->getConnection()->prepare($query);
            $stmt->bindParam(':video_id', $video['id'], PDO::PARAM_INT);
            $stmt->execute();
            $learning = $stmt->fetchAll(PDO::FETCH_COLUMN);
            $video['learning'] = $learning;
    
            // Get categories
            $query = "SELECT c.name 
                      FROM categories c
                      INNER JOIN video_categories cc ON c.id = cc.category_id
                      WHERE cc.video_id = :video_id";
            $stmt = $pdo->getConnection()->prepare($query);
            $stmt->bindParam(':video_id', $video['id'], PDO::PARAM_INT);
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_COLUMN);
            $video['categories'] = $categories;
    
            // Get tags
            $query = "SELECT t.name 
                      FROM tags t
                      INNER JOIN video_tags ct ON t.id = ct.tag_id
                      WHERE ct.video_id = :video_id";
            $stmt = $pdo->getConnection()->prepare($query);
            $stmt->bindParam(':video_id', $video['id'], PDO::PARAM_INT);
            $stmt->execute();
            $tags = $stmt->fetchAll(PDO::FETCH_COLUMN);
            $video['tags'] = $tags;
    
            // Get enrollments
            $query = "SELECT COUNT(*) as enrollments FROM video_enrollments WHERE video_id = :video_id";
            $stmt = $pdo->getConnection()->prepare($query);
            $stmt->bindParam(':video_id', $video['id'], PDO::PARAM_INT);
            $stmt->execute();
            $enrollments = $stmt->fetch(PDO::FETCH_ASSOC);
            $video['enrollments'] = $enrollments['enrollments'];
        }
    
        return $videos;
    }
    public function afficherbyid($id) {
        $pdo = new Data();
        $pdo->Connection();
        $id = (int) $id;
    
        $query = "SELECT * FROM videos v
                  INNER JOIN users u ON v.teacher_id = u.id
                  WHERE v.id = :id AND ";
        $stmt = $pdo->getConnection()->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $query = "SELECT learning FROM learnings WHERE video_id = :id";
            $stmt = $pdo->getConnection()->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $learnings = $stmt->fetchAll(PDO::FETCH_COLUMN);
            $result['learning'] = $learnings;
            return $result;
        } else {
            return [];
        }
    }






    public function getTeacherVideos($teacherId) {
        $pdo = new Data();
        $pdo->Connection();

        $query = "SELECT v.*, u.first_name, u.last_name, u.avatar_path, u.role
                  FROM videos v
                  INNER JOIN users u ON v.teacher_id = u.id
                  WHERE v.teacher_id = :teacher_id AND v.status != 'suspended'";
        $stmt = $pdo->getConnection()->prepare($query);
        $stmt->bindParam(':teacher_id', $teacherId, PDO::PARAM_INT);
        $stmt->execute();
        $videos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($videos as &$video) {
            $query = "SELECT learning FROM video_learnings WHERE video_id = :video_id";
            $stmt = $pdo->getConnection()->prepare($query);
            $stmt->bindParam(':video_id', $video['id'], PDO::PARAM_INT);
            $stmt->execute();
            $learning = $stmt->fetchAll(PDO::FETCH_COLUMN);
            $video['learning'] = $learning;

            $query = "SELECT c.name 
                      FROM categories c
                      INNER JOIN video_categories cc ON c.id = cc.category_id
                      WHERE cc.video_id = :video_id";
            $stmt = $pdo->getConnection()->prepare($query);
            $stmt->bindParam(':video_id', $video['id'], PDO::PARAM_INT);
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_COLUMN);
            $video['categories'] = $categories;

            $query = "SELECT t.name 
                      FROM tags t
                      INNER JOIN video_tags ct ON t.id = ct.tag_id
                      WHERE ct.video_id = :video_id";
            $stmt = $pdo->getConnection()->prepare($query);
            $stmt->bindParam(':video_id', $video['id'], PDO::PARAM_INT);
            $stmt->execute();
            $tags = $stmt->fetchAll(PDO::FETCH_COLUMN);
            $video['tags'] = $tags;
        }

        return $videos;
    }




    public function enrollUser($student_id, $video_id) {
        try {
            $pdo = new Data();
            $pdo->Connection();
    
            // Get the teacher ID from the document
            $query = $pdo->getConnection()->prepare("SELECT teacher_id FROM videos WHERE id = :video_id");
            $query->bindParam(':video_id', $video_id, PDO::PARAM_INT);
            $query->execute();
            $teacher = $query->fetch(PDO::FETCH_ASSOC);
    
            if (!$teacher) {
                return "Teacher not found for this document.";
            }
    
            $teacher_id = $teacher['teacher_id'];
    
            // Check if the enrollment already exists
            $query = $pdo->getConnection()->prepare("SELECT * FROM video_enrollments WHERE student_id = :student_id AND video_id = :video_id");
            $query->execute(['student_id' => $student_id, 'video_id' => $video_id]);
    
            if ($query->rowCount() == 0) {
                // If it doesn't exist, add the enrollment
                $query = $pdo->getConnection()->prepare("INSERT INTO video_enrollments (student_id, teacher_id, video_id) VALUES (:student_id, :teacher_id, :video_id)");
                $query->execute(['student_id' => $student_id, 'teacher_id' => $teacher_id, 'video_id' => $video_id]);
    
                return "  registred!";
            } else {
                return "alredy registred ";
            }
        } catch (PDOException $e) {

            return " there is a probleme : " . $e->getMessage();
        }
    }






}

class DocumentContent extends CourseContent {  
    private $documentpath;  
    protected $teacherId;  

    public function __construct($title, $description, $teacherId, $documentpath = '') {  
        parent::__construct($title, $description);  
        $this->teacherId = $teacherId; 
        $this->documentpath = $documentpath;   
    }  

    public function getContent() {  
        return "Document: {$this->documentpath}";  
    }  

    public function ajouter() {  
        $pdo = new Data();  
        $pdo->Connection();  
        $query = "INSERT INTO document (title, teacher_id, description, document_path) VALUES (:title, :teacher_id, :description, :document_path)";  
        try {  
            $stmt = $pdo->getConnection()->prepare($query);  
            $stmt->bindParam(':title', $this->title);  
            $stmt->bindParam(':description', $this->description);  
            $stmt->bindParam(':teacher_id', $this->teacherId);  
            $stmt->bindParam(':document_path', $this->documentpath);  
            $stmt->execute();  
            return [  
                'success' => true,  
                'message' => "Document content added successfully!",  
                'document_id' => $pdo->getConnection()->lastInsertId() 
            ];  
        } catch (PDOException $e) {  
            return [  
                'success' => false,  
                'message' => "Error: " . $e->getMessage()  
            ];  
        }  
    }  

    public function uploadFile($file) {  
        if ($file['error'] !== UPLOAD_ERR_OK) {  
            return "Error uploading file: " . $file['error'];  
        }  

        $fileType = $file['type'];  
        $allowedTypes = [  
            'application/pdf',   
            'application/vnd.ms-excel',   
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'  
        ];  

        if (!in_array($fileType, $allowedTypes)) {  
            return "Error: Unsupported file type.";  
        }   

        $uploadDir = 'uploads/';  
        $destPath = $uploadDir . basename($file['name']);  
        if (move_uploaded_file($file['tmp_name'], $destPath)) {  
            $this->documentpath = $destPath;  
            return $this->ajouter(); 
        } else {  
            return "Error: Unable to move uploaded file.";  
        }  
    }   

    public function addCategoriestodoc($document_id, $categoryId) {
        try {
            $pdo = new Data();
            $pdo->Connection();
    
            error_log("Adding category - Video ID: $document_id, Category ID: ");
    
            $query = "INSERT INTO document_categories (document_id, category_id) 
                     VALUES (:document_id, :category_id)";
            
            $stmt = $pdo->getConnection()->prepare($query);
            
            $stmt->bindValue(':document_id', $document_id, PDO::PARAM_INT);
            $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
            
            $result = $stmt->execute();
            
            if (!$result) {
                $errorInfo = $stmt->errorInfo();
                error_log("Database error: " . print_r($errorInfo, true));
                throw new PDOException("Database error: " . $errorInfo[2]);
            }
            
            return true;
    
        } catch (PDOException $e) {
            error_log("Error in addCategoriestoved: " . $e->getMessage());
            throw new Exception("Category insertion failed: " . $e->getMessage());
        }
    }

    public function addTagstodoc($document_id, $tags) {
        $pdo = new Data();
        $pdo->Connection();

        $query = "INSERT INTO document_tags (document_id, tag_id) VALUES (:document_id, :tag_id)";
        try {
            $stmt = $pdo->getConnection()->prepare($query);

            
                $stmt->execute([
                    ':document_id' => $document_id,
                    ':tag_id' => $tags
                ]);
            
        } catch (PDOException $e) {
            error_log("Error adding tags: " . $e->getMessage());
        }
    }
    function addLearning($document_id, $learning) {
        $pdo = new Data();
        $pdo->Connection();
        
        $query = "INSERT INTO document_learnings (document_id, learning) VALUES (:document_id, :learning)";
        
        try {
            $stmt = $pdo->getConnection()->prepare($query);
            $stmt->execute([
                ':document_id' => $document_id,
                ':learning' => $learning
            ]);
        } catch (PDOException $e) {
            error_log("Error adding learning: " . $e->getMessage());
        }
    }

    public function afficher() {
        $pdo = new Data();
        $pdo->Connection();
        $query = "SELECT d.*, u.first_name, u.last_name, u.avatar_path, u.role
        FROM document d
        INNER JOIN users u ON d.teacher_id = u.id
                  WHERE d.status != 'suspended'";
        $stmt = $pdo->getConnection()->prepare($query);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($result as &$document) {
                $learningQuery = "SELECT learning FROM document_learnings WHERE document_id = :document_id";
                $learningStmt = $pdo->getConnection()->prepare($learningQuery);
                $learningStmt->bindParam(':document_id', $document['id'], PDO::PARAM_INT);
                $learningStmt->execute();
                $learning = $learningStmt->fetchAll(PDO::FETCH_COLUMN);
                $document['learning'] = $learning;
    
                $categoryQuery = "SELECT c.name
                FROM categories c
                INNER JOIN document_categories cc ON c.id = cc.category_id
                WHERE cc.document_id = :document_id";
                $categoryStmt = $pdo->getConnection()->prepare($categoryQuery);
                $categoryStmt->bindParam(':document_id', $document['id'], PDO::PARAM_INT);
                $categoryStmt->execute();
                $categories = $categoryStmt->fetchAll(PDO::FETCH_COLUMN);
                $document['categories'] = $categories;
    
                // Fetch tags
                $tagQuery = "SELECT t.name
                FROM tags t
                INNER JOIN document_tags ct ON t.id = ct.tag_id
                WHERE ct.document_id = :document_id";
                $tagStmt = $pdo->getConnection()->prepare($tagQuery);
                $tagStmt->bindParam(':document_id', $document['id'], PDO::PARAM_INT);
                $tagStmt->execute();
                $tags = $tagStmt->fetchAll(PDO::FETCH_COLUMN);
                $document['tags'] = $tags;
            }
            
            return $result;
        } else {
            return "No documents found.";
        }
    }

    public function enrollUser($student_id, $document_id) {
        try {
            $pdo = new Data();
            $pdo->Connection();
    
            // Get the teacher ID from the document
            $query = $pdo->getConnection()->prepare("SELECT teacher_id FROM document WHERE id = :document_id");
            $query->bindParam(':document_id', $document_id, PDO::PARAM_INT);
            $query->execute();
            $teacher = $query->fetch(PDO::FETCH_ASSOC);
    
            if (!$teacher) {
                return "Teacher not found for this document.";
            }
    
            $teacher_id = $teacher['teacher_id'];
    
            // Check if the enrollment already exists
            $query = $pdo->getConnection()->prepare("SELECT * FROM document_enrollments WHERE student_id = :student_id AND document_id = :document_id");
            $query->execute(['student_id' => $student_id, 'document_id' => $document_id]);
    
            if ($query->rowCount() == 0) {
                // If it doesn't exist, add the enrollment
                $query = $pdo->getConnection()->prepare("INSERT INTO document_enrollments (student_id, teacher_id, document_id) VALUES (:student_id, :teacher_id, :document_id)");
                $query->execute(['student_id' => $student_id, 'teacher_id' => $teacher_id, 'document_id' => $document_id]);
    
                return "  registred!";
            } else {
                return "alredy registred ";
            }
        } catch (PDOException $e) {
            return " there is a probleme : " . $e->getMessage();
        }
    }
    public function getUserDocuments($student_id) {
        $pdo = new Data();
        $pdo->Connection();

        $query = $pdo->getConnection()->prepare("
            SELECT document.*
            FROM document
            JOIN enrollments ON document.id = enrollments.document_id
            WHERE enrollments.student_id = :student_id
        ");
        $query->execute(['student_id' => $student_id]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDocumentById($id) {
        $pdo = new Data();
        $pdo->Connection();
        $id = (int) $id;
    
        $query = "SELECT d.*, u.first_name, u.last_name, u.avatar_path, u.role, d.created_at
                  FROM document d
                  INNER JOIN users u ON d.teacher_id = u.id
                  WHERE d.id = :id";
        $stmt = $pdo->getConnection()->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            $query = "SELECT c.name 
                      FROM categories c
                      INNER JOIN document_categories dc ON c.id = dc.category_id
                      WHERE dc.document_id = :id";
            $stmt = $pdo->getConnection()->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_COLUMN);
            $result['categories'] = $categories;
    
            $query = "SELECT t.name 
                      FROM tags t
                      INNER JOIN document_tags dt ON t.id = dt.tag_id
                      WHERE dt.document_id = :id";
            $stmt = $pdo->getConnection()->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $tags = $stmt->fetchAll(PDO::FETCH_COLUMN);
            $result['tags'] = $tags;
    
            $query = "SELECT learning FROM document_learnings WHERE document_id = :id";
            $stmt = $pdo->getConnection()->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $learnings = $stmt->fetchAll(PDO::FETCH_COLUMN);
            $result['learning'] = $learnings;
    
            return $result;
        } else {
            return [];
        }
    }



    public function afficherByUserId($userId) {
        $pdo = new Data();
        $pdo->Connection();
        
        // Query to fetch documents
        $query = "SELECT d.*, u.first_name, u.last_name, u.avatar_path, u.role 
                  FROM document d
                  INNER JOIN users u ON d.teacher_id = u.id
                  INNER JOIN document_enrollments de ON d.id = de.document_id
                  WHERE de.student_id = :userId AND d.status != 'suspended'";
        $stmt = $pdo->getConnection()->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Fetch learning, categories, and tags for each document
        foreach ($documents as &$document) {
            // Fetch learning objectives
            $learningQuery = "SELECT learning FROM document_learnings WHERE document_id = :document_id";
            $learningStmt = $pdo->getConnection()->prepare($learningQuery);
            $learningStmt->bindParam(':document_id', $document['id'], PDO::PARAM_INT);
            $learningStmt->execute();
            $learning = $learningStmt->fetchAll(PDO::FETCH_COLUMN);
            $document['learning'] = $learning;
    
            // Fetch categories
            $categoryQuery = "SELECT c.name
                              FROM categories c
                              INNER JOIN document_categories cc ON c.id = cc.category_id
                              WHERE cc.document_id = :document_id";
            $categoryStmt = $pdo->getConnection()->prepare($categoryQuery);
            $categoryStmt->bindParam(':document_id', $document['id'], PDO::PARAM_INT);
            $categoryStmt->execute();
            $categories = $categoryStmt->fetchAll(PDO::FETCH_COLUMN);
            $document['categories'] = $categories;
    
            // Fetch tags
            $tagQuery = "SELECT t.name
                         FROM tags t
                         INNER JOIN document_tags ct ON t.id = ct.tag_id
                         WHERE ct.document_id = :document_id";
            $tagStmt = $pdo->getConnection()->prepare($tagQuery);
            $tagStmt->bindParam(':document_id', $document['id'], PDO::PARAM_INT);
            $tagStmt->execute();
            $tags = $tagStmt->fetchAll(PDO::FETCH_COLUMN);
            $document['tags'] = $tags;
        }
    
        return $documents ?: []; // Return empty array if no documents are found
    }
    





    public function getTeacherDocuments($teacherId) {
        $pdo = new Data();
        $pdo->Connection();

        $query = "SELECT d.*, u.first_name, u.last_name, u.avatar_path, u.role, d.created_at
                  FROM document d
                  INNER JOIN users u ON d.teacher_id = u.id
                  WHERE d.teacher_id = :teacher_id";
        $stmt = $pdo->getConnection()->prepare($query);
        $stmt->bindParam(':teacher_id', $teacherId, PDO::PARAM_INT);
        $stmt->execute();
        $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($documents as &$document) {
            $learningQuery = "SELECT learning FROM document_learnings WHERE document_id = :document_id";
            $learningStmt = $pdo->getConnection()->prepare($learningQuery);
            $learningStmt->bindParam(':document_id', $document['id'], PDO::PARAM_INT);
            $learningStmt->execute();
            $learning = $learningStmt->fetchAll(PDO::FETCH_COLUMN);
            $document['learning'] = $learning;

            $categoryQuery = "SELECT c.name
                              FROM categories c
                              INNER JOIN document_categories cc ON c.id = cc.category_id
                              WHERE cc.document_id = :document_id";
            $categoryStmt = $pdo->getConnection()->prepare($categoryQuery);
            $categoryStmt->bindParam(':document_id', $document['id'], PDO::PARAM_INT);
            $categoryStmt->execute();
            $categories = $categoryStmt->fetchAll(PDO::FETCH_COLUMN);
            $document['categories'] = $categories;

            $tagQuery = "SELECT t.name
                         FROM tags t
                         INNER JOIN document_tags ct ON t.id = ct.tag_id
                         WHERE ct.document_id = :document_id";
            $tagStmt = $pdo->getConnection()->prepare($tagQuery);
            $tagStmt->bindParam(':document_id', $document['id'], PDO::PARAM_INT);
            $tagStmt->execute();
            $tags = $tagStmt->fetchAll(PDO::FETCH_COLUMN);
            $document['tags'] = $tags;
        }

        return $documents;
    }




}
    
?>
















