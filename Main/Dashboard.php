<?php
//Starting the session
    session_start();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/mdb.min.css" type="text/css">
    <script src="../js/mdb.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link rel="stylesheet" href="../css/index.css" type="text/css">
</head>
<body>
<?php
//Loading navbar from Navbar.php
require ('../Components/Navbar.php');
//Connection to the database
require ('../Modules/db.php');
//Getting the name of the page and seting that to the SESSION->page variable
$url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$x = pathinfo($url);
$selected = $x['filename'] ;
$_SESSION['page'] = $selected;
//Assigniing SESSION->ID to a variable
$uid = $_SESSION['ID'];
?>

<!-- Main Panel -->
<div class="container-fluid">
    <div class="row">
        <div class="card col-4 m-3">
            <div class="card-body">
                <h5 class="card-title">Progress</h5>
                <?php
                //SQL Query responsible for Selecting Name and ID from projects table Where Project ID is equal to project_id column in tasks table
                $stmt=$conn->prepare('SELECT DISTINCT P.name, P.ID FROM projects AS P, tasks AS T WHERE P.ID = T.project_id');
                $stmt->execute();
                $result = $stmt->get_result();
                $i = 0;
                //Creating a table for the query results
                echo '<table class="table">
                        <thead>
                            <tr>
                                <th>Nr.</th>
                                <th>Project Name</th>
                                <th>Completion</th>
                            </tr>
                        </thead>
                        <tbody>';
                //Fetching query results in table rows and cells
                while($row=$result->fetch_assoc()) {
                    //Incrementing $i every loop action
                    $i++;
                    //Setting PID to project_id
                    $pid = $row['ID'];
                    echo '<tr>
                    <td>' .$i. '</td>
                    <td>' .$row['name']. '</td>
                    <td>';            
                    //SQL Query responsible for counting the amount of rows of finished tasks
                    $stmt=$conn->prepare('SELECT COUNT(ID) FROM tasks WHERE finished>0 AND project_id = ?;');
                    $stmt->bind_param('s', $pid);
                    $stmt->execute();
                    $stmt->bind_result($finished);
                    $stmt->fetch();
                    $stmt->close();
                    //SQL Query responsible for counting the amount of rows of all tasks
                    $stmt=$conn->prepare('SELECT COUNT(ID) FROM tasks WHERE project_id = ?');
                    $stmt->bind_param('s', $pid);
                    $stmt->execute();
                    $stmt->bind_result($all);
                    $stmt->fetch();
                    $stmt->close();
                    //Checking if there are more than 0 finished tasks
                    //If yes calculate the percentage of finished tasks 
                    //If no assign 0 to $perc
                    if($finished>0) {
                        $perc = ($finished/$all)*100;
                    }else {
                        $perc = 0;
                    }
                    //If percentage is lower than 100 crop the percentage to 2 characters
                    //If percentage is 100 crop it to 3 characters
                    if($perc<100) {
                        echo substr($perc, 0, 2) . '% of tasks finished.';
                    }else {
                        echo substr($perc, 0, 3) . '% of tasks finished.';
                    }
                    //Progress bar with $perc as indicator to how much width does the progress bar have
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
                    <!-- Progress bar color description -->
                    <i class="fas fa-brush text-primary me-2"></i> <span class="me-3"> - Ongoing </span>
                    <i class="fas fa-brush text-success me-2"></i> <span> - Completed</span>
                </div>
                    <?php
                        //SQL Query responsible for couting the amount of rows of all projects tasks
                        $stmt=$conn->prepare('SELECT COUNT(ID) FROM tasks WHERE project_id IS NOT NULL');
                        $stmt->execute();
                        $stmt->bind_result($query_full);
                        $stmt->fetch();
                        $stmt->close();
                        //SQL Query responsible for couting the amount of rows where project tasks are finished
                        $stmt=$conn->prepare('SELECT COUNT(finished) FROM tasks WHERE finished IS NOT NULL AND project_id IS NOT NULL');
                        $stmt->execute();
                        $stmt->bind_result($done);
                        $stmt->fetch();
                        $stmt->close();
                        //SQL Query responsible for counting the amount of rows where project tasks are not finished
                        $stmt=$conn->prepare('SELECT COUNT(ID) FROM tasks WHERE finished IS NULL AND project_id IS NOT NULL');
                        $stmt->execute();
                        $stmt->bind_result($not_done);
                        $stmt->fetch();
                        $stmt->close();
                        //Calculate the percentage of tasks not completed and completed
                        $ongoing = ($not_done/$query_full)*100;
                        $completed = ($done/$query_full)*100;
                        //Progress bar with $perc as indicator to how much width does the progress bar have
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
                <h5 class="card-title col-10">Task List</h5>
                <!-- Buton that redirects to Create.php -->
                <form class="col-2" method="POST" action="Create.php">
                <button type="submit" name="Add" value="Task_List" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i></i></button>
                </form>
            </div>
                <?php     
                    //SQL Query responsible for selecting everything from tasks where User_id = current session['id']
                    $stmt=$conn->prepare('SELECT * FROM tasks WHERE User_id = ?');
                    $stmt->bind_param('s', $uid);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    //Starting accordion
                    echo '<div class="accordion accordion-flush" id="Tasklist">';
                    $i = 0;
                    //Fetching query results in accordion items
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
                            </div>';
                            //Button responsible for deleting the user task that is next to it
                            echo '<form method="POST" action="Dashboard.php" class="col-1 mt-3">
                                <button type="submit" class="btn btn-outline-danger btn-floating btn-sm" name="deltask" value="'. $row['ID'] .' ">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </form></div>';
                    }
                    echo '</div>';
                    $stmt->close();
                    //If deltask is assigned(button is clicked)
                    if(isset($_POST['deltask'])) {
                        $set_id = $_POST['deltask'];
                        //SQL Query responsible for Deleting a task with set ID
                        $stmt=$conn->prepare('DELETE FROM tasks WHERE ID = ?;');
                        $stmt->bind_param('s', $set_id);
                        $stmt->execute();
                        $stmt->close();
                        unset($set_id);
                        unset($_POST['deltask']);
                        //Refresh the page
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
                <h5 class="card-title col-8">Notes</h5>
                    <!-- Buton that redirects to Create.php -->
                    <form class="col-3" method="POST" action="Create.php">
                        <button type="submit" name="Add" value="Notes" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i></button>
                    </form>
                </div>
                <?php
                    //SQL Query responsible for selecting everything from notes where User_id = current session['id']
                    $stmt=$conn->prepare('SELECT * FROM notes WHERE user_id = ?');
                    $stmt->bind_param('s', $uid);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    echo '<ul class="list-group list-group-flush">';
                    //Fetching query results in style list elements
                    while ($row = $result->fetch_assoc()) {
                       
                            echo '<li class="list-group-item">
                            '. $row['note'];         
                            //Button responsible for deleting the user note that is next to it
                            echo '<form method="POST" action="Dashboard.php" class="col-1 mt-3">
                            <button type="submit" class="btn btn-outline-danger btn-floating btn-sm" name="delnote" value="'. $row['ID'] .' ">
                                <i class="fas fa-minus"></i>
                            </button>
                        </form>
                        </li>';
                    }
                    echo '</ul>';
                    $stmt->close();
                    //If delnote is assigned(button is clicked)
                    if(isset($_POST['delnote'])) {
                        $note_id = $_POST['delnote'];
                        //SQL Query responsible for Deleting a note with set ID
                        $stmt=$conn->prepare('DELETE FROM notes WHERE ID = ?;');
                        $stmt->bind_param('s', $note_id);
                        $stmt->execute();
                        $stmt->close();
                        unset($note_id);
                        unset($_POST['delnote']);
                        //Refresh the page
                        echo "<meta http-equiv='refresh' content='0'>";
                    }
                ?>
            </div>
        </div>
        <div class="card col-5 m-3">
            <div class="card-body">
                <h5 class="card-title">Time</h5>
                <!-- Progress bar color description -->
                <div class="container-flex d-flex align-items-center justify-content-center">
                    <i class="fas fa-brush text-primary me-2"></i> <span class="me-3"> - Ongoing </span>
                    <i class="fas fa-brush text-success me-2"></i> <span class="me-3"> - Completed</span>
                    <i class="fas fa-brush text-danger me-2"></i> <span> - Behind schedule</span>
                </div>
                <?php
                //Assigning $date to current date in Year-month-day format
                $date = date('Y-m-d');
                //SQL Query responsible for counting every row in projets table
                $stmt=$conn->prepare('SELECT COUNT(ID) FROM projects');
                $stmt->execute();
                $stmt->bind_result($all_projects);
                $stmt->fetch();
                $stmt->close();
                //SQL Query responsible for couting the amount of rows where projects are finished
                $stmt=$conn->prepare('SELECT COUNT(ID) FROM projects WHERE end_date IS NOT NULL');
                $stmt->execute();
                $stmt->bind_result($completed_projects);
                $stmt->fetch();
                $stmt->close();
                //SQL Query responsible for couting the amount of rows where projects are ongoing and current date is before deadline
                $stmt=$conn->prepare('SELECT COUNT(ID) FROM projects WHERE end_date IS NULL AND deadline>?');
                $stmt->bind_param('s', $date);
                $stmt->execute();
                $stmt->bind_result($ongoing_projects);
                $stmt->fetch();
                $stmt->close();
                //SQL Query responsible for couting the amount of rows where projects are ongoing and current date is past deadline
                $stmt=$conn->prepare('SELECT COUNT(ID) FROM projects WHERE deadline<?');
                $stmt->bind_param('s', $date);
                $stmt->execute();
                $stmt->bind_result($overdue_projects);
                $stmt->fetch();
                $stmt->close();
                //Count percentage of ongoing projects
                $ongoingp = ($ongoing_projects/$all_projects)*100;
                //Count percentage of completed projects
                $completedp = ($completed_projects/$all_projects)*100;
                //Count percentage of overdue projects
                $overduep = ($overdue_projects/$all_projects)*100;
                //Progress bars with variables as indicator to how much width does the progress bar have
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
</body>
</html>