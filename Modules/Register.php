<?php
//Starting the session
session_start();
//Checking if form inputs from Register.html are set and than assigning them to variables
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
// Generating a random 10 character token - ID
$ID =substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstvwxyz', 36)), 0, 10);
// Connection to the database
require('db.php');
//SQL Query responsible for creating a new client in the clients table in the database
$stmt=$conn->prepare ("INSERT INTO clients (ID, name, surname, Email, phone_number, password) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param('ssssss', $ID, $name, $surname, $email, $phone, $passw);
//Checking if the statement was executed, if yes assign the SESSION->ID and redirect to Dashboard.php, if not print error
if ($stmt->execute()) {
    $_SESSION['ID'] = $ID;
    header('Location:../Dashboard.php');
} else {
   echo $stmt->error;
}
//Closing the statemnt and the db connection
$stmt->close();
$conn->close();


?>