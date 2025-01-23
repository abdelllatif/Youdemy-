<?php

require_once '../../Classes/class_course_content.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['document_title'];
    $description = $_POST['document_description'];
    $teacherId = 2; 
    $categories = isset($_POST['categorie']) ? (array)$_POST['categorie'] : [];
    $tags = isset($_POST['tags']) ? (array)$_POST['tags'] : [];
    $documentFile = $_FILES['document'];
    $learning=$_POST['learning'];

 
    var_dump($title);
    echo "<br>";
    var_dump($description);
    echo "<br>";
    var_dump($documentFile);
    echo "<br>";
    var_dump($teacherId);
    echo "<br>";
    var_dump($categories);
    echo "<br>";
    var_dump($tags);  
  echo "<br>";

  echo "$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$";
  var_dump($learning);
  echo "$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$";
  if(empty($learning)){
      echo json_encode([
          'success'=>false,
          'message'=>"error this is empty"
      ]);
      exit();
  }
    $documentHandler = new DocumentContent($title, $description, $teacherId);

    $uploadResult = $documentHandler->uploadFile($documentFile);

    if (is_array($uploadResult) && $uploadResult['success']) {
        $documentId = $uploadResult['document_id'];

        if (!empty($categories)) {
            foreach ($categories as $categoryId) {
                $documentHandler->addCategoriestodoc($documentId, $categoryId);
            }
        }

        if (!empty($tags)) {
            foreach ($tags as $tagId) {
                $documentHandler->addTagstodoc($documentId, $tagId);
            }
        }
        if (!empty($learning)) {
            foreach ($learning as $learn) {
                $documentHandler->addlearning($documentId, $learn);
            }
        }

        echo "Document uploaded and details saved successfully!";
    } else {
        echo "Error: " . $uploadResult;
    }
}
?>