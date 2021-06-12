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
    <link rel="stylesheet" href="css/mdb.min.css" type="text/css">
    <script src="js/mdb.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link rel="stylesheet" href="css/index.css" type="text/css">
</head>
<body>
<?php
//Loading navbar from Navbar.php
require('Components/Navbar.php');
//Connection to the database
require('Modules/db.php');
//Getting the name of the page and seting that to the SESSION->page variable
$url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$x = pathinfo($url);
$selected = $x['filename'] ;
//Assigniing SESSION->ID to a variable
$_SESSION['page'] = $selected;
?>
<!-- Main Panel -->
<?php
//If $_POST['project'] from projects.php is set, set this value to $_SESSION['project']
if(isset($_POST['project'])){$_SESSION['project'] = $_POST['project'];}
//Assign $project to current project
$project = $_SESSION['project'];
?>
<div class="container-fluid">
    <div class="row">
        <div class="card col-4 m-3">
            <div class="card-body">
                <!-- echo the name of the project in the card title field -->
                <h5 class="card-title"><?php echo $project; ?></h5>
                <div class="row">
                    <div class="card-text" >
                    <?php
                        //SQL Query responsible for selecting everything from projects where name is current projects name
                        $stmt=$conn->prepare('SELECT * FROM projects WHERE name=?');
                        $stmt->bind_param('s', $project);
                        $stmt->execute();
                        $stmt->bind_result($id, $name, $start, $end, $deadline, $desc, $team_id);
                        $stmt->fetch();
                        //Start card-text paragraph class, and echo the project start date
                        echo '<p class="card-text">'.$start;
                        //If the projects has ended, echo the end date
                        //If project is ongoing, echo ongoing
                        if($end>0) {
                            echo ' -- ' . $end;
                        }else {
                            echo ' -- ongoing</p>';
                        }
                        //Echo the projects description
                        echo '<p class="card-text">' . $desc . '</p>';
                        //Echo the assigned team to this project
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
                <h5 class="card-title col-10">Tasks</h5>
                    <!-- Buton that redirects to Create.php -->
                    <form class="col-2" method="POST" action="Create.php">
                        <button type="submit" name="Add" value="Tasks" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i></i></button>
                    </form>
            </div>
                <?php
                    //SQL Query responsible for selecting everything from tasks where project_id = current selected project
                    $stmt=$conn->prepare('SELECT * FROM tasks WHERE project_id=?');
                    $stmt->bind_param('s', $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    //Starting the accordion
                    echo '<div class="accordion accordion-flush" id="accordionExample">';
                    $i=0;
                    //Fetching query results in accordion items
                    while ($row = $result->fetch_assoc()) {
                        $i++;
                            //Incrementing $i so every other while loop object will have incremented value
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
                <h5 class="card-title col-10">Task List</h5>
                    <!-- Buton that redirects to Create.php -->
                    <form class="col-2" method="POST" action="Create.php">
                        <button type="submit" name="Add" value="Task_List" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i></i></button>
                    </form>
            </div>
                <?php
                    //SQL Query responsible for selecting everything from tasks where User_id = current user
                    $stmt=$conn->prepare('SELECT * FROM tasks WHERE User_id = ?');
                    $stmt->bind_param('s', $_SESSION['ID']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    //Starting the accordion
                    echo '<div class="accordion accordion-flush" id="Tasklist">';
                    //Fetching query results in accordion items
                    while ($row = $result->fetch_assoc()) {
                        $i++;
                            //Incrementing $i so every other while loop object will have incremented value
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
                            echo '
                            <form method="POST" action="Project.php" class="col-1 mt-3">
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
                    $stmt->bind_param('s', $_SESSION['ID']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    echo '<ul class="list-group list-group-flush">';
                    //Fetching query results in style list elements
                    while ($row = $result->fetch_assoc()) {
                       
                            echo '<li class="list-group-item">
                            '. $row['note'];
                            //Button responsible for deleting the user note that is next to it
                            echo '<form method="POST" action="Project.php" class="col-1 mt-3">
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
                <h5 class="card-title">Health</h5>
                <?php
                //Assigning $date1 to current date in Year-month-day format
                $date1 = date('Y-m-d');
                //SQL Query responsible for selecting start date and deadline from projects where name = current project name
                $stmt=$conn->prepare('SELECT start_date, deadline FROM projects WHERE Name = ? ');
                $stmt->bind_param('s', $name);
                $stmt->execute();
                $stmt->bind_result($start_date, $deadline);
                $stmt->fetch();
                //Assigning $date2 to current project deadline
                $date2 = $deadline;
                //Datesubstr takes $date1 & $date2 and substracts the dates
                require('Modules/datesubstr.php');
                //Binding $res1 to the result of date substraction
                $res1 = $result;
                //Assigning $date1 to current projects start date
                $date1 = $start_date;
                //Assigning $date2 to current project deadline
                $date2 = $deadline;
                //Datesubstr takes $date1 & $date2 and substracts the dates
                require('Modules/datesubstr.php');
                //Binding $res2 to the result of date substraction
                $res2 = $result;
                //Calculating the percentage of days left until deadline is met
                $perc = (1 - ($res1/$res2))*100;
                $stmt->close(); 
                //If $perc is lower than 100 than echo the amount of days left until deadline
                //If $perc is higher or equal to 100 than echo amount of days that passed since deadline
                if($perc<'100') {
                echo substr($res1, 1, 10) . ' days left till deadline.'; 
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
                }else {
                    echo substr($res1, 1, 10) . ' days past deadline.'; 
                    //Progress bar with $perc as indicator to how much width does the progress bar have
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
                //SQL Query responsible for counting rows from current projects finished tasks
                $stmt=$conn->prepare('SELECT COUNT(ID) FROM tasks WHERE finished>0 AND project_id = ?;');
                $stmt->bind_param('s', $id);
                $stmt->execute();
                $stmt->bind_result($finished);
                $stmt->fetch();
                $stmt->close();
                //SQL Query responsible for counting rows from current projects tasks
                $stmt=$conn->prepare('SELECT COUNT(ID) FROM tasks WHERE project_id = ?');
                $stmt->bind_param('s', $id);
                $stmt->execute();
                $stmt->bind_result($all);
                $stmt->fetch();
                $stmt->close();
                //If both queries values are higher than 0 than calculate the percentage of finished tasks
                //If not assign $perc = 0
                if($finished>0 && $all>0) {
                    $perc = ($finished/$all)*100;
                }else {
                    $perc = 0;
                }
                //If $perc is lower than 100 than crop the $perc value to first 2 characters
                //If $perc is higher or equal to 100 than crop the $perc value to first 3 characters
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
                ?>
            </div>
        </div>
    </div>
</div>
<!-- Main Panel -->
</body>
</html>