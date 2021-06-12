<?php
//Connection to the database
require ('db.php');
//Assign the current projects name to $project
$project = $_POST['project'];
//Assign the selected Roles to $Role frome 1 to 5
$Role1= $_POST['Role1'];
$Role2= $_POST['Role2'];
$Role3= $_POST['Role3'];
$Role4= $_POST['Role4'];
$Role5= $_POST['Role5'];
//Assign the selected people to $person frome 1 to 5
$person1= $_POST['person1'];
$person2= $_POST['person2'];
$person3= $_POST['person3'];
$person4= $_POST['person4'];
$person5= $_POST['person5'];
// Generating a random 10 character token - ID
$ID =substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstvwxyz', 36)), 0, 10);
//SQL Query responsible for selecting the start the of the selected project
$stmt = $conn->prepare('SELECT start_date FROM projects WHERE name= ?');
$stmt->bind_param('s', $project);
$stmt->execute();
$stmt->bind_result($start_date);
$stmt->fetch();
$stmt->close();
//SQL Query responsible for creating a new team
$stmt = $conn->prepare("INSERT INTO teams(ID, project_name, project_start) VALUES (?, ?, ?);");
$stmt->bind_param('sss', $ID, $project, $start_date);
$stmt->execute();
$stmt->close();
//SQL Query responsible for updating selected project with the created team
$stmt=$conn->prepare(' UPDATE projects SET team_id=? WHERE name=?');
$stmt->bind_param('ss', $ID, $project);
$stmt->execute();
$stmt->close();
$f=0;
//Loop responsible for updating client table with the team & role that they were assigned to 
while($f<5) {
    switch($f) {
        case 0:
            //SQL Query responsible for updating client table with the team & role that they were assigned to
            $stmt = $conn->prepare("UPDATE clients SET role=?, team_id=?, project_id=? WHERE ID=?;");
            $stmt->bind_param('ssss', $Role1, $ID, $project_sql, $person1);
            $stmt->execute();
            //Increment $f so the next client row gets updated
            $f++;
            break;
        case 1:
            //SQL Query responsible for updating client table with the team & role that they were assigned to
            $stmt = $conn->prepare ("UPDATE clients SET role=?, team_id=?, project_id=? WHERE ID=?;");
            $stmt->bind_param('ssss', $Role2, $ID, $project_sql, $person2);
            $stmt->execute();
            //Increment $f so the next client row gets updated
            $f++;
            break;
        case 2:
            //SQL Query responsible for updating client table with the team & role that they were assigned to
            $stmt = $conn->prepare ("UPDATE clients SET role=?, team_id=?, project_id=? WHERE ID=?;");
            $stmt->bind_param('ssss', $Role3, $ID, $project_sql, $person3);
            $stmt->execute();
            //Increment $f so the next client row gets updated
            $f++;
            break;
        case 3:
            //SQL Query responsible for updating client table with the team & role that they were assigned to
            $stmt = $conn->prepare ("UPDATE clients SET role=?, team_id=?, project_id=? WHERE ID=?;");
            $stmt->bind_param('ssss', $Role4, $ID, $project_sql, $person4);
            $stmt->execute();
            //Increment $f so the next client row gets updated
            $f++;
            break;
        case 4:
            //SQL Query responsible for updating client table with the team & role that they were assigned to
            $stmt = $conn->prepare ("UPDATE clients SET role=?, team_id=?, project_id=? WHERE ID=?;");
            $stmt->bind_param('ssss', $Role5, $ID, $project_sql, $person5);
            $stmt->execute();
            break;
    }
}
//Redirect to Teams.php
header('Location:../Main/Teams.php');
$conn->close();
?>