<?php
session_start(); 
require_once '../../Classes/class_user.php';
if($_SERVER['REQUEST_METHOD']==='POST'){

    if (isset($_SESSION['user'])) {
        $first_name = $_SESSION['user']['first_name'];
        $last_name = $_SESSION['user']['last_name'];
        $email = $_SESSION['user']['email'];
        $password = $_SESSION['user']['password'];
    } 
    var_dump($_SESSION['user']['first_name']);
    echo '<br>';
    var_dump($_SESSION['user'])     ;
var_dump($_POST['role']);
$role=$_POST['role']; 
$user= new user($first_name,$last_name,$email,$password,$role);
$user -> SetUser($first_name,$last_name,$email,$password,$role);
 header('location:../../index.php');

}

?>
