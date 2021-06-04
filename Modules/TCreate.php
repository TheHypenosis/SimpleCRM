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
$result  = $stmt->get_result();
$value = $result->fetch_object();

$sql_team = "INSERT INTO teams(ID, project_name, project_start) VALUES ('$ID', '$project', '$value->start_date');";
echo $ID, $project, $value->start_date;
$conn->query($sql_team);

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


$conn->close();
?>