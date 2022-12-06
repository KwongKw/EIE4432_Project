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

$dropUserRecordsTable = "DROP TABLE IF EXISTS UserRecords";

$createUserRecordsTable = "CREATE TABLE UserRecords (
  `uid` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `birthday` date NOT NULL,
  `gender` varchar(1) NOT NULL,
  PRIMARY KEY (`uid`)
 ) ENGINE='MyISAM'  DEFAULT CHARSET='latin1'";

$addUserRecords = "REPLACE INTO UserRecords (`uid`, `password`, `username`, `email`, `birthday`, `gender`) VALUES
( 'admin'  , 'adminpass' , 'admin' , 'admin@example.com'  , 0 , 'O'),
( 'Tom101' , '12345'     , 'Tom'   , 'tom101@gmail.com'   , 0 , 'M'),
( 'Eric35' , '12345'     , 'Eric'  , 'eric35@gmail.com'   , 0 , 'M'),
( 'Mary33' , '12345'     , 'Mary'  , 'mary33@gmail.com'   , 0 , 'F'),
( 'Tom108' , '12345'     , 'Tom'   , 'tom108@hotmail.com' , 0 , 'M'),
( 'Joex77' , '12345'     , 'Joe'   , 'joe777@gmail.com'   , 0 , 'M'),
( 'Amy335' , '12345'     , 'Amy'   , 'may335@gmail.com'   , 0 , 'F'),
( 'David5' , '12345'     , 'David' , 'davidd@gmail.com'   , 0 , 'M'),
( 'Keith3' , '12345'     , 'Keith' , 'keith3@gmail.com'   , 0 , 'M');";

$dropForumRecordsTable = "DROP TABLE IF EXISTS ForumRecords";

$createForumRecordsTable = "CREATE TABLE ForumRecords (
  `id` int NOT NULL AUTO_INCREMENT,
  `uid` varchar(20) NOT NULL,
  `topic` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `ruid` varchar(20),
  `response` varchar(200),
  PRIMARY KEY (`id`)
 ) ENGINE='MyISAM'  DEFAULT CHARSET='latin1'";

$addForumRecords = "REPLACE INTO ForumRecords (id, uid, topic, description, ruid, response) VALUES
( 00001, 'Tom101' ,'Mobile Phone', 'Lost in Polyu A core', ''      , ''            ),
( 00002, 'Tom108' ,'Mobile Phone', 'Lost in Polyu B core', ''      , ''            ),
( 00003, 'Eric35' ,'Adaptor'     , 'Lost in Polyu C core', ''      , ''            ),
( 00004, 'Mary33' ,'Laptop'      , 'Lost in Polyu S core', 'Tom101', 'founded -Tom'),
( 00005, 'Joex77' ,'Wallet'      , 'Lost in Polyu D core', ''      , ''            ),
( 00006, 'Keith3' ,'Mobile Phone', 'Lost in Polyu G core', ''      , ''            ),
( 00007, 'Keith3' ,'Water Bottle', 'Lost in Polyu V core', ''      , ''            ),
( 00008, 'Tom101' ,'Wallet'      , 'Lost in Polyu Z core', 'Tom101', 'founded -Tom'),
( 00009, 'David5' ,'Keys'        , 'Lost in Polyu T core', ''      , ''            ),
( 00010, 'Amy335' ,'Book'        , 'Lost in Polyu P core', ''      , ''            );";

$result = mysqli_query($connect, $createAccount);

if (!$result) {
  die("Could not successfully run query ($createAccount) from $db: " .
    mysqli_error($connect));
} else {
  $result = mysqli_query($connect, $dropUserRecordsTable);
  if (!$result) {
    die("Could not successfully run query ($dropUserRecordsTable) from $db: " . mysqli_error($connect));
  } else {
    $result = mysqli_query($connect, $createUserRecordsTable);
    if (!$result) {
      die("Could not successfully run query ($createUserRecordsTable) from $db: " . mysqli_error($connect));
    } else {
      $result = mysqli_query($connect, $addUserRecords);
      if (!$result) {
        die("Could not successfully run query ($addUserRecords) from $db: " . mysqli_error($connect));
      } else {
        $result = mysqli_query($connect, $dropForumRecordsTable);
        if (!$result) {
          die("Could not successfully run query ($dropForumRecordsTable) from $db: " . mysqli_error($connect));
        } else {
          $result = mysqli_query($connect, $createForumRecordsTable);
          if (!$result) {
            die("Could not successfully run query ($createForumRecordsTable) from $db: " . mysqli_error($connect));
          } else {
            $result = mysqli_query($connect, $addForumRecords);
            if (!$result) {
              die("Could not successfully run query ($addForumRecords) from $db: " . mysqli_error($connect));
            } else {
              print("<html><head><title>MySQL Setup</title></head>
							<body><h1>MySQL Setup: SUCCESS!</h1><p>Created MySQL user <strong>wbip</strong> with 
							password <strong>wbip123</strong>, with all privileges on the 
							<strong>UserRecords</strong> database.</p><p>Created tables <strong>ForumRecords</strong> 
							and <strong>timesheet</strong> in the 
							<strong>test</strong> database.</p>
							</body></html>");
            }
          }
        }
      }
    }
  }
}
mysqli_close($connect); // close the connection
?>