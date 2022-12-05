<?php
$server = "localhost";
$user = "root";
$pw = ""; // by default xammp root user has no password
$db = "Project";

$con = mysqli_connect($server, $user, $pw, $db);
// Check connection
if (mysqli_connect_errno()) {
    // If there is an error with the connection, stop the script and display the error.
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
?>