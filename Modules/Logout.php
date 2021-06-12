<?php
session_start();
// Reseting Profile Session ID
unset($_SESSION['ID']);
// Redirecting to Login.htmls
header('Location:../Login.html');
?>