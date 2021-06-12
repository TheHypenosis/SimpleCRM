<?php
//Starting the session
session_start();
//Connection to the database
require('db.php');
//Assigning a $_POST value from Create.php
$var = $_POST['Add'];
// Generating a random 10 character token - ID
$ID = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstvwxyz', 36)), 0, 10);;
//Assigning $date to current date in Year-month-day format
$date = date('Y-m-d');
//Assigning current projects name into a variable
$project_name = $_SESSION['project'];
//SQL Query responsible for selecting ID from projects table where projects name = current project name
$stmt=$conn->prepare('SELECT ID from projects WHERE Name=?');
$stmt->bind_param('s', $project_name);
$stmt->execute();
$result = $stmt->get_result();
$value = $result->fetch_object();
//Fetching query result into a variable
$pid = $value->ID;
//Assigning User ID into a variable
$uid = $_SESSION['ID'];
//If task name(pname) is set than assign Task name to $name
if(isset($_POST['pname'])){
    $name = $_POST['pname'];
}
//Assign the page name from where the Create button was clicked to a variable
$selected = $_SESSION['page'];
//Assign the note/task description to a variable
$desc = $_POST['desc'];
//Depending on the Create button clicked Tasks/Task_List/Note will be created
switch ($var) {
    case 'Tasks':
        //SQL Query responsible for insterting a project task into the task table
        $stmt=$conn->prepare('INSERT INTO tasks (ID, name, description, created, project_id) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('sssss', $ID, $name, $desc, $date, $pid);
        $stmt->execute();
        $stmt->close();
        //Redirect to the page name from where the Create button was clicked
        header('Location:../Main/'.$selected.'.php');
        break;
    case 'Task_List': 
        //SQL Query responsible for insterting a user task into the task table
        $stmt=$conn->prepare('INSERT INTO tasks (ID, name, description, created, User_id) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('sssss', $ID, $name, $desc, $date, $uid);
        $stmt->execute();
        $stmt->close();
        //Redirect to the page name from where the Create button was clicked
        header('Location:../Main/'.$selected.'.php');
        break;
    case 'Notes':
        //SQL Query responsible for insterting a note into the notes table
        $stmt=$conn->prepare('INSERT INTO notes () VALUES (?, ?, ?, ?)') ;
        $stmt->bind_param('ssss', $ID, $uid, $desc, $date);
        $stmt->execute();
        $stmt->close();
        //Redirect to the page name from where the Create button was clicked
        header('Location:../Main/'.$selected.'.php');
        break;
    default:
        echo 'Error';
        break;
}

?>