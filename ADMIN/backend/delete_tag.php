<?php
session_start(); 
require_once '../../Classes/class_tags.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tagsId = $_POST['tag_id']; 
    $delet = new Tag();
            $delet->deleteTag($tagsId);
}
?>
