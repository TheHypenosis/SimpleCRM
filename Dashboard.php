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
</head>
<body>
    
<?php
require ('Components/Navbar.php');
?>

<!-- Main Panel -->
<div class="container">
    <div class="row">
        <div class="card col-5">
            <div class="card-body">
                <h5 class="card-title">Progress</h5>
                <div class="row">
                    <div class="card-text col-4" >
                    Some quick example text to build on the card title and make up the bulk of the
                    card's content.
                    </div>
                    <div class="card-text col-8">
                    Some quick example text to build on the card title and make up the bulk of the
                    card's content.
                    </div>
                </div>
            </div>
        </div>
        <div class="card col-4">
            <div class="card-body">
                <h5 class="card-title">Tasks</h5>
                <p class="card-text">
                    Some quick example text to build on the card title and make up the bulk of the
                    card's content.
                </p>
            </div>
        </div>
        <div class="card col-3">
            <div class="card-body">
                <h5 class="card-title">Task List</h5>
                <p class="card-text">
                    Some quick example text to build on the card title and make up the bulk of the
                    card's content.
                </p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card col-2">
            <div class="card-body">
                <h5 class="card-title">Notes</h5>
                <p class="card-text">
                    Some quick example text to build on the card title and make up the bulk of the
                    card's content.
                </p>
            </div>
        </div>
        <div class="card col-5">
            <div class="card-body">
                <h5 class="card-title">Health</h5>
                <p class="card-text">
                    Some quick example text to build on the card title and make up the bulk of the
                    card's content.
                </p>
            </div>
        </div>
        <div class="card col-5">
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