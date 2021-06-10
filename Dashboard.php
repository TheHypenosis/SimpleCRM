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
require ('Modules/db.php')
?>

<!-- Main Panel -->
<div class="container-fluid">
    <div class="row">
        <div class="card col-4 m-3">
            <div class="card-body">
                <h5 class="card-title">Progress</h5>
                <?php
                $stmt=$conn->prepare('SELECT DISTINCT P.name, P.ID FROM projects AS P, tasks AS T WHERE P.ID = T.project_id');
                $stmt->execute();
                $result = $stmt->get_result();
                $i = 0;
                echo '<table class="table">
                        <thead>
                            <tr>
                                <th>Nr.</th>
                                <th>Project Name</th>
                                <th>Completion</th>
                            </tr>
                        </thead>
                        <tbody>';
                while($row=$result->fetch_assoc()) {
                    $i++;
                    $pid = $row['ID'];
                    echo '<tr>
                    <td>' .$i. '</td>
                    <td>' .$row['name']. '</td>
                    <td>';
                    $stmt=$conn->prepare('SELECT COUNT(finished) FROM tasks WHERE finished>0 AND project_id = ?;');
                    $stmt->bind_param('s', $pid);
                    $stmt->execute();
                    $stmt->bind_result($finished);
                    $stmt->fetch();
                    $stmt->close();
                    $stmt=$conn->prepare('SELECT COUNT(ID) FROM tasks WHERE project_id IS NOT NULL');
                    $stmt->execute();
                    $stmt->bind_result($all);
                    $stmt->fetch();
                    $stmt->close();
                    $perc = (1 - ($finished/$all))*100;
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
                    echo '</tr>';
                }
                echo    '</tbody>
                    </table>';
                ?>  
            </div>
        </div>
        <div class="card col-4 m-3">
            <div class="card-body">
                <h5 class="card-title">Tasks</h5>
                <div class="container-flex d-flex align-items-center justify-content-center">
                    <i class="fas fa-brush text-primary me-2"></i> <span class="me-3"> - Ongoing </span>
                    <i class="fas fa-brush text-success me-2"></i> <span> - Completed</span>
                </div>
                    <?php
                        $stmt=$conn->prepare('SELECT COUNT(ID) FROM tasks WHERE project_id IS NOT NULL');
                        $stmt->execute();
                        $stmt->bind_result($query_full);
                        $stmt->fetch();
                        $stmt->close();
                        $stmt=$conn->prepare('SELECT COUNT(finished) FROM tasks WHERE finished IS NOT NULL AND project_id IS NOT NULL');
                        $stmt->execute();
                        $stmt->bind_result($done);
                        $stmt->fetch();
                        $stmt->close();
                        $stmt=$conn->prepare('SELECT COUNT(ID) FROM tasks WHERE finished IS NULL AND project_id IS NOT NULL');
                        $stmt->execute();
                        $stmt->bind_result($not_done);
                        $stmt->fetch();
                        $stmt->close();
                        $ongoing = ($not_done/$query_full)*100;
                        $completed = ($done/$query_full)*100;
                        echo '<div class="progress">
                        <div
                        class="progress-bar"
                        role="progressbar"
                        style="width: '.$ongoing.'%;"
                        aria-valuenow="15"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        ></div>
                        <div
                        class="progress-bar bg-success"
                        role="progressbar"
                        style="width: '.$completed.'%;"
                        aria-valuenow="30"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        ></div>
                        </div>';
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
                    $i = 0;
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
                <h5 class="card-title">Time</h5>
                <div class="container-flex d-flex align-items-center justify-content-center">
                    <i class="fas fa-brush text-primary me-2"></i> <span class="me-3"> - Ongoing </span>
                    <i class="fas fa-brush text-success me-2"></i> <span class="me-3"> - Completed</span>
                    <i class="fas fa-brush text-danger me-2"></i> <span> - Behind schedule</span>
                </div>
                <?php
                $date = date('Y-m-d');
                $stmt=$conn->prepare('SELECT COUNT(ID) FROM projects');
                $stmt->execute();
                $stmt->bind_result($all_projects);
                $stmt->fetch();
                $stmt->close();
                $stmt=$conn->prepare('SELECT COUNT(ID) FROM projects WHERE end_date IS NOT NULL');
                $stmt->execute();
                $stmt->bind_result($completed_projects);
                $stmt->fetch();
                $stmt->close();
                $stmt=$conn->prepare('SELECT COUNT(ID) FROM projects WHERE end_date IS NULL AND deadline>?');
                $stmt->bind_param('s', $date);
                $stmt->execute();
                $stmt->bind_result($ongoing_projects);
                $stmt->fetch();
                $stmt->close();
                $stmt=$conn->prepare('SELECT COUNT(ID) FROM projects WHERE deadline<?');
                $stmt->bind_param('s', $date);
                $stmt->execute();
                $stmt->bind_result($overdue_projects);
                $stmt->fetch();
                $stmt->close();
                $ongoingp = ($ongoing_projects/$all_projects)*100;
                $completedp = ($completed_projects/$all_projects)*100;
                $overduep = ($overdue_projects/$all_projects)*100;

                echo '<div class="progress">
                <div
                class="progress-bar"
                role="progressbar"
                style="width: '. $ongoingp .'%;"
                aria-valuenow="15"
                aria-valuemin="0"
                aria-valuemax="100"
                ></div>
                <div
                class="progress-bar bg-success"
                role="progressbar"
                style="width: '. $completedp .'%;"
                aria-valuenow="30"
                aria-valuemin="0"
                aria-valuemax="100"
                ></div>
                <div
                class="progress-bar bg-danger"
                role="progressbar"
                style="width: '. $overduep .'%;"
                aria-valuenow="30"
                aria-valuemin="0"
                aria-valuemax="100"
                ></div>
                </div>';
                ?>
        </div>
    </div>
</div>
<!-- Main Panel -->

<!-- <div>Icons made by <a href="https://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div> -->
</body>
</html>