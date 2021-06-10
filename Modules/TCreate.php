<?php
$project = $_POST['project'];

$Role1= $_POST['Role1'];
$Role2= $_POST['Role2'];
$Role3= $_POST['Role3'];
$Role4= $_POST['Role4'];
$Role5= $_POST['Role5'];

$person1= $_POST['person1'];
$person2= $_POST['person2'];
$person3= $_POST['person3'];
$person4= $_POST['person4'];
$person5= $_POST['person5'];

require ('db.php');

$ID =substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstvwxyz', 36)), 0, 10);

$stmt = $conn->prepare('SELECT start_date FROM projects WHERE name= ?');
$stmt->bind_param('s', $project);
$stmt->execute();
$stmt->bind_result($start_date);
$stmt->fetch();
$stmt->close();
$stmt = $conn->prepare("INSERT INTO teams(ID, project_name, project_start) VALUES (?, ?, ?);");
$stmt->bind_param('sss', $ID, $project, $start_date);
$stmt->execute();
$stmt->close();
$stmt=$conn->prepare(' UPDATE projects SET team_id=? WHERE name=?');
$stmt->bind_param('ss', $ID, $project);
$stmt->execute();
$stmt->close();
$f=0;
while($f<5) {
    switch($f) {
        case 0:
            $stmt = $conn->prepare("UPDATE clients SET role=?, team_id=?, project_id=? WHERE ID=?;");
            $stmt->bind_param('ssss', $Role1, $ID, $project_sql, $person1);
            $stmt->execute();
            $f++;
            break;
        case 1:
            $stmt = $conn->prepare ("UPDATE clients SET role=?, team_id=?, project_id=? WHERE ID=?;");
            $stmt->bind_param('ssss', $Role2, $ID, $project_sql, $person2);
            $stmt->execute();
            $f++;
            break;
        case 2:
            $stmt = $conn->prepare ("UPDATE clients SET role=?, team_id=?, project_id=? WHERE ID=?;");
            $stmt->bind_param('ssss', $Role3, $ID, $project_sql, $person3);
            $stmt->execute();
            $f++;
            break;
        case 3:
            $stmt = $conn->prepare ("UPDATE clients SET role=?, team_id=?, project_id=? WHERE ID=?;");
            $stmt->bind_param('ssss', $Role4, $ID, $project_sql, $person4);
            $stmt->execute();
            $f++;
            break;
        case 4:
            $stmt = $conn->prepare ("UPDATE clients SET role=?, team_id=?, project_id=? WHERE ID=?;");
            $stmt->bind_param('ssss', $Role5, $ID, $project_sql, $person5);
            $stmt->execute();
            $f++;
            break;
    }
}

header('Location:../Teams.php');
$conn->close();
?>