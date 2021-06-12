<?php
//Connection to the database
require ('db.php');
//Assigning variables to $_POST variables from projectcreate.php
$name = $_POST['pname'];
$deadline = $_POST['deadline'];
$desc = $_POST['desc'];
// Generating a random 10 character token - ID
$ID =substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstvwxyz', 36)), 0, 10);
//Assigning $date to current date in Year-month-day format
$date = date('Y-m-d');
//SQL Query responsible for inserting values from projectcreate.php into the projects table
$stmt = $conn->prepare("INSERT INTO projects(ID, Name, start_date, deadline, Description) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param('sssss', $ID, $name, $date, $deadline, $desc);
$stmt->execute();
//Redirect to Projects.php
header('Location:../Projects.php');

$conn->close();
?>