<?php
session_start();

require("db.php");
$sql = "SELECT * FROM ForumRecords";
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
                </li></ul>';
    }
    echo "</td></tr>";
}
$stmt->close();
?>