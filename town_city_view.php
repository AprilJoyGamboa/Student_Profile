<?php
include_once("db.php");
include_once("town_city.php");

$db = new Database();
$connection = $db->getConnection();
$student = new Student($db);

?>
