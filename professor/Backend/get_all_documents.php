<?php
session_start();
require_once '../../Classes/class_course_content.php';

$course_content= new DocumentContent(0,0,0,0);
$documents = $course_content->getTeacherDocuments($_SESSION['client']['id']);
$ved_content= new VideoHandler(0,0,0,0);
$videos=$ved_content->getTeacherVideos($_SESSION['client']['id']);

?>