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
    <table class="table">
        <thead class="table-primary">
        <tr>
            <th>Nr.</th>
            <th>Name</th>
            <th>Email</th>
            <th>Position</th>
            <th>Team</th>
            <th>Location</th>     
            <th> <input class="form-control" type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.."></th>       
        </tr>  
        </thead>
        <tbody>
            <?php
                require('Modules/db.php');
                $sql = "Select * FROM clients";
                
                $i = '1';

                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    echo '<tr><td>' . $i++ . '</td><td>' . $row['name'] . ' ' . $row['surname'] . '</td><td>' . $row['Email'] . '</td><td>' . $row['role'] . '</td><td>';
                    $id = $row['ID'];
                    $sql_team = "SELECT name FROM Teams WHERE id = '$id'";
                    $result_team = $conn->query($sql_team);
                    while($row_team = $result_team->fetch_assoc()) {
                        echo $row_team ;
                    }

                    echo '</td><td>'. $row['location'] . '</td><td> <div class="dropdown">
                    <button
                      class="btn btn-primary dropdown-toggle"
                      type="button"
                      id="dropdownMenuButton"
                      data-mdb-toggle="dropdown"
                      aria-expanded="false"
                    >
                      Dropdown button
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <li><a class="dropdown-item" href="#">Action</a></li>
                      <li><a class="dropdown-item" href="#">Another action</a></li>
                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                  </div>' ;
                }
                $conn->close();
            ?>
        </tbody>
    </table>
</div>
<!-- Main Panel -->
<!-- <div>Icons made by <a href="https://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div> -->
</body>
</html>