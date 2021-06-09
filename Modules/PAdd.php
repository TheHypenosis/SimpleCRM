<?php
session_start();
require('db.php');
$var = $_POST['Add'];

$ID = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstvwxyz', 36)), 0, 10);;

$date = date('Y-m-d');
$project_name = $_SESSION['project'];
$stmt=$conn->prepare('SELECT ID from projects WHERE Name=?');
$stmt->bind_param('s', $project_name);
$stmt->execute();
$result = $stmt->get_result();
$value = $result->fetch_object();
$pid = $value->ID;
$uid = $_SESSION['ID'];

if(isset($_POST['pname'])){
    $name = $_POST['pname'];
}

$desc = $_POST['desc'];
$null = '';
switch ($var) {
    case 'Tasks':
        $stmt=$conn->prepare('INSERT INTO tasks (ID, name, description, created, project_id) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('sssss', $ID, $name, $desc, $date, $pid);
        $stmt->execute();
        $stmt->close();
        header('Location:../Project.php');
        break;
    case 'Task_List': 
        $stmt=$conn->prepare('INSERT INTO tasks (ID, name, description, created, User_id) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('sssss', $ID, $name, $desc, $date, $uid);
        $stmt->execute();
        $stmt->close();
        header('Location:../Project.php');
        break;
    case 'Notes':
        $stmt=$conn->prepare('INSERT INTO notes () VALUES (?, ?, ?, ?)') ;
        $stmt->bind_param('ssss', $ID, $uid, $desc, $date);
        $stmt->execute();
        $stmt->close();
        header('Location:../Project.php');
        break;
    default:
        echo 'Error';
        echo $_POST['Add'];
        break;
}

?>