<?php
//Assign mysql server name
$servername = 'db';
//Assign mysql username
$username = 'root';
//Assign mysql usernames password
$password = '';
//Assign mysql servers database name
$dbname = 'spm';
//Connection to the database
$conn=new mysqli($servername, $username, $password, $dbname);
//If connection was not reached, end connection
if($conn->connect_error) {
    die('Oops! Something went wrong: ' . $conn->connect_error);
}
?>