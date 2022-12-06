<?php
session_start();
require("db.php");

$sql = "DELETE FROM ForumRecords WHERE `id` = '". $_REQUEST['q'] ."'";

if ($con->query($sql) == TRUE) {
    echo json_encode("Record deleted successfully");
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