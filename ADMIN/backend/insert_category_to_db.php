<?php
session_start(); 
require_once '../../Classes/class_category.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Access the categorie array correctly
    $categorie = $_POST['categorie']; // Use 'categorie' instead of 'categorie[]'
    var_dump($categorie);
    // Check if $categorie is set and is an array
    if (isset($categorie)) {
        foreach ($categorie as $value_tag) {
            var_dump($value_tag); // Debugging output
            $user = new categorie($value_tag); // Create a new Tag object with the individual tag
            $user->set_categorie($value_tag); // Set the tag
        }
    } else {
        echo "No categorie were submitted.";
    }

    // Optionally redirect after processing
    // header('location:../../index.php');
}
?>
