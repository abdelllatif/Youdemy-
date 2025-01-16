<?php
require_once '../../Classes/class_category.php';




$categories = new categorie();
$result = $categories->getCategories();

if ($result) {
    echo "Video uploaded successfully!";
} else {
    echo "Error: " ;
}