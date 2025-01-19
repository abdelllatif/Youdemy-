<?php
session_start();
require_once '../../Classes/class_course_content.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input fields
    if (empty($_POST['title']) || empty($_FILES['video']) || empty($_FILES['thumbnail'])) {
        echo json_encode([
            'success' => false,
            'message' => "Error: All fields are required and duration must be greater than 0."
        ]);
        exit;
    }

    // Initialize variables
    $video = $_FILES['video'];
    $thumbnail = $_FILES['thumbnail'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $teacher_id = $_SESSION['client']['id'];
    $learning=$_POST['learning'];

    if(empty($learning)){
        echo json_encode([
            'success'=>false,
            'message'=>"error this is empty"
        ]);
        exit();
    }
    // Ensure categories and tags are arrays
    $categories = isset($_POST['categorie']) ? (array)$_POST['categorie'] : [];
    $tags = isset($_POST['tags']) ? (array)$_POST['tags'] : [];

    // Calculate duration from hours, minutes, seconds
    $duration = (
        (int)$_POST['duration_hours'] * 3600 + 
        (int)$_POST['duration_minutes'] * 60 + 
        (int)$_POST['duration_seconds']
    );

    // Create video handler instance
    $videoHandler = new VideoHandler();
    
    // Handle video upload first
    $uploadResult = $videoHandler->handleVideoUpload(
        $video,
        $thumbnail,
        $title,
        $description,
        $teacher_id,
        $duration
    );

    if ($uploadResult['success']) {
        $videoId = $uploadResult['video_id'];
        
        // Add categories
        if (!empty($categories)) {
            foreach ($categories as $categoryId) {
                $videoHandler->addCategoriestoved($videoId, $categoryId);
            }
        }
        
        // Add tags
        if (!empty($tags)) {
            foreach ($tags as $tagId) {
                $videoHandler->addTagstovd($videoId, $tagId);
            }
        }
        
        echo json_encode([
            'success' => true,
            'video_id' => $videoId,
            'message' => 'Video uploaded successfully'
        ]);
    } else {
        echo json_encode($uploadResult);
    }
     if (!empty($learning)) {
        foreach ($learning as $learn) {
            $videoHandler->addlearning($videoId, $learn, NULL);
        }
    }
    exit;
}
?>