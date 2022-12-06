<?php
session_start();

require("db.php");
$sql = "SELECT `id`, `uid`, `topic`, `description`, `response` FROM ForumRecords WHERE `ruid` != ''";

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

echo '
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>

<div style="padding:32px 16px" class="w3-container">
<div class="row">
<div class="col-lg-12">
<div class="">
<div class="table-responsive">
<table class="table table-nowrap align-middle table-borderless" style="padding-top: 20px;">
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
<tbody>';

$sql = "SELECT `id`, `uid`, `topic`, `description`, `response` FROM ForumRecords WHERE `ruid` = ''";

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