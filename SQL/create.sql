CREATE DATABASE IF NOT EXISTS youdemy;

USE youdemy;

-- Table for users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    last_name VARCHAR(255) NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('student', 'teacher', 'admin') NOT NULL,
    avatar_path VARCHAR(255) NOT NULL,
    is_approved ENUM('approved', 'waiting', 'rejected') DEFAULT 'waiting', 
     status ENUM('active', 'suspended') DEFAULT 'active', 
   GRANT created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Table for videos
CREATE TABLE IF NOT EXISTS videos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    teacher_id INT NOT NULL,
    video_path VARCHAR(255) NOT NULL,
    thumbnail_path VARCHAR(255) NOT NULL,
    duration INT NOT NULL, 
    file_size INT NOT NULL,	
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


-- Table for documents
CREATE TABLE IF NOT EXISTS document (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    teacher_id INT NOT NULL,
    document_path VARCHAR(255) NOT NULL,
    type VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table for tags
CREATE TABLE IF NOT EXISTS tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for categories
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Many-to-many relationship table for courses and tags
CREATE TABLE IF NOT EXISTS video_tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    video_id INT NOT NULL,
    tag_id INT NOT NULL,
    FOREIGN KEY (video_id) REFERENCES videos(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE,
    UNIQUE KEY unique_video_tag (video_id, tag_id)
);
CREATE TABLE IF NOT EXISTS document_tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    document_id INT NOT NULL,
    tag_id INT NOT NULL,
    FOREIGN KEY (document_id) REFERENCES document(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE,
    UNIQUE KEY unique_document_tag (document_id, tag_id)
);

-- Many-to-many relationship table for courses and categories
CREATE TABLE IF NOT EXISTS video_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    video_id INT NOT NULL,
    category_id  INT NOT NULL,
    FOREIGN KEY (video_id) REFERENCES videos(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    UNIQUE KEY unique_video_category (video_id, category_id)
);
CREATE TABLE IF NOT EXISTS document_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    document_id INT NOT NULL,
    category_id  INT NOT NULL,
    FOREIGN KEY (document_id) REFERENCES documents(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    UNIQUE KEY unique_document_category (document_id, category_id)
);
-- Table for video learnings
CREATE TABLE IF NOT EXISTS video_learnings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    video_id INT NOT NULL,
    learning TEXT NOT NULL,
    FOREIGN KEY (video_id) REFERENCES videos(id) ON DELETE CASCADE
);

-- Table for document learnings
CREATE TABLE IF NOT EXISTS document_learnings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    document_id INT NOT NULL,
    learning TEXT NOT NULL,
    FOREIGN KEY (document_id) REFERENCES document(id) ON DELETE CASCADE
);


CREATE TABLE video_enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    teacher_id INT NOT NULL,
    video_id INT NOT NULL,
    enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (video_id) REFERENCES videos(id) ON DELETE CASCADE,
    FOREIGN KEY (teacher_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE document_enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    teacher_id INT NOT NULL,
    document_id INT NOT NULL,
    enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (document_id) REFERENCES document(id) ON DELETE CASCADE,
    FOREIGN KEY (teacher_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO users (last_name, first_name, email, password, role)   
VALUES ('Hissoune', 'Abdellatif', 'haissouneabdellatif749@gmail.com', '$2y$10$gGmpLCWHVUiMNizjQSrhhOqwnSahWMAQbfrjt9JalO.cpas/L1JQy', 'teacher','Uploads/default_avatar.jpg'); 

ALTER TABLE videos ADD COLUMN status VARCHAR(20) DEFAULT 'active';
ALTER TABLE videos ADD COLUMN suspended_by VARCHAR(50) NULL;

ALTER TABLE document ADD COLUMN status VARCHAR(20) DEFAULT 'active';
ALTER TABLE document ADD COLUMN suspended_by VARCHAR(50) NULL;
ALTER TABLE teachers
ADD COLUMN age INT NOT NULL,
ADD COLUMN specialty VARCHAR(255) NOT NULL;
