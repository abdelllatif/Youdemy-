<?php
session_start();
require_once '../../Classes/class_course_content.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $video = $_FILES['video'] ?? null;
    $thumbnail = $_FILES['thumbnail'] ?? null;
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $duration_hours = $_POST['duration_hours'] ?? 0; // Get the duration hours from the form
    $duration_minutes = $_POST['duration_minutes'] ?? 0; // Get the duration minutes from the form
    $duration_seconds = $_POST['duration_seconds'] ?? 0; // Get the duration seconds from the form
    $teacher_id = $_SESSION['client']['id']; // Get teacher_id from session
    
    $duration = ($duration_hours * 3600) + ($duration_minutes * 60) + $duration_seconds;

    $categories = isset($_POST['categorieselect']) ? (array)$_POST['categorieselect'] : [];
    $tags = isset($_POST['tagsselect']) ? (array)$_POST['tagsselect'] : [];

    if (!$video || !$thumbnail || empty($title) || empty($description) || $duration <= 0) {
        echo "Error: All fields are required and duration must be greater than 0.";
        exit;
    }

    $videoHandler = new VideoHandler();
    $result = $videoHandler->handleVideoUpload($video, $thumbnail, $title, $description, $teacher_id, $categories, $tags, $duration);

    if ($result['success']) {
        header('Location: ../Frontend/teacher_profile.php?success=1');
        exit;
    } else {
        echo "Error: " . $result['message'];
        exit;
    }
}
?>