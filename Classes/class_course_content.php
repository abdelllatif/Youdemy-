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
    private $maxVideoSize = 838860800; // 800MB in bytes
    private $maxImageSize = 2097152;   // 2MB in bytes
    private $uploadDir = 'uploads/videos/';
    private $thumbnailDir = 'uploads/thumbnails/';
    private $videopath;
    private $thumbnailpath;
    private $fileSize;
    private $duration;

    public function __construct($title = '', $description = '') {
        parent::__construct($title, $description);
        
        // Create upload directories if they don't exist
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

    public function handleVideoUpload($videoFile, $thumbnailFile, $title, $description, $teacherId, $categories, $tags, $duration) {
        try {
            // Validate video
            $videoValidation = $this->validateVideo($videoFile);
            if (!$videoValidation['success']) {
                return $videoValidation;
            }

            // Validate thumbnail
            $thumbnailValidation = $this->validateThumbnail($thumbnailFile);
            if (!$thumbnailValidation['success']) {
                return $thumbnailValidation;
            }

            // Store file size
            $this->fileSize = $videoFile['size'];

            // Generate unique filenames
            $videoFileName = uniqid() . '_' . basename($videoFile['name']);
            $thumbnailFileName = uniqid() . '_' . basename($thumbnailFile['name']);

            // Move files to appropriate directories
            move_uploaded_file($videoFile['tmp_name'], $this->uploadDir . $videoFileName);
            move_uploaded_file($thumbnailFile['tmp_name'], $this->thumbnailDir . $thumbnailFileName);

            // Set class properties
            $this->title = $title;
            $this->description = $description;
            $this->videopath = $this->uploadDir . $videoFileName;
            $this->thumbnailpath = $this->thumbnailDir . $thumbnailFileName;
            $this->duration = $duration;
            $this->teacherId = $teacherId;

            // Save to database
            $result = $this->ajouter();

            if ($result['success']) {
                $videoId = $result['video_id'];

                // Add categories
                if (!empty($categories)) {
                    $this->addCategories($videoId, $categories);
                }

                // Add tags
                if (!empty($tags)) {
                    $this->addTags($videoId, $tags);
                }
            }

            return $result;

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Upload error: ' . $e->getMessage()
            ];
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
    
    
    
 
    private function addCategories($videoId, $categories) {
        $pdo = new Data();
        $pdo->Connection();
        
        $query = "INSERT INTO course_categories (video_id, category_id) VALUES (:video_id, :category_id)";
        
        try {
            $stmt = $pdo->getConnection()->prepare($query);
            
            foreach ($categories as $categoryId) {
                $stmt->execute([
                    ':video_id' => $videoId,
                    ':category_id' => $categoryId
                ]);
            }
            return true;
        } catch (PDOException $e) {
            error_log("Error adding categories: " . $e->getMessage());
            return false;
        }
    }
    
    private function addTags($videoId, $tags) {
        $pdo = new Data();
        $pdo->Connection();
        
        $query = "INSERT INTO video_tags (video_id, tag_id) VALUES (:video_id, :tag_id)";
        
        try {
            $stmt = $pdo->getConnection()->prepare($query);
            
            foreach ($tags as $tagId) {
                $stmt->execute([
                    ':video_id' => $videoId,
                    ':tag_id' => $tagId
                ]);
            }
            return true;
        } catch (PDOException $e) {
            error_log("Error adding tags: " . $e->getMessage());
            return false;
        }
    }


    private function validateVideo($file) {
        // Check if file was uploaded
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            return ['success' => false, 'message' => 'No video file uploaded'];
        }

        // Check file size
        if ($file['size'] > $this->maxVideoSize) {
            return ['success' => false, 'message' => 'Video file is too large (max 800MB)'];
        }

        // Check file type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $this->allowedVideoFormats)) {
            return ['success' => false, 'message' => 'Invalid video format'];
        }

        return ['success' => true];
    }

    private function validateThumbnail($file) {
        // Check if file was uploaded
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            return ['success' => false, 'message' => 'No thumbnail file uploaded'];
        }

        // Check file size
        if ($file['size'] > $this->maxImageSize) {
            return ['success' => false, 'message' => 'Thumbnail file is too large (max 2MB)'];
        }

        // Check file type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $this->allowedImageFormats)) {
            return ['success' => false, 'message' => 'Invalid thumbnail format'];
        }

        return ['success' => true];
    }
    public function afficher() {
        $pdo = new Data();
        $pdo->Connection();
        // return "Title: {$this->title}<br>" .
        //        "Description: {$this->description}<br>" .
        //        "Video path: {$this->videopath}<br>" .
        //        "Thumbnail path: {$this->thumbnailpath}<br>" .
        //        "File Size: " . round($this->fileSize / (1024 * 1024), 2) . " MB";
        $query="SELECT * FROM videos v
        INNER JOIN users u on v.teacher_id=u.id";
            $stmt = $pdo->getConnection()->prepare($query);
           $stmt->execute();
           if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } else {
            return "No videos found.";
        }
        
        }

        public function afficherbyid($id) {
            $pdo = new Data();
            $pdo->Connection();
        
            // Explicitly cast the ID to an integer
            $id = (int) $id;
        
            $query = "SELECT * FROM videos v
                      INNER JOIN users u ON v.teacher_id = u.id
                      WHERE v.id = :id";
            $stmt = $pdo->getConnection()->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            } else {
                return [];
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
            // Set the document path after moving the file  
            $this->documentpath = $destPath;  
            // Now simply call ajouter  
            return $this->ajouter(); // No parameters needed, already set in properties  
        } else {  
            return "Error: Unable to move uploaded file.";  
        }  
    }   

    public function afficher() {
        $pdo = new Data();
        $pdo->Connection();
        // return "Title: {$this->title}<br>" .
        //        "Description: {$this->description}<br>" .
        //        "Video path: {$this->videopath}<br>" .
        //        "Thumbnail path: {$this->thumbnailpath}<br>" .
        //        "File Size: " . round($this->fileSize / (1024 * 1024), 2) . " MB";
        $query="SELECT * FROM document d
        INNER JOIN users u on d.teacher_id=u.id";
            $stmt = $pdo->getConnection()->prepare($query);
           $stmt->execute();
           if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } else {
            return "No videos found.";
        }
        
        }
}
?>
















