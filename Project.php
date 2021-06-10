<?php
    session_start();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/mdb.min.css" type="text/css">
    <script src="js/mdb.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link rel="stylesheet" href="css/index.css" type="text/css">
</head>
<body>
    
<?php
require ('Components/Navbar.php');
$url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$x = pathinfo($url);
$selected = $x['filename'] ;
$_SESSION['page'] = $selected;
?>

<!-- Main Panel -->
<?php
if(isset($_POST['project'])){$_SESSION['project'] = $_POST['project'];}
$project = $_SESSION['project'];
?>
<div class="container-fluid">
    <div class="row">
        <div class="card col-4 m-3">
            <div class="card-body">
                <h5 class="card-title"><?php echo $project; ?></h5>
                <div class="row">
                    <div class="card-text" >
                    <?php
                        require('Modules/db.php');
                        
                        $stmt=$conn->prepare('SELECT * FROM projects WHERE name=?');
                        $stmt->bind_param('s', $project);
                        $stmt->execute();
                        $stmt->bind_result($id, $name, $start, $end, $deadline, $desc, $team_id);
                        $stmt->fetch();
                        echo '<p class="card-text">'.$start;
                        if($end>0) {
                            echo ' -- ' . $end;
                        }else {
                            echo ' -- ongoing</p>';
                        }
                        echo '<p class="card-text">' . $desc . '</p>';
                        echo '<p class="card-text">' . $team_id . '</p>';
                        $stmt->close();
                        
                    ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card col-4 m-3">
            <div class="card-body">
            <div class="row mb-3">
                <h5 class="card-title col-10">Tasks</h5><form class="col-2" method="POST" action="Create.php"><button type="submit" name="Add" value="Tasks" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i></i></button></form></div>
                <?php
                    $stmt=$conn->prepare('SELECT * FROM tasks WHERE project_id=?');
                    $stmt->bind_param('s', $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    echo '<div class="accordion accordion-flush" id="accordionExample">';
                    $i=0;
                    while ($row = $result->fetch_assoc()) {
                        $i++;
                            echo '
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading'.$i.'">
                                <button
                                    class="accordion-button collapsed"
                                    type="button"
                                    data-mdb-toggle="collapse"
                                    data-mdb-target="#collapse'.$i.'"
                                    aria-expanded="false"
                                    aria-controls="collapse'.$i.'"
                                >
                                    '. $row['name'] .'
                                </button>
                                </h2>
                                <div
                                id="collapse'.$i.'"
                                class="accordion-collapse collapse"
                                aria-labelledby="heading'.$i.'"
                                data-mdb-parent="#accordionExample"
                                >
                                <div class="accordion-body">
                                    '.$row['description'].'
                                </div>
                                </div>
                            </div>';
                    }
                    echo '</div>';
                    $stmt->close();

                ?>
            </div>
        </div>
        <div class="card col-3 m-3">
            <div class="card-body">
            <div class="row mb-3">
                <h5 class="card-title col-10">Task List</h5><form class="col-2" method="POST" action="Create.php"><button type="submit" name="Add" value="Task_List" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i></i></button></form></div>
                <?php
                    $stmt=$conn->prepare('SELECT * FROM tasks WHERE User_id = ?');
                    $stmt->bind_param('s', $_SESSION['ID']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    echo '<div class="accordion accordion-flush" id="Tasklist">';
                    while ($row = $result->fetch_assoc()) {
                        $i++;
                            echo '
                            <div class="row">
                            <div class="accordion-item col-10">
                                <h2 class="accordion-header" id="heading'.$i.'">
                                <button
                                    class="accordion-button collapsed"
                                    type="button"
                                    data-mdb-toggle="collapse"
                                    data-mdb-target="#collapse'.$i.'"
                                    aria-expanded="false"
                                    aria-controls="collapse'.$i.'"
                                >
                                    '. $row['name'] .'
                                </button>
                                </h2>
                                <div
                                id="collapse'.$i.'"
                                class="accordion-collapse collapse"
                                aria-labelledby="heading'.$i.'"
                                data-mdb-parent="#Tasklist"
                                >
                                <div class="accordion-body">
                                '.$row['description'].'
                                </div>
                                </div>
                            </div>
                            <form method="POST" action="Project.php" class="col-1 mt-3">
                                <button type="submit" class="btn btn-outline-danger btn-floating btn-sm" name="deltask" value="'. $row['ID'] .' ">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </form></div>';
                    }
                    echo '</div>';
                    $stmt->close();
                    if(isset($_POST['deltask'])) {
                        $set_id = $_POST['deltask'];
                        $stmt=$conn->prepare('DELETE FROM tasks WHERE ID = ?;');
                        $stmt->bind_param('s', $set_id);
                        $stmt->execute();
                        $stmt->close();
                        unset($set_id);
                        unset($_POST['deltask']);
                        echo "<meta http-equiv='refresh' content='0'>";
                    }

                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card col-2 m-3">
            <div class="card-body">
                <div class="row mb-2">
                <h5 class="card-title col-8">Notes</h5><form class="col-3" method="POST" action="Create.php"><button type="submit" name="Add" value="Notes" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i></button></form></div>
                <?php
                    $stmt=$conn->prepare('SELECT * FROM notes WHERE user_id = ?');
                    $stmt->bind_param('s', $_SESSION['ID']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    echo '<ul class="list-group list-group-flush">';
                    while ($row = $result->fetch_assoc()) {
                       
                            echo '<li class="list-group-item">
                            '. $row['note'].
                            '<form method="POST" action="Project.php" class="col-1 mt-3">
                            <button type="submit" class="btn btn-outline-danger btn-floating btn-sm" name="delnote" value="'. $row['ID'] .' ">
                                <i class="fas fa-minus"></i>
                            </button>
                        </form>
                        </li>';
                    }
                    echo '</ul>';
                    $stmt->close();
                    if(isset($_POST['delnote'])) {
                        $note_id = $_POST['delnote'];
                        $stmt=$conn->prepare('DELETE FROM notes WHERE ID = ?;');
                        $stmt->bind_param('s', $note_id);
                        $stmt->execute();
                        $stmt->close();
                        unset($note_id);
                        unset($_POST['delnote']);
                        echo "<meta http-equiv='refresh' content='0'>";
                    }
                ?>
            </div>
        </div>
        <div class="card col-5 m-3">
            <div class="card-body">
                <h5 class="card-title">Health</h5>
                <?php
                $date1 = date('Y-m-d');
                $stmt=$conn->prepare('SELECT start_date, deadline FROM projects WHERE Name = ? ');
                $stmt->bind_param('s', $name);
                $stmt->execute();
                $stmt->bind_result($start_date, $deadline);
                $stmt->fetch();
                $date2 = $deadline;
                require('Modules/datesubstr.php');
                $res1 = $result;
                $date1 = $start_date;
                $date2 = $deadline;
                require('Modules/datesubstr.php');
                $res2 = $result;
                $perc = (1 - ($res1/$res2))*100;
                $stmt->close(); 
                if($perc<'100') {
                echo substr($res1, 1, 10) . ' days left till deadline.'; 
                echo   '<div class="progress">
                            <div
                                class="progress-bar"
                                role="progressbar"
                                style="width: '.$perc.'%;"
                                aria-valuenow="10"
                                aria-valuemin="0"
                                aria-valuemax="100"
                            ></div>
                        </div><br>';
                }else {
                    echo substr($res1, 1, 10) . ' days past deadline.'; 
                    echo   '<div class="progress">
                            <div
                                class="progress-bar bg-danger"
                                role="progressbar"
                                style="width: '.$perc.'%;"
                                aria-valuenow="10"
                                aria-valuemin="0"
                                aria-valuemax="100"
                            ></div>
                        </div><br>';
                }
                $stmt=$conn->prepare('SELECT COUNT(ID) FROM tasks WHERE finished>0 AND project_id = ?;');
                $stmt->bind_param('s', $id);
                $stmt->execute();
                $stmt->bind_result($finished);
                $stmt->fetch();
                $stmt->close();
                $stmt=$conn->prepare('SELECT COUNT(ID) FROM tasks WHERE project_id = ?');
                $stmt->bind_param('s', $id);
                $stmt->execute();
                $stmt->bind_result($all);
                $stmt->fetch();
                $stmt->close();
                if($finished>0 && $all>0) {
                    $perc = ($finished/$all)*100;
                }else {
                    $perc = 0;
                }
                if($perc<100) {
                    echo substr($perc, 0, 2) . '% of tasks finished.';
                }else {
                    echo substr($perc, 0, 3) . '% of tasks finished.';
                }
                echo   '<div class="progress">
                            <div
                                class="progress-bar"
                                role="progressbar"
                                style="width: '.$perc.'%;"
                                aria-valuenow="10"
                                aria-valuemin="0"
                                aria-valuemax="100"
                            ></div>
                        </div><br>';
                ?>
            </div>
        </div>
    </div>
</div>
<!-- Main Panel -->



<!-- <div>Icons made by <a href="https://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div> -->
</body>
</html>