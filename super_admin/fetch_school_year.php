<?php


include '../include/database.php';

$db = new Connection();

$rows = $db->fetch_school_year();

echo json_encode($rows);