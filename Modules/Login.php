<?php
session_start();
require('db.php');



$email = $_POST['Email'];
$passw = $_POST['passw'];

$sql="SELECT ID FROM clients WHERE Email = '$email' AND password = '$passw'";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $ID = $row['ID'];
    if(!empty($ID)) {
        $_SESSION['ID'] = $row['ID'];
        header('Location:../Dashboard.php');
    }else{
        header('Location:../Login.html');
    }
    
}
$conn->close();
?>