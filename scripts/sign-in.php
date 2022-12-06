<?php
require('db.php');

if (!isset($_POST['uid'], $_POST['password'])) {
    // Could not get the data that should have been sent.
    echo json_encode("Please complete the registration form");
    die();
}
// Make sure the submitted registration values are not empty.
if (empty($_POST['uid'] || $_POST['password'])) {
    // One or more values are empty.
    echo json_encode("Please complete the registration form");
    die();
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
            $_SESSION['uid'] = $_POST['uid'];
            $_SESSION['password'] = $_POST['password'];
            $_SESSION['name'] = $username;

            //cookies
            if(isset($_POST["remember"])) {
                setcookie ('uid',$_POST['uid'],time()+ 3600,'/');
                setcookie ('password',$_POST['password'],time()+ 3600,'/');
                setcookie ('username',$username,time()+ 3600,'/');
            } else {
                setcookie ('uid',$_POST['uid'],time()+ 2,'/');
                setcookie ('password',$_POST['password'],time()+ 2,'/');
                setcookie ('username',$username,time()+ 2,'/');
            }
            echo json_encode("Success");
        } else {
            // Incorrect password
            echo json_encode("Incorrect username and/or password!");
            die();
        }
    } else {
        // Incorrect username
        echo json_encode("Incorrect username and/or password!");
        die();
    }
    $stmt->close();
    die();
}
?>