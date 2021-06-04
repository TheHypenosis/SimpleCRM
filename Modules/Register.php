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

$ID =substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstvwxyz', 36)), 0, 10);


$sql= "INSERT INTO clients (ID, name, surname, Email, phone_number, password) VALUES ('$ID', '$name', '$surname', '$email', '$phone', '$passw')";

if ($conn->query($sql)===TRUE) {
    header('Location:../Dashboard.php');
}else{
    echo 'Error ' . $sql . '<br>' . $conn->error;
}

$conn->close();


?>