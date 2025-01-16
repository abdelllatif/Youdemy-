<?php
session_start(); 
require_once '../../Classes/class_user.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
        $email = $_POST['email'];
        $password = $_POST['password'];
        user::login($email,$password);
    } 

?>
