<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'spm';

$conn=new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error) {
    die('Oops! Something went wrong: ' . $conn->connect_error);
}
?>