<?php
session_start();
require("db.php");

// Second Check
if (!isset($_POST['response'])) {
    // Could not get the data that should have been sent.
    echo json_encode("Please complete the registration form");
}
// Make sure the submitted registration values are not empty.
if (empty($_POST['response'])) {
    // One or more values are empty.
    echo json_encode("Please complete the registration form");
}

$sql = "UPDATE ForumRecords SET `response` = '". $_POST['response'] ."' WHERE id = '". $_POST["id"] ."'";

if ($con->query($sql) == TRUE) {
    echo json_encode("Record updated successfully");
} else {
    echo json_encode("Error updating record: ");
}

$con->close();
?>