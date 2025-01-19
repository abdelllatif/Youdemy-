<?php
require_once '../../Classes/class_Admin.php';
session_start();

$data = new Admin();
$teachers = $data->Afficher_teacher();
$totalVideos = $data->getTotalVideos();
$totalDocuments = $data->getTotalDocuments();
$coursesByCategory = $data->getCoursesByCategory();
$topCourse = $data->getTopCourse();
$topTeachers = $data->getTopTeachers();
?>