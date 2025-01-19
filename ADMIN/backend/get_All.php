<?php
require_once '../../Classes/class_course_content.php';
require_once '../../Classes/class_category.php';
require_once '../../Classes/class_tags.php';
// Fetch all courses (videos and documents)
$videoHandler = new VideoHandler();
$courses = $videoHandler->afficher();

$documentHandler = new DocumentContent('', '', '');
$documents = $documentHandler->afficher();

// Fetch all categories
$categorieHandler = new categorie();
$categories = $categorieHandler->getCategories();

// Fetch all tags
$tagHandler = new Tag();
$tags = $tagHandler->gettags();
?>
