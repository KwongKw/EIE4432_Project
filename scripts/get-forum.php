<?php
require("db.php");
$sql = "SELECT * FROM ForumRecords";
$stmt = mysqli_query($con, $sql);
$count= 0;
while ($row = mysqli_fetch_assoc($stmt)) { // Important line !!!
    $count += 1;
    echo "<tr>";
    foreach ($row as $field => $value) { // If you want you can right this line like this: foreach($row as $value) {
        echo "<td>" . $value . "</td>"; 
    }
    echo '<td><ul class="list-inline">
                <li class="list-inline-item">
                    <a href="javascript:void('. $count .');"><i class="fa fa-arrow-circle-o-up"></i></a>
                </li>
                <li class="list-inline-item">
                    <a href="javascript:void('. $count .');"><i class="fa fa-hand-o-up"></i></a>
                </li>
                </ul>
        </td>';
    echo "</tr>";
}
$stmt->close();
?>