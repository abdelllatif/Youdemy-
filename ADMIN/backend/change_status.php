<?php
require_once '../../Classes/class_ADMIN.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
        $id = $_POST['id_user'];
        $accept = $_POST['status_dessision'];
        $Admin= new Admin();
        $Admin -> suspendUser( $id,$accept);   
    } 

?>
