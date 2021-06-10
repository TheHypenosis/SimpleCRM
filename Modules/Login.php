<?php
session_start();
require('db.php');



$email = $_POST['Email'];
$passw = $_POST['passw'];

$stmt=$conn->prepare("SELECT ID FROM clients WHERE Email =? AND password = ?");
$stmt->bind_param('ss', $email, $passw);
$stmt->execute();
$stmt->bind_result($id);
$stmt->fetch();
if(isset($id)) {
    $_SESSION['ID'] = $row['ID'];
    header('Location:../Dashboard.php');
}else {
    header('Location:../Login.html');
}

$conn->close();
?>