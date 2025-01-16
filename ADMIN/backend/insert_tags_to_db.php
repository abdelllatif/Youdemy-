<?php
session_start(); 
require_once '../../Classes/class_tags.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Access the tags array correctly
    $tags = $_POST['tags']; // Use 'tags' instead of 'tags[]'
    var_dump($tags);
    // Check if $tags is set and is an array
    if (isset($tags) && is_array($tags)) {
        foreach ($tags as $value_tag) {
            var_dump($value_tag); // Debugging output
            $user = new Tag($value_tag); // Create a new Tag object with the individual tag
            $user->set_tags($value_tag); // Set the tag
        }
    } else {
        echo "No tags were submitted.";
    }

    // Optionally redirect after processing
    // header('location:../../index.php');
}
?>
