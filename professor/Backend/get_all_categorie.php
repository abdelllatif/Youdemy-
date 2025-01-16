<?php
require_once '../../Classes/class_tags.php';




$categories = new Tag();
$result2 = $categories->gettags();

if ($result2) {
    echo "Video uploaded successfully!";
} else {
    echo "Error: " ;
}