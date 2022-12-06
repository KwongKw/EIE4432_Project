<?php
session_start();
require("db.php");

// Second Check
if (!isset($_POST['topic'], $_POST['description'])) {
    // Could not get the data that should have been sent.
    echo json_encode("Please complete the registration form");
}
// Make sure the submitted registration values are not empty.
if (empty($_POST['topic'] || $_POST['description'])) {
    // One or more values are empty.
    echo json_encode("Please complete the registration form");
}

if ($stmt = $con->prepare('INSERT INTO ForumRecords (id, uid, topic, description, response) VALUES (null, ?, ?, ?, null)')) {
    // We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
    $stmt->bind_param('sss', $_SESSION['uid'], $_POST['topic'], $_POST['description']);
    $stmt->execute();
    echo json_encode("Upload Success, please wait patiently");
    if (empty($_COOKIE['uid'])) {
        setcookie('uid', $_SESSION['uid'], time() + 2, '/');
        setcookie('password', $_SESSION['password'], time() + 2, '/');
        setcookie('username', $_SESSION['username'], time() + 2, '/');
    }
} else {
    // Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
    echo json_encode("Could not prepare statement!");
}
?>