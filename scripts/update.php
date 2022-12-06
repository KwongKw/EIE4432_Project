<?php
session_start();
require('db.php');

if ((!empty($_POST['email'])) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    echo json_encode("Email is not valid!");
    die();
}

if ((!empty($_POST['username'])) && preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) == 0) {
    echo json_encode("Username is not valid!");
    die();
}

if ((!empty($_POST['password'])) && (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5)) {
    echo json_encode("Password must be between 5 and 20 characters long!");
    die();
}

// We need to check if the account with that uid exists.
if ($stmt = $con->prepare('SELECT password, username, email FROM UserRecords WHERE uid = ?')) {
    // Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
    $stmt->bind_param('s', $_SESSION['uid']);
    $stmt->execute();
    $stmt->store_result();
    // Store the result so we can check if the account exists in the database.
    if ($stmt->num_rows > 0) {
        // UID already exists
        $stmt->bind_result($password, $username, $email);
        $stmt->fetch();
        // UID doesnt exists, insert new account
        if ($stmt = $con->prepare('UPDATE UserRecords SET `password` = ?, `username` = ?, `email` = ? WHERE uid = ?')) {
            // We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
            if (!empty($_POST['password']) && (isset($_POST['password'])))
                $password = $_POST['password'];
            if (!empty($_POST['username']) && (isset($_POST['username'])))
                $username = $_POST['username'];
            if (!empty($_POST['email']) && (isset($_POST['email'])))
                $email = $_POST['email'];
            $stmt->bind_param('ssss', $password, $username, $email, $_SESSION['uid']);
            $stmt->execute();
            echo json_encode("You have successfully updated your profile");
        } else {
            // Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
            echo json_encode("Could not prepare statement!");
            die();
        }
    } else {
        echo json_encode("User ID not exists, try harder!");
        die();
    }
    $stmt->close();
} else {
    // Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
    echo json_encode("Could not prepare statement!");
    die();
}

$con->close();
die();
?>