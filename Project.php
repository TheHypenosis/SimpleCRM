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
</head>
<body>
    
<?php
require ('Components/Navbar.php');
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
                        $stmt->bind_result($id, $name, $start, $end, $deadline, $desc, $team_id, $group_id);
                        $stmt->fetch();
                        echo '<p class="card-text">'.$start;
                        if($end>0) {
                            echo ' -- ' . $end;
                        }else {
                            echo ' -- ongoing</p>';
                        }
                        echo '<p class="card-text">' . $desc . '</p>';
                        echo '<p class="card-text">' . $team_id . '</p>';
                        echo $_SESSION['project'];
                        $stmt->close();
                        
                    ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card col-4 m-3">
            <div class="card-body">
            <div class="row mb-3">
                <h5 class="card-title col-10">Tasks</h5><button class="btn btn-secondary btn-sm col-2"><i class="fas fa-plus"></i></i></button></div>
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
                <h5 class="card-title col-10">Task List</h5><button class="btn btn-secondary btn-sm col-2"><i class="fas fa-plus"></i></i></button></div>
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
                            <form method="POST" action="Project.php" class="col-1 mt-3"><button type="submit" class="btn btn-outline-danger btn-floating btn-sm" value="'. $row['ID'] .' "><i class="fas fa-minus"></i></button></form></div>';
                    }
                    echo '</div>';
                    $stmt->close();

                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card col-2 m-3">
            <div class="card-body">
                <div class="row mb-2">
                <h5 class="card-title col-8">Notes</h5><button class="btn btn-secondary btn-sm col-3"><i class="fas fa-plus"></i></button></div>
                <?php
                    $stmt=$conn->prepare('SELECT * FROM notes WHERE user_id = ?');
                    $stmt->bind_param('s', $_SESSION['ID']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    echo '<ul class="list-group list-group-flush">';
                    while ($row = $result->fetch_assoc()) {
                       
                            echo '<li class="list-group-item">
                            '. $row['note'].'<button class="btn btn-outline-danger btn-floating btn-sm" ><i class="fas fa-minus"></i></button>
                        </li>';
                    }
                    echo '</ul>';
                    $stmt->close();

                ?>
            </div>
        </div>
        <div class="card col-5 m-3">
            <div class="card-body">
                <h5 class="card-title">Health</h5>
                <p class="card-text">
                    Some quick example text to build on the card title and make up the bulk of the
                    card's content.
                </p>
            </div>
        </div>
        <div class="card col-4 m-3">
            <div class="card-body">
                <h5 class="card-title">Time</h5>
                <p class="card-text">
                    Some quick example text to build on the card title and make up the bulk of the
                    card's content.
                </p>
            </div>
        </div>
    </div>
</div>
<!-- Main Panel -->



<!-- <div>Icons made by <a href="https://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div> -->
</body>
</html>