<?php
session_start();
// Reseting Profile Session ID
unset($_SESSION['ID']);
// Redirecting to index.html
header('Location:../index.html');
?>