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
require('db.php');

$conn=new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error) {
    die('Oops! Something went wrong: ' . $conn->connect_error);
}

$sql= "INSERT INTO clients (name, surname, Email, phone_number, password) VALUES ('$name', '$surname', '$email', '$phone', '$passw')";

$conn->close();

header('Location: ./Dashboard.html');
?>