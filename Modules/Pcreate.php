<?php

$name = $_POST['pname'];
$deadline = $_POST['deadline'];
$desc = $_POST['desc'];

require ('db.php');

$ID =substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstvwxyz', 36)), 0, 10);

$date = date('Y-m-d');

$stmt = $conn->prepare("INSERT INTO projects(ID, Name, start_date, deadline, Description) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param('sssss', $ID, $name, $date, $deadline, $desc);
$stmt->execute();

header('Location:../Projects.php');

$conn->close();
?>