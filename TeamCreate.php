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
        <select class="form-control" name='project'>
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

    </div>
    <?php
    $f = 0;
while($f<'5') {
    $f++;
    echo '<div class="row mb-2">
        <div class="col-1 ms-5">' .
            $f .
        '</div>
        <div class="col-4">
            <select class="form-control" name="person'. $f .'">';
                
                $o = 1;
                $sql_name = 'SELECT * FROM clients';
                $result = $conn->query($sql_name);
                    while($row =$result->fetch_assoc()) {
                        echo '<option  value="' . $row['ID']  .'">' . $row['name'] . ' ' . $row['surname'] . '</option>';
                        
                    }
                
            echo '</select>
        </div>
        <div class="col-4"><select name="Role'.$f.'" class="form-control">
            <option value="Role1">Role1</option>
            <option value="Role2">Role2</option>
            <option value="Role3">Role3</option>
            <option value="Role4">Role4</option>
            <option value="Role5">Role5</option></select>
        </div>
    </div>';
}
$conn->close();
    ?>

<button type="submit" class="btn btn-secondary">Submit</button>
    </form>
</div>

<!-- Main Panel -->
<!-- <div>Icons made by <a href="https://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div> -->
</body>
</html>