<?php
session_start();
require_once '../../Classes/class_course_content.php';
require_once '../../Classes/class_database_connexion.php';

if (isset($_POST['iddoc'])) {
    $document_id = intval($_POST['iddoc']);
    $rejoindre = intval($_POST['rejoindre']);


    // Retrieve user ID from session
    $user_id = isset($_SESSION['client']['id']) ? $_SESSION['client']['id'] : null;

    if ($rejoindre === 1 && $user_id && $_SESSION['client']['role'] === 'student') {
        // Create DocumentContent instance and enroll the user
        var_dump($document_id);
var_dump($rejoindre);
        $documentContent = new DocumentContent('', '', 0);
        $message = $documentContent->enrollUser($user_id, $document_id);
        header("location:../Frontend/course-details.php?iddoc=$document_id");
    } else {
        $message = 'Invalid request or not logged in as student.';
    }

    // Redirect to the course details page with the document ID
    exit();
} else {
    // If the document ID is not received, redirect to the courses page
    exit();
}
?>