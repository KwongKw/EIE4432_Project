<?php
require("db.php");
$sql = "SELECT * FROM ForumRecords WHERE id = ".$_GET["q"]."";
$stmt = mysqli_query($con, $sql);
while ($row = mysqli_fetch_assoc($stmt)) { // Important line !!!

    echo '<div class="w3-container modal-container">
    <label class="modal-label"><b>Case ID: ' . $row['id'] . '</b></label><br>
    </div>';
    echo '<div class="w3-container modal-container">
    <label class="modal-label"><b>User ID: ' . $row['uid'] . '</b></label><br>
    </div>';
    echo '<div class="w3-container modal-container">
    <label class="modal-label"><b>Topic: ' . $row['topic'] . '</b></label><br>
    </div>';
    echo '<div class="w3-container modal-container">
    <label class="modal-label"><b>Description: ' . $row['description'] . '</b></label><br>
    </div>';

    if (empty($row['response'])) {
        echo '<div class="w3-container modal-container-forum">
    <label class="modal-label" for="response"><b>Response</b></label><br>
    <textarea rows="6" cols="105" placeholder="Describe on something that can help on finding your lost item"
      name="response" required></textarea><br>
    <input type="hidden" name="id" value='. $row['id'] .'>
    </div>
    <div class="w3-container modal-container-last">
    <button class="w3-button modal-button" type="submit" style="margin-bottom: 20px">Submit</button>
    </div>
    ';
    } else {
        echo '<div class="w3-container modal-container">
    <label class="modal-label"><b>Response: ' . $row['response'] . '</b></label><br>
    </div>';
    }
}
?>