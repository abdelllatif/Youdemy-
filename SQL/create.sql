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
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for videos
CREATE TABLE IF NOT EXISTS videos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    teacher_id INT NOT NULL,
    video_path VARCHAR(255) NOT NULL,
    duration INT NOT NULL, 
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
CREATE TABLE IF NOT EXISTS course_tags (
    video_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (video_id, tag_id),
    FOREIGN KEY (video_id) REFERENCES videos(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
);

-- Many-to-many relationship table for courses and categories
CREATE TABLE IF NOT EXISTS course_categories (
    document_id INT NOT NULL,
    video_id INT NOT NULL,
    category_id INT NOT NULL,
    PRIMARY KEY (document_id, video_id, category_id),
    FOREIGN KEY (document_id) REFERENCES document(id) ON DELETE CASCADE,
    FOREIGN KEY (video_id) REFERENCES videos(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- Table for learnings
CREATE TABLE IF NOT EXISTS learnings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    video_id INT NOT NULL,
    document_id INT NOT NULL,
    learning TEXT NOT NULL,
    FOREIGN KEY (video_id) REFERENCES videos(id) ON DELETE CASCADE,
    FOREIGN KEY (document_id) REFERENCES document(id) ON DELETE CASCADE
);

-- Table for enrollments
CREATE TABLE IF NOT EXISTS enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    video_id INT NOT NULL,
    document_id INT NOT NULL,
    enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completion_status ENUM('not_started', 'in_progress', 'completed') DEFAULT 'not_started',
    progress_percentage INT DEFAULT 0,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (video_id) REFERENCES videos(id) ON DELETE CASCADE,
    FOREIGN KEY (document_id) REFERENCES document(id) ON DELETE CASCADE
);


INSERT INTO users (last_name, first_name, email, password, role)   
VALUES ('Hissoune', 'Abdellatif', 'haissouneabdellatif749@gmail.com', '$2y$10$nqfaIeBEfymP8dMdBZ.ZqeRmARrrNOXmGZB1yY/BpBRcnIeDeur9C', 'admin'); 