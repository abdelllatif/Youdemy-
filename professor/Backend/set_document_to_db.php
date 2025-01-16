<?php
session_start();
require_once '../../Classes/class_course_content.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST')
 {
$title = $_POST['document_title']; 
$documentfile = $_FILES['document'] ?? null;
$description = $_POST['document_description'];  
$teacher_id = $_SESSION['client']['id'];
echo "<br>";
var_dump($title);
echo "<br>";
var_dump($description);
echo "<br>";
var_dump($documentfile);
echo "<br>";
var_dump($teacher_id);
$document = new DocumentContent($title, $description, $teacher_id,$documentfile);  
$resultMessage = $document->uploadFile($documentfile); 
 }
else{
    echo $resultMessage['message']; 
}
