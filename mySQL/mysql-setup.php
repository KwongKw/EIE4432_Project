<?php
$server = "localhost";
$user = "root";
$pw = ""; // by default xammp root user has no password
$db = "Project";

$connect = mysqli_connect($server, $user, $pw, $db);

if (!$connect) {
  die("ERROR: Cannot connect to database $db on server $server 
	using user name $user (" . mysqli_connect_errno() .
    ", " . mysqli_connect_error() . ")");
}

$createAccount = "GRANT ALL PRIVILEGES ON test.* TO 'wbip'@'localhost' IDENTIFIED BY 'wbip123' WITH GRANT OPTION";

// need this at start of the create table scripts? SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

$dropPersonnelTable = "DROP TABLE IF EXISTS UserRecords";

$createPersonnelTable = "CREATE TABLE UserRecords (
  `uid` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `birthday` date NOT NULL,
  `gender` varchar(1) NOT NULL,
  PRIMARY KEY (`uid`)
 ) ENGINE='MyISAM'  DEFAULT CHARSET='latin1'";

$addPersonnelRecords = "REPLACE INTO UserRecords (`uid`, `password`, `username`, `email`, `birthday`, `gender`) VALUES
('admin', '12345', 'na', 'na', 0, 'O')";

$result = mysqli_query($connect, $createAccount);

if (!$result) {
  die("Could not successfully run query ($createAccount) from $db: " .
    mysqli_error($connect));
} else {
  $result = mysqli_query($connect, $dropPersonnelTable);
  if (!$result) {
    die("Could not successfully run query ($dropPersonnelTable) from $db: " . mysqli_error($connect));
  } else {
    $result = mysqli_query($connect, $createPersonnelTable);
    if (!$result) {
      die("Could not successfully run query ($createPersonnelTable) from $db: " . mysqli_error($connect));
    } else {
      $result = mysqli_query($connect, $addPersonnelRecords);
      if (!$result) {
        die("Could not successfully run query ($addPersonnelRecords) from $db: " . mysqli_error($connect));
      } else {
        print("<html><head><title>MySQL Setup</title></head>
							<body><h1>MySQL Setup: SUCCESS!</h1><p>Created MySQL user <strong>wbip</strong> with 
							password <strong>wbip123</strong>, with all privileges on the 
							<strong>test</strong> database.</p><p>Created tables <strong>personnel</strong> 
							and <strong>timesheet</strong> in the 
							<strong>test</strong> database.</p>
							</body></html>");
      }
    }
  }
}

mysqli_close($connect); // close the connection

?>