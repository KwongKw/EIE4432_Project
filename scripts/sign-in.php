<?php
require('db.php');

if (!isset($_POST['uid'], $_POST['password'])) {
    // Could not get the data that should have been sent.
    echo '<script>alert("Please complete the registration form")</script>';
    exit('Please complete the registration form!');
}
// Make sure the submitted registration values are not empty.
if (empty($_POST['uid'] || $_POST['password'])) {
    // One or more values are empty.
    echo '<script>alert("Please complete the registration form")</script>';
    exit('Please complete the registration form');
}

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $con->prepare('SELECT uid, password FROM UserRecords WHERE uid = ?')) {
    // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
    $stmt->bind_param('s', $_POST['uid']);
    $stmt->execute();
    // Store the result so we can check if the account exists in the database.
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($username, $password);
        $stmt->fetch();
        // Account exists, now we verify the password.
        // Note: remember to use password_hash in your registration file to store the hashed passwords.
        if ($_POST['password'] == $password) {
            // Verification success! User has logged-in!
            // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
            session_regenerate_id();
            if ($_POST['remember'] == TRUE)
                $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $username;
            $_SESSION['uid'] = $_POST['uid'];
            echo '<script>alert("Welcome ' . $_SESSION['name'] . '!")</script>';
        } else {
            // Incorrect password
            echo '<script>alert("Incorrect username and/or password!")</script>';
        }
    } else {
        // Incorrect username
        echo '<script>alert("Incorrect username and/or password!")</script>';
    }

    $stmt->close();
}
?>