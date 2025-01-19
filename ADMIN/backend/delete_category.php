<?php
session_start(); 
require_once '../../Classes/class_category.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryId = $_POST['category_id']; 
    $delet = new categorie();
            $delet->deleteCategory($categoryId);
}
?>
