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
require ('Components/Navbar.php');
?>
<!-- Main Panel -->
<div class="container-fluid">
<!-- Creating a table for the output of members -->
    <table class="table table-light" id="myTable">
        <thead class="table-primary">
        <tr>
            <th onclick="sortTable(0)">Nr.</th>
            <th onclick="sortTable(1)">Name</th>
            <th onclick="sortTable(2)">Email</th>
            <th onclick="sortTable(3)">Position</th>
            <th onclick="sortTable(4)">Team</th>
            <th onclick="sortTable(5)">Location</th>  
            <!-- Search names from outputed members -->
            <th> <input class="form-control" type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.."></th>       
        </tr>  
        </thead>
        <tbody>
            <?php
              //Connection to the database
              require('Modules/db.php');
                //SQL Query responsible for Selecting everything from clients table
                $stmt =$conn->prepare("SELECT * FROM clients");
                $stmt->execute();
                $result = $stmt->get_result();
                $i = '1';
                //Fetching query results in table rows and cells
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                            <td>' . $i++ . '</td>
                            <td>' . $row['name'] . ' ' . $row['surname'] . '</td>
                            <td>' . $row['Email'] . '</td>
                            <td>' . $row['role'] . '</td>
                            <td>' . $row['team_id'] . '</td>
                            <td>' . $row['location'] . '</td>
                          </tr>' ;
                }
                $stmt->close();
            ?>
        </tbody>
    </table>
</div>

<script>

// Search Bar

function myFunction() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

// Search Bar

// Sort by

function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTable");
  switching = true;
  // Set the sorting direction to ascending:
  dir = "asc";
  /* Make a loop that will continue until
  no switching has been done: */
  while (switching) {
    // Start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /* Loop through all table rows (except the
    first, which contains table headers): */
    for (i = 1; i < (rows.length - 1); i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare,
      one from current row and one from the next: */
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /* Check if the two rows should switch place,
      based on the direction, asc or desc: */
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      // Each time a switch is done, increase this count by 1:
      switchcount ++;
    } else {
      /* If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again. */
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}

//Sort by
</script>
<!-- Main Panel -->
</body>
</html>