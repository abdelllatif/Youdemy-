<?php
session_start();
require_once '../../Classes/class_course_content.php';

if (isset($_POST['idved'])) {
    $ved_id = intval($_POST['idved']);
    $rejoindre = intval($_POST['rejoindre']);
    $user_id = isset($_SESSION['client']['id']) ? $_SESSION['client']['id'] : null;
    if ($rejoindre === 1 && $user_id && $_SESSION['client']['role'] === 'student') {
        var_dump($ved_id);
        var_dump($rejoindre);
        $documentContent = new VideoHandler('', '', 0);
        $message = $documentContent->enrollUser($user_id, $ved_id);
        header("location:../Frontend/vedio.php?iddoc=$ved_id");
    } else {
        $message = 'Invalid request or not logged in as student.';

    }
    exit();
} else {
    exit();
}
?>