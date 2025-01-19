<?php
require_once '../../Classes/class_ADMIN.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
        $id = $_POST['id_tech'];
        $accept = $_POST['approved_dessision'];
        $Admin= new Admin();
        $Admin -> validateTeacherAccount( $id,$accept);   
    } 

?>
