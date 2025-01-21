<?php
require_once '../../classes/class_course_content.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $video_id = isset($_POST['video_id']) ? (int)$_POST['video_id'] : 0;
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $categorie = isset($_POST['categorie']) ? (int)$_POST['categorie'] : 0;
    $tags = isset($_POST['tags']) ? $_POST['tags'] : [];
    $learning = isset($_POST['learning']) ? $_POST['learning'] : [];

    $videoHandler = new VideoHandler();

    // Handle video file upload
    $videoPath = '';
    if (!empty($_FILES['video']['name'])) {
        $videoTmpName = $_FILES['video']['tmp_name'];
        $videoName = time() . '_' . $_FILES['video']['name'];
        $uploadDir = '../../uploads/videos/';
        $videoPath = $uploadDir . $videoName;
        move_uploaded_file($videoTmpName, $videoPath);
    } else {
        $existingVideo = $videoHandler->afficherbyid($video_id);
        $videoPath = $existingVideo['video_path'] ?? '';
    }

    // Handle thumbnail upload
    $thumbnailPath = '';
    if (!empty($_FILES['thumbnail']['name'])) {
        $thumbnailTmpName = $_FILES['thumbnail']['tmp_name'];
        $thumbnailName = time() . '_' . $_FILES['thumbnail']['name'];
        $uploadDir = '../../uploads/thumbnails/';
        $thumbnailPath = $uploadDir . $thumbnailName;
        move_uploaded_file($thumbnailTmpName, $thumbnailPath);
    } else {
        $existingVideo = $videoHandler->afficherbyid($video_id);
        $thumbnailPath = $existingVideo['thumbnail_path'] ?? '';
    }
    var_dump($video_id);
    var_dump($description);
    var_dump($videoPath);
    var_dump($thumbnailPath);
    echo "<br>";
    var_dump($categorie);
    echo $categorie;
    echo "<br>";
    
    foreach($tags as $tag){
        var_dump($tag);
    }
    echo "<br>";
    
    // Update video in database
    $teacherId = 1; // Exemple de valeur, remplacez par l'ID réel de l'enseignant
    if ($videoHandler->updateVideo(
            $video_id, 
            $title, 
            $description, 
            $teacherId, 
            $videoPath, 
            $thumbnailPath, 
            null, // ou une durée si vous en avez une
            $tags, 
            $categorie
        )) {
        exit();
    } else {
        echo '<p class="text-red-500">Échec de la mise à jour de la vidéo. Veuillez réessayer.</p>';
    }
}
?>
