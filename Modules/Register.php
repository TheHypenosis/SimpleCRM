<?php
if(isset($_POST['name'])) {
    $name= $_POST['name'];
}
if(isset($_POST['surname'])) {
    $surname= $_POST['surname'];
}
if(isset($_POST['email'])) {
    $email= $_POST['email'];
}
if(isset($_POST['phone'])) {
    $phone= $_POST['phone'];
}
if(isset($_POST['passw'])) {
    $passw= $_POST['passw'];
}

header('Location: ./Dashboard.html');
?>