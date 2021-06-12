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
?>
<!-- Main Panel -->
<div class="container-fluid">
    <form action="../Modules/PAdd.php" method="POST">
    <?php
    //If the button clicked was in Notes card, echo the textarea
    //If the button clicked was something else, echo the text input and text area
        if($_POST['Add'] === 'Notes') {
        echo '<textarea class="form-control" id="textAreaExample" rows="4" name="desc"></textarea>
        <label class="form-label" for="textAreaExample">Note</label><br>
        <button type="submit" class="btn btn-secondary" name="Add" value="Notes">Submit</button>';
        }else {
        echo '<input type="text" id="form1" class="form-control" name="pname"/>
        <label class="form-label" for="form1">Task Name</label><br>
        <textarea class="form-control" id="textAreaExample" rows="4" name="desc"></textarea>
        <label class="form-label" for="textAreaExample">Description</label><br>';
        echo '<button type="submit" class="btn btn-secondary" name="Add" value="';
        //If the button clicked was in the Tasks card, set the submit value to Tasks 
            if ($_POST['Add'] === 'Tasks') {
                echo 'Tasks';
        //If the button clicked was in the Task_List card, set the submit value to Task_List 
            }elseif($_POST['Add'] === 'Task_List') {
                echo 'Task_List';
            }else{
                echo '';
            }
        echo '">Submit</button>';
        }
        ?>
    </form>
</div>

<!-- Main Panel -->
<!-- <div>Icons made by <a href="https://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div> -->
</body>
</html>