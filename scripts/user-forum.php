<?php
session_start();
echo '              
<thead>
<tr>
  <th scope="col">User ID</th>
  <th scope="col">Username</th>
  <th scope="col">E-mail</th>
  <th scope="col">Gender</th>
  <th scope="col">Birthday</th>
</tr>
</thead>
<tbody >';
require("db.php");
$sql = "SELECT `uid`, `username`, `email`, `gender`, `birthday` FROM UserRecords ORDER BY `username`";
$stmt = mysqli_query($con, $sql);
while ($row = mysqli_fetch_assoc($stmt)) { // Important line !!!
    echo "<tr>";
    foreach ($row as $field => $value) { // If you want you can right this line like this: foreach($row as $value) {
        echo "<td>" . $value . "</td>";
    }
    echo "</tr>";
}
$stmt->close();
?>