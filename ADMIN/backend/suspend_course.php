<?php
session_start(); 
require_once '../../Classes/class_Admin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $coursId = $_POST['course_id']; 
    $type = $_POST['type']; 
    $role = $_SESSION['client']['role'];
    $sespend = new Admin();
            $sespend->suspendCourse($coursId,$type,$role);
}
?>
