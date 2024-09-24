<?php

require '../server/config.php';
require 'sessionInfo.php';


if (isset($_GET["student_id"])) {
    $student_id = $_GET["student_id"];

    $sql = "DELETE FROM `400b_mark` WHERE student_id = '$student_id'";
    $result = $conn->query($sql);
}

header('location:400B_mark.php');
exit;



?>