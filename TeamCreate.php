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
</head>
<body>
    
<?php
require ('Components/Navbar.php');
?>

<!-- Main Panel -->
<div class="container-fluid">
    <form action="Modules/Tcreate.php" method="POST">
        <label class="form-label" for="form1">Project</label>
        <select class="form-control">
            <option selected>Choose project ...</option>
                <?php
                    require ('Modules/db.php');

                    $sql = "SELECT Name FROM projects";
                    $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo '<option value = "' . $row['Name'] . '">' . $row['Name'] . '</option>';
                }
                
                ?>
        </select>
    <div class="row">

    </div>
        <?php

        $o = 1;

        $sql_name = '';

        $sql_role = '';

        $result = $conn->query($sql_name);

        $result_role = $conn->query($sql_role);

        ?>
    </form>
</div>

<!-- Main Panel -->
<!-- <div>Icons made by <a href="https://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div> -->
</body>
</html>