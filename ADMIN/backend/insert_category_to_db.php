<?php
session_start(); 
require_once '../../Classes/class_category.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categorie = $_POST['categorie']; 
    var_dump($categorie);
    if (isset($categorie)) {
        foreach ($categorie as $value_tag) {
            var_dump($value_tag); 
            $user = new categorie($value_tag); 
            $user->set_categorie($value_tag); 
        }
    } else {
        echo "No categorie were submitted.";
    }

    // Optionally redirect after processing
    // header('location:../../index.php');
}
?>
