<?php
session_start();
echo '              
<thead>
<tr>
  <th scope="col">Case ID</th>
  <th scope="col">User ID</th>
  <th scope="col">Topic</th>
  <th scope="col">Description</th>
  <th scope="col">Response</th>
  <th scope="col" style="width: 200px;">Action</th>
</tr>
</thead>
<tbody >';

require("db.php");
$sql = "SELECT `id`, `uid`, `topic`, `description`, `response` FROM ForumRecords WHERE (`uid` LIKE  '%".$_REQUEST['q']."%' OR  `ruid` LIKE '%".$_REQUEST['q']."%')";
$stmt = mysqli_query($con, $sql);
while ($row = mysqli_fetch_assoc($stmt)) { // Important line !!!
    echo "<tr>";
    foreach ($row as $field => $value) { // If you want you can right this line like this: foreach($row as $value) {
        echo "<td>" . $value . "</td>";
    }
    echo '<td><ul class="list-inline">
                <li class="list-inline-item">
                    <a onclick="detail(' . $row['id'] . ')"><i class="fa fa-arrow-circle-o-up w3-large"></i></a>
                </li>';
    if ((!empty($_SESSION['uid'])) && $_SESSION['uid'] == 'admin') {

        echo '<li class="list-inline-item">
                <a onclick="del(' . $row['id'] . ')"><i class="fa fa-minus-circle w3-large"></i></a>
                </li>';
    }
    echo "</ul></td></tr>";
}
$stmt->close();
?>