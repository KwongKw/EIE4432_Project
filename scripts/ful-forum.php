<?php
session_start();
require("db.php");

// Second Check
if (!isset($_POST['response'])) {
    // Could not get the data that should have been sent.
    echo json_encode("Please complete the registration form");
    die();
}
// Make sure the submitted registration values are not empty.
if (empty($_POST['response'])) {
    // One or more values are empty.
    echo json_encode("Please complete the registration form");
    die();
}

$sql = "UPDATE ForumRecords SET `response` = '". $_POST['response'] ."' WHERE id = '". $_POST["id"] ."'";

if ($con->query($sql) == TRUE) {
    echo json_encode("Record updated successfully");
    if (empty($_COOKIE['uid'])) {
        setcookie('uid', $_SESSION['uid'], time() + 2, '/');
        setcookie('password', $_SESSION['password'], time() + 2, '/');
        setcookie('username', $_SESSION['username'], time() + 2, '/');
    }
} else {
    echo json_encode("Error updating record: ");
    die();
}
$con->close();
?>