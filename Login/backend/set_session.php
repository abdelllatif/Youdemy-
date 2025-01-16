<?php
session_start(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if($verifier_password =$_POST['verifier_password']){
    $_SESSION['user'] = [
        'first_name' => $_POST['FirstName'],
        'last_name' => $_POST['LastName'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
    ];
var_dump($_SESSION['user'])     ;
    header('Location:../frontend/chose.php');
    exit();
  }


}
?>
