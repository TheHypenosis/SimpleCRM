<?php
//Starting the session
session_start();
//Connection to the database
require('db.php');
//Assigning the variables from Login.html form
$email = $_POST['Email'];
$passw = $_POST['passw'];
//SQL Query responsible for validating if the email & password are valid
$stmt=$conn->prepare("SELECT ID FROM clients WHERE Email =? AND password = ?");
$stmt->bind_param('ss', $email, $passw);
$stmt->execute();
$stmt->bind_result($id);
$stmt->fetch();
//Checking if the output of the SQL query is set, if yes, set SESSION->ID and redirect to Dashboard.php, if not redirect back to Login.html
if(isset($id)) {
    $_SESSION['ID'] = $id;
    header('Location:../Dashboard.php');
}else {
    header('Location:../Login.html');
}
//Close the connection
$conn->close();
?>